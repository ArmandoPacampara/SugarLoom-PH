<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusNotification;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CartController extends Controller
{
    private const TAX_RATE = 0.12;
    private const VOUCHERS = [
        'SWEET10' => [
            'label' => 'SWEET10 voucher',
            'type' => 'percent',
            'value' => 10,
        ],
    ];

    public function index(): View
    {
        return view('checkout', $this->cartViewData());
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::active()->findOrFail($validated['product_id']);
        $quantity = $validated['quantity'] ?? 1;

        // Check if product is in stock
        if ($product->isOutOfStock()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "{$product->name} is out of stock.",
                ], 400);
            }
            return redirect()->route('cart.index')->with('error', "{$product->name} is out of stock.");
        }

        // Check if requested quantity exceeds available stock
        if ($quantity > $product->stock_quantity) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$product->stock_quantity} item(s) of {$product->name} available.",
                ], 400);
            }
            return redirect()->route('cart.index')->with('error', "Only {$product->stock_quantity} item(s) of {$product->name} available.");
        }

        $cart = session('cart', []);

        $item = $cart[$product->id] ?? [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->short_description ?: $product->description,
            'price' => (float) $product->price,
            'image' => $product->image,
            'quantity' => 0,
        ];

        // Check if total quantity in cart would exceed stock
        $totalQuantity = $item['quantity'] + $quantity;
        if ($totalQuantity > $product->stock_quantity) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$product->stock_quantity} item(s) of {$product->name} available. You have {$item['quantity']} in your cart.",
                ], 400);
            }
            return redirect()->route('cart.index')->with('error', "Only {$product->stock_quantity} item(s) of {$product->name} available. You have {$item['quantity']} in your cart.");
        }

        $item['quantity'] += $quantity;
        $cart[$product->id] = $item;
        session(['cart' => $cart]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'count' => collect($cart)->sum('quantity'),
            ]);
        }

        return redirect()->route('cart.index')->with('status', "{$product->name} was added to your cart.");
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $validated['quantity'];
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index');
    }

    public function remove(int $id): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('status', 'Item removed from your cart.');
    }

    public function clear(): RedirectResponse
    {
        session()->forget(['cart', 'promo_code']);

        return redirect()->route('cart.index')->with('status', 'Your cart is now empty.');
    }

    public function applyPromo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'promo_code' => ['nullable', 'string', 'max:40'],
        ]);

        $promoCode = $this->normalizePromoCode($validated['promo_code'] ?? null);

        if ($promoCode === '') {
            session()->forget('promo_code');

            return redirect()->route('cart.index')->with('status', 'Promo code removed.');
        }

        if (! $this->voucherFor($promoCode)) {
            session()->forget('promo_code');

            return redirect()->route('cart.index')->withErrors(['promo_code' => 'That promo code is not valid. Try SWEET10 for 10% off.']);
        }

        session(['promo_code' => $promoCode]);

        return redirect()->route('cart.index')->with('status', "{$promoCode} applied. You got 10% off your subtotal.");
    }

    public function checkout(Request $request): RedirectResponse
    {
        $cart = collect(session('cart', []));

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Add at least one item before checking out.']);
        }

        // Validate stock before processing checkout
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product || $product->isOutOfStock()) {
                return redirect()->route('cart.index')->with('error', "{$item['name']} is no longer in stock. Please update your cart.");
            }
            if ($item['quantity'] > $product->stock_quantity) {
                return redirect()->route('cart.index')->with('error', "Only {$product->stock_quantity} item(s) of {$item['name']} available. Please update your cart.");
            }
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:80', Rule::in($this->metroManilaCities())],
            'postal_code' => ['required', 'string', 'max:20'],
            'payment_method' => ['required', 'in:card,gcash'],
            'promo_code' => ['nullable', 'string', 'max:40'],
        ]);

        $promoCode = $this->normalizePromoCode($validated['promo_code'] ?? session('promo_code'));

        if ($promoCode !== '' && ! $this->voucherFor($promoCode)) {
            return redirect()->route('cart.index')->withErrors(['promo_code' => 'That promo code is not valid. Try SWEET10 for 10% off.']);
        }

        $validated['promo_code'] = $promoCode ?: null;
        $totals = $this->calculateTotals($cart, $promoCode);
        $order = $this->createOrder($cart, $validated, $totals);
        $this->sendOrderNotification($order, 'placed');

        session([
            'latest_order_id' => $order->id,
            'latest_order_number' => $order->order_number,
        ]);

        $checkoutUrl = $this->createPayMongoCheckoutSession($order);
        session(['paymongo_checkout_url' => $checkoutUrl]);

        return redirect()->away($checkoutUrl);
    }

    public function paymongoSuccess(): RedirectResponse
    {
        session()->forget(['cart', 'promo_code']);

        if ($orderId = session('latest_order_id')) {
            Order::whereKey($orderId)->update([
                'payment_status' => Order::PAYMENT_PAID,
                'status' => Order::STATUS_PREPARING,
            ]);
        }

        return redirect()
            ->route('track-order', ['tracking_number' => session('latest_order_number')])
            ->with('status', 'Payment received. Your order is now being prepared.');
    }

    public function paymongoCancel(): View
    {
        if ($orderId = session('latest_order_id')) {
            $order = Order::with('items.product')->find($orderId);

            if ($order && $order->status !== Order::STATUS_CANCELLED) {
                DB::transaction(function () use ($order) {
                    foreach ($order->items as $item) {
                        $item->product?->increment('stock_quantity', $item->quantity);
                    }

                    $order->update(['status' => Order::STATUS_CANCELLED]);
                });

                $this->sendOrderNotification($order->fresh('items'), Order::STATUS_CANCELLED);
            }
        }

        return view('payment-failed', [
            'message' => 'Payment failed, please try again.',
        ]);
    }

    private function cartViewData(): array
    {
        $cartItems = collect(session('cart', []))->values();
        $promoCode = session('promo_code');
        $totals = $this->calculateTotals($cartItems, $promoCode);
        $voucher = $this->voucherFor($promoCode);
        $metroManilaCities = $this->metroManilaCities();

        return compact('cartItems', 'totals', 'promoCode', 'voucher', 'metroManilaCities');
    }

    private function calculateTotals($cartItems, ?string $promoCode = null): array
    {
        $subtotal = collect($cartItems)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $voucher = $this->voucherFor($promoCode);
        $discount = $voucher && $subtotal > 0
            ? round($subtotal * ($voucher['value'] / 100))
            : 0;
        $taxableAmount = max(0, $subtotal - $discount);
        $tax = $taxableAmount > 0 ? round($taxableAmount * self::TAX_RATE) : 0;
        $total = $taxableAmount + $tax;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'delivery_fee' => 0,
            'tax' => $tax,
            'total' => $total,
            'promo_code' => $voucher ? $promoCode : null,
            'promo_label' => $voucher['label'] ?? null,
        ];
    }

    private function normalizePromoCode(?string $promoCode): string
    {
        return strtoupper(trim((string) $promoCode));
    }

    private function voucherFor(?string $promoCode): ?array
    {
        $promoCode = $this->normalizePromoCode($promoCode);

        return self::VOUCHERS[$promoCode] ?? null;
    }

    private function createPayMongoCheckoutSession(Order $order): string
    {
        $secretKey = config('services.paymongo.secret_key');

        abort_if(blank($secretKey), 500, 'PayMongo secret key is not configured.');

        $order->loadMissing('items');
        $subtotal = max(1, $order->items->sum(fn ($item) => $item->unit_price * $item->quantity));
        $discountMultiplier = max(0, ($subtotal - (float) $order->discount) / $subtotal);

        $lineItems = $order->items->map(fn ($item) => [
            'currency' => 'PHP',
            'amount' => (int) round($item->unit_price * $discountMultiplier * 100),
            'name' => $order->discount > 0 ? "{$item->product_name} ({$order->promo_code} applied)" : $item->product_name,
            'quantity' => $item->quantity,
        ])->values()->all();

        if ($order->tax > 0) {
            $lineItems[] = [
                'currency' => 'PHP',
                'amount' => (int) round($order->tax * 100),
                'name' => 'Tax',
                'quantity' => 1,
            ];
        }

        $paymentMethods = $order->payment_method === 'gcash' ? ['gcash'] : ['card'];

        $response = Http::withBasicAuth($secretKey, '')
            ->acceptJson()
            ->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'name' => $order->customer_name,
                            'email' => $order->customer_email,
                            'phone' => $order->customer_phone,
                            'address' => [
                                'line1' => $order->shipping_address,
                                'city' => $order->city,
                                'postal_code' => $order->postal_code,
                                'country' => 'PH',
                            ],
                        ],
                        'description' => "SugarLoom PH order {$order->order_number}",
                        'line_items' => $lineItems,
                        'payment_method_types' => $paymentMethods,
                        'send_email_receipt' => true,
                        'show_description' => true,
                        'show_line_items' => true,
                        'success_url' => route('checkout.success'),
                        'cancel_url' => route('checkout.failed'),
                    ],
                ],
            ]);

        if ($response->failed()) {
            report('PayMongo checkout failed: ' . $response->body());
            abort(502, 'Unable to start PayMongo checkout. Please try again.');
        }

        return $response->json('data.attributes.checkout_url');
    }

    private function createOrder($cart, array $customer, array $totals): Order
    {
        return DB::transaction(function () use ($cart, $customer, $totals) {
            $products = Product::whereIn('id', $cart->keys())->lockForUpdate()->get()->keyBy('id');

            foreach ($cart as $item) {
                $product = $products->get($item['id']);

                if (! $product || ! $product->is_active) {
                    abort(422, "{$item['name']} is no longer available.");
                }

                if ($product->stock_quantity < $item['quantity']) {
                    abort(422, "Only {$product->stock_quantity} {$product->name} left in stock.");
                }
            }

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => Auth::id(),
                'customer_name' => $customer['full_name'],
                'customer_email' => $customer['email'],
                'customer_phone' => $customer['phone'],
                'shipping_address' => $customer['shipping_address'],
                'city' => $customer['city'],
                'postal_code' => $customer['postal_code'],
                'payment_method' => $customer['payment_method'],
                'payment_status' => Order::PAYMENT_PENDING,
                'status' => Order::STATUS_PENDING,
                'subtotal' => $totals['subtotal'],
                'discount' => $totals['discount'],
                'delivery_fee' => $totals['delivery_fee'],
                'tax' => $totals['tax'],
                'total' => $totals['total'],
                'promo_code' => $totals['promo_code'],
                'placed_at' => now(),
            ]);

            foreach ($cart as $item) {
                $product = $products->get($item['id']);

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'line_total' => $item['price'] * $item['quantity'],
                    'product_snapshot' => [
                        'image' => $product->image,
                        'category' => $product->category,
                    ],
                ]);

                $product->decrement('stock_quantity', $item['quantity']);
            }

            return $order;
        });
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'SL-' . now()->format('Ymd-His') . '-' . random_int(100, 999);
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }

    private function sendOrderNotification(Order $order, string $notificationType): void
    {
        Mail::to($order->customer_email)->send(new OrderStatusNotification($order, $notificationType));
    }

    private function metroManilaCities(): array
    {
        return [
            'Quezon City',
            'Manila',
            'Makati',
            'Pasig',
            'Taguig',
            'Pasay',
            'Mandaluyong',
            'Marikina',
            'Paranaque',
            'Las Pinas',
            'Muntinlupa',
            'San Juan',
            'Caloocan',
            'Malabon',
            'Navotas',
            'Valenzuela',
            'Pateros',
        ];
    }
}
