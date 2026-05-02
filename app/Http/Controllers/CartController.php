<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class CartController extends Controller
{
    private const DELIVERY_FEE = 150;
    private const TAX_RATE = 0.12;

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
        $cart = session('cart', []);

        $item = $cart[$product->id] ?? [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->short_description ?: $product->description,
            'price' => (float) $product->price,
            'image' => $product->image,
            'quantity' => 0,
        ];

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
        session()->forget('cart');

        return redirect()->route('cart.index')->with('status', 'Your cart is now empty.');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $cart = collect(session('cart', []));

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Add at least one item before checking out.']);
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:80'],
            'postal_code' => ['required', 'string', 'max:20'],
            'payment_method' => ['required', 'in:card,gcash,cod'],
            'promo_code' => ['nullable', 'string', 'max:40'],
        ]);

        $totals = $this->calculateTotals($cart);
        $orderNumber = 'SL-' . now()->format('His') . '-PH';
        $order = [
            'number' => $orderNumber,
            'customer' => $validated,
            'items' => $cart->values()->all(),
            'totals' => $totals,
            'payment_method' => $validated['payment_method'],
            'placed_at' => now()->toDateTimeString(),
        ];

        session(['latest_order' => $order]);

        if ($validated['payment_method'] === 'cod') {
            session()->forget('cart');

            return redirect()->route('track-order')->with('status', 'Order confirmed for cash on delivery.');
        }

        $checkoutUrl = $this->createPayMongoCheckoutSession($order);
        session(['paymongo_checkout_url' => $checkoutUrl]);

        return redirect()->away($checkoutUrl);
    }

    public function paymongoSuccess(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->route('track-order')->with('status', 'Payment received. Your order is now being prepared.');
    }

    public function paymongoCancel(): View
    {
        return view('payment-failed', [
            'message' => 'Payment failed, please try again.',
        ]);
    }

    private function cartViewData(): array
    {
        $cartItems = collect(session('cart', []))->values();
        $totals = $this->calculateTotals($cartItems);

        return compact('cartItems', 'totals');
    }

    private function calculateTotals($cartItems): array
    {
        $subtotal = collect($cartItems)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $deliveryFee = $subtotal > 0 ? self::DELIVERY_FEE : 0;
        $tax = $subtotal > 0 ? round($subtotal * self::TAX_RATE) : 0;
        $total = $subtotal + $deliveryFee + $tax;

        return [
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'tax' => $tax,
            'total' => $total,
        ];
    }

    private function createPayMongoCheckoutSession(array $order): string
    {
        $secretKey = config('services.paymongo.secret_key');

        abort_if(blank($secretKey), 500, 'PayMongo secret key is not configured.');

        $lineItems = collect($order['items'])->map(fn ($item) => [
            'currency' => 'PHP',
            'amount' => (int) round($item['price'] * 100),
            'name' => $item['name'],
            'quantity' => $item['quantity'],
        ])->values()->all();

        if ($order['totals']['delivery_fee'] > 0) {
            $lineItems[] = [
                'currency' => 'PHP',
                'amount' => (int) round($order['totals']['delivery_fee'] * 100),
                'name' => 'Delivery Fee',
                'quantity' => 1,
            ];
        }

        if ($order['totals']['tax'] > 0) {
            $lineItems[] = [
                'currency' => 'PHP',
                'amount' => (int) round($order['totals']['tax'] * 100),
                'name' => 'Tax',
                'quantity' => 1,
            ];
        }

        $paymentMethods = $order['payment_method'] === 'gcash' ? ['gcash'] : ['card'];

        $response = Http::withBasicAuth($secretKey, '')
            ->acceptJson()
            ->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'name' => $order['customer']['full_name'],
                            'email' => $order['customer']['email'],
                            'phone' => $order['customer']['phone'],
                            'address' => [
                                'line1' => $order['customer']['shipping_address'],
                                'city' => $order['customer']['city'],
                                'postal_code' => $order['customer']['postal_code'],
                                'country' => 'PH',
                            ],
                        ],
                        'description' => "SugarLoom PH order {$order['number']}",
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
}
