<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        ]);
    }

    public function inventory(): View
    {
        $products = Product::orderBy('name')->get();

        return view('admin.inventory', [
            'products' => $products,
        ]);
    }

    public function orders(): View
    {
        $orders = Order::with('items')
            ->latest('placed_at')
            ->latest()
            ->paginate(12);

        return view('admin.orders', [
            'orders' => $orders,
            'statuses' => Order::statuses(),
        ]);
    }

    public function analytics(): View
    {
        $orders = Order::with('items')
            ->where('status', '!=', Order::STATUS_CANCELLED)
            ->where('placed_at', '>=', now()->subDays(13)->startOfDay())
            ->get();

        $lineLabels = collect(range(13, 0))->map(fn (int $daysAgo) => now()->subDays($daysAgo)->format('M d'));
        $lineRevenue = $lineLabels->map(function (string $label) use ($orders) {
            return round($orders
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

        return view('admin.analytics', [
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

    public function editProduct(Product $product): View
    {
        $categories = ['sweet', 'savory', 'beverage', 'specialty'];

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function updateProduct(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = 'storage/' . $imagePath;
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
            Mail::to($order->customer_email)->send(new OrderStatusNotification($order->fresh('items'), $notificationStatus));
        }

        return back()->with('status', "{$order->order_number} status updated.");
    }

    public function updateProductStock(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'stock_quantity' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);

        $product->update(['stock_quantity' => $validated['stock_quantity']]);

        return redirect()->route('admin.dashboard')->with('status', "{$product->name} stock updated.");
    }
}
