<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('items')
            ->latest('placed_at')
            ->latest()
            ->take(10)
            ->get();

        $activeStatuses = [
            Order::STATUS_PENDING,
            Order::STATUS_PREPARING,
            Order::STATUS_OUT_FOR_DELIVERY,
        ];

        $totalSales = Order::where('status', '!=', Order::STATUS_CANCELLED)->sum('total');
        $activeOrders = Order::whereIn('status', $activeStatuses)->count();
        $lowStockCount = Product::where('stock_quantity', '<=', 10)->count();
        $weeklyOrders = Order::where('placed_at', '>=', now()->subDays(6)->startOfDay())->get();
        $maxDailyOrders = max(1, $weeklyOrders->groupBy(fn (Order $order) => $order->placed_at->toDateString())->map->count()->max() ?? 1);

        $demandData = collect(range(6, 0))
            ->map(function (int $daysAgo) use ($weeklyOrders, $maxDailyOrders) {
                $date = now()->subDays($daysAgo)->toDateString();
                $count = $weeklyOrders->filter(fn (Order $order) => $order->placed_at->toDateString() === $date)->count();

                return max(12, (int) round(($count / $maxDailyOrders) * 140));
            })
            ->all();

        $nextDelivery = Order::whereIn('status', $activeStatuses)
            ->oldest('placed_at')
            ->first()
            ?->placed_at
            ?->diffForHumans();

        $trending = OrderItem::query()
            ->selectRaw('product_name, SUM(quantity) as total_quantity')
            ->whereHas('order', fn ($query) => $query->where('placed_at', '>=', now()->subDays(7)))
            ->groupBy('product_name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        // Analytics Data
        $allRecentOrders = Order::with('items')
            ->where('status', '!=', Order::STATUS_CANCELLED)
            ->where('placed_at', '>=', now()->subDays(13)->startOfDay())
            ->get();

        $lineLabels = collect(range(13, 0))->map(fn (int $daysAgo) => now()->subDays($daysAgo)->format('M d'));
        $lineRevenue = $lineLabels->map(function (string $label) use ($allRecentOrders) {
            return round($allRecentOrders
                ->filter(fn (Order $order) => $order->placed_at?->format('M d') === $label)
                ->sum('total'), 2);
        });

        $topProducts = OrderItem::query()
            ->selectRaw('product_name, SUM(quantity) as total_quantity')
            ->whereHas('order', fn ($query) => $query->where('status', '!=', Order::STATUS_CANCELLED))
            ->groupBy('product_name')
            ->orderByDesc('total_quantity')
            ->take(8)
            ->get();

        $statusCounts = Order::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $monthlyRevenue = Order::where('status', '!=', Order::STATUS_CANCELLED)
            ->where('placed_at', '>=', now()->startOfMonth())
            ->sum('total');

        return view('dashboard', [
            'totalSales' => $totalSales,
            'salesProgress' => min(100, (int) round(($totalSales / 100000) * 100)),
            'activeOrders' => $activeOrders,
            'nextDelivery' => $nextDelivery ?: 'no active deliveries',
            'lowStockCount' => $lowStockCount,
            'demandData' => $demandData,
            'orders' => $orders,
            'statuses' => Order::statuses(),
            'trending' => $trending,
            // Analytics
            'lineLabels' => $lineLabels->values(),
            'lineRevenue' => $lineRevenue->values(),
            'barLabels' => $topProducts->pluck('product_name')->values(),
            'barValues' => $topProducts->pluck('total_quantity')->map(fn ($value) => (int) $value)->values(),
            'pieLabels' => collect(Order::statuses())->values(),
            'pieValues' => collect(array_keys(Order::statuses()))->map(fn (string $status) => (int) ($statusCounts[$status] ?? 0))->values(),
            'monthlyRevenue' => $monthlyRevenue,
            'ordersThisMonth' => Order::where('placed_at', '>=', now()->startOfMonth())->count(),
            'averageOrderValue' => Order::where('status', '!=', Order::STATUS_CANCELLED)->avg('total') ?? 0,
        ]);
    }

    public function inventory(Request $request): View
    {
        $query = Product::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'hidden') {
                $query->where('is_active', false);
            } elseif ($request->status === 'low_stock') {
                $query->where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0);
            } elseif ($request->status === 'out_of_stock') {
                $query->where('stock_quantity', 0);
            }
        }

        $products = $query->orderBy('name')->get();

        return view('admin.inventory', [
            'products' => $products,
            'hasFilters' => $request->anyFilled(['search', 'category', 'status']),
        ]);
    }

    public function users(): View
    {
        $users = User::query()
            ->latest()
            ->paginate(12);

        $userSummary = [
            'total' => User::count(),
            'admins' => User::where('role', User::ROLE_ADMIN)->count(),
            'customers' => User::where('role', User::ROLE_CUSTOMER)->count(),
        ];

        return view('admin.users', [
            'users' => $users,
            'userSummary' => $userSummary,
        ]);
    }

    public function createUser(): View
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'shipping_address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:80', Rule::in(config('sugarloom.metro_manila_cities', []))],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_CUSTOMER])],
            'reward_points' => ['nullable', 'integer', 'min:0'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'shipping_address' => $validated['shipping_address'] ?: null,
            'city' => $validated['city'] ?: null,
            'postal_code' => $validated['postal_code'] ?: null,
            'role' => $validated['role'],
            'reward_points' => (int) ($validated['reward_points'] ?? 0),
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.user_index')->with('status', 'User account created successfully.');
    }

    public function editUser(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'shipping_address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:80', Rule::in(config('sugarloom.metro_manila_cities', []))],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_CUSTOMER])],
            'reward_points' => ['nullable', 'integer', 'min:0'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'shipping_address' => $validated['shipping_address'] ?: null,
            'city' => $validated['city'] ?: null,
            'postal_code' => $validated['postal_code'] ?: null,
            'reward_points' => (int) ($validated['reward_points'] ?? 0),
        ]);

        if ($user->id === Auth::id()) {
            $user->role = User::ROLE_ADMIN;
        } else {
            $user->role = $validated['role'];
        }

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.user_index')->with('status', 'User account updated successfully.');
    }

    public function destroyUser(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.user_index')->withErrors([
                'user' => 'You cannot remove your own admin account.',
            ]);
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.user_index')->with('status', "{$userName} was removed successfully.");
    }

    public function createProduct(): View
    {
        $categories = ['sweet', 'savory', 'specialty'];
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(ProductUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Handle checkboxes (since they won't be in the request if unchecked)
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_bakers_choice'] = $request->boolean('is_bakers_choice', false);
        $validated['is_top_pick'] = $request->boolean('is_top_pick', false);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = 'storage/' . $imagePath;
        }

        // If this product is set as Baker's Choice, unset it from all others
        if ($validated['is_bakers_choice']) {
            Product::where('is_bakers_choice', true)->update(['is_bakers_choice' => false]);
        }

        // If this product is set as Top Pick, unset it from all others
        if ($validated['is_top_pick']) {
            Product::where('is_top_pick', true)->update(['is_top_pick' => false]);
        }

        $product = Product::create($validated);

        return redirect()->route('admin.inventory')->with('status', "{$product->name} has been added to inventory.");
    }

    public function destroyProduct(Product $product): RedirectResponse
    {
        $name = $product->name;
        
        // Delete image if exists
        if ($product->image && Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
        }

        $product->delete();

        return redirect()->route('admin.inventory')->with('status', "{$name} has been removed from inventory.");
    }

    public function orders(): View
    {
        $orders = Order::with('items')
            ->latest('placed_at')
            ->latest()
            ->paginate(8);

        return view('admin.orders', [
            'orders' => $orders,
            'statuses' => Order::statuses(),
        ]);
    }

    public function createOrder(): View
    {
        $products = Product::active()->orderBy('name')->get();
        return view('admin.orders.create', compact('products'));
    }

    public function storeOrder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $subtotal = 0;
                $orderItems = [];

                foreach ($validated['items'] as $itemData) {
                    $product = Product::findOrFail($itemData['product_id']);
                    $quantity = $itemData['quantity'];
                    
                    if ($product->stock_quantity < $quantity) {
                        throw new \Exception("Insufficient stock for {$product->name}. Only {$product->stock_quantity} left.");
                    }

                    $lineTotal = $product->price * $quantity;
                    $subtotal += $lineTotal;

                    $orderItems[] = new OrderItem([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'unit_price' => $product->price,
                        'quantity' => $quantity,
                        'line_total' => $lineTotal,
                    ]);

                    $product->decrement('stock_quantity', $quantity);
                }

                $order = Order::create([
                    'order_number' => 'WALK-' . strtoupper(uniqid()),
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'] ?? 'walkin@sugarloom.ph',
                    'customer_phone' => $validated['customer_phone'] ?? 'N/A',
                    'shipping_address' => 'Walk-in Store',
                    'city' => 'Manila',
                    'postal_code' => '1000',
                    'payment_method' => 'cash',
                    'payment_status' => Order::PAYMENT_PAID,
                    'status' => Order::STATUS_DELIVERED,
                    'subtotal' => $subtotal,
                    'total' => $subtotal,
                    'placed_at' => now(),
                ]);

                $order->items()->saveMany($orderItems);
            });
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.orders')->with('status', 'Walk-in order recorded successfully.');
    }

    public function editProduct(Product $product): View
    {
        $categories = ['sweet', 'savory', 'specialty'];

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function updateProduct(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();

        // Handle checkboxes
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_bakers_choice'] = $request->boolean('is_bakers_choice');
        $validated['is_top_pick'] = $request->boolean('is_top_pick');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image && Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
            }

            // Store new image
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = 'storage/' . $imagePath;
        }

        // If this product is being set as Baker's Choice, unset it from all others
        if ($validated['is_bakers_choice']) {
            Product::where('id', '!=', $product->id)
                ->where('is_bakers_choice', true)
                ->update(['is_bakers_choice' => false]);
        }

        // If this product is being set as Top Pick, unset it from all others
        if ($validated['is_top_pick']) {
            Product::where('id', '!=', $product->id)
                ->where('is_top_pick', true)
                ->update(['is_top_pick' => false]);
        }

        $product->update($validated);

        return redirect()->route('admin.inventory')->with('status', "{$product->name} has been updated successfully.");
    }

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::statuses()))],
            'lalamove_tracking_number' => [
                Rule::requiredIf($request->status === Order::STATUS_OUT_FOR_DELIVERY),
                'nullable',
                'string',
                'max:120',
            ],
        ]);

        $shouldNotify = false;
        $notificationStatus = null;

        DB::transaction(function () use ($order, $validated, &$shouldNotify, &$notificationStatus) {
            $previousStatus = $order->status;
            $newStatus = $validated['status'];

            $order->loadMissing('items.product');

            if ($previousStatus !== Order::STATUS_CANCELLED && $newStatus === Order::STATUS_CANCELLED) {
                foreach ($order->items as $item) {
                    $item->product?->increment('stock_quantity', $item->quantity);
                }
            }

            if ($previousStatus === Order::STATUS_CANCELLED && $newStatus !== Order::STATUS_CANCELLED) {
                foreach ($order->items as $item) {
                    $item->product?->decrement('stock_quantity', $item->quantity);
                }
            }

            $updates = [
                'status' => $newStatus,
            ];

            if (array_key_exists('lalamove_tracking_number', $validated)) {
                $updates['lalamove_tracking_number'] = $validated['lalamove_tracking_number'];
            }

            $order->update($updates);

            if ($previousStatus !== $newStatus && in_array($newStatus, [
                Order::STATUS_PREPARING,
                Order::STATUS_OUT_FOR_DELIVERY,
                Order::STATUS_CANCELLED,
                Order::STATUS_DELIVERED,
            ], true)) {
                $shouldNotify = true;
                $notificationStatus = $newStatus;
            }
        });

        if ($validated['status'] === Order::STATUS_DELIVERED) {
            $order->update(['payment_status' => Order::PAYMENT_PAID]);
        }

        if ($shouldNotify && $notificationStatus) {
            try {
                Mail::to($order->customer_email)->send(new OrderStatusNotification($order->fresh('items'), $notificationStatus));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return back()->with('status', "{$order->order_number} status updated.");
    }

    /**
     * Stream a CSV export of all orders.
     */
    public function exportReport()
    {
        $fileName = 'sugarloom_sales_report_' . now()->format('Y_m_d_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() {
            // Open a stream straight to the browser (no physical file saved on server)
            $file = fopen('php://output', 'w');
            
            // Add BOM to fix UTF-8 in Excel
            fputs($file, $bom =(chr(0xEF) . chr(0xBB) . chr(0xBF)));

            // Write the Header Row
            fputcsv($file, [
                'Order Number', 
                'Date Placed',
                'Customer Name', 
                'Email', 
                'Order Status', 
                'Payment Method', 
                'Payment Status', 
                'Items Summary',
                'Subtotal (PHP)', 
                'Discount (PHP)', 
                'Points Discount (PHP)',
                'Delivery Fee (PHP)', 
                'Total (PHP)'
            ]);

            // Use cursor() to fetch one row at a time to prevent memory crashes
            $orders = \App\Models\Order::with('items')->latest('placed_at')->cursor();

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->placed_at ? $order->placed_at->format('M d, Y h:i A') : 'N/A',
                    $order->customer_name,
                    $order->customer_email,
                    $order->status_label, // Uses your model's accessor
                    strtoupper($order->payment_method),
                    ucfirst($order->payment_status),
                    $order->items_summary, // Uses your model's accessor
                    $order->subtotal,
                    $order->discount,
                    $order->points_discount,
                    $order->delivery_fee,
                    $order->total
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}