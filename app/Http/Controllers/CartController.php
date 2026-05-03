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

        $promoCode = $this->normalizePromoCode($validated['promo_code'] ?? session('promo_code'));

        if ($promoCode !== '' && ! $this->voucherFor($promoCode)) {
            return redirect()->route('cart.index')->withErrors(['promo_code' => 'That promo code is not valid. Try SWEET10 for 10% off.']);
        }

        $validated['promo_code'] = $promoCode ?: null;
        $totals = $this->calculateTotals($cart, $promoCode);
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
            session()->forget(['cart', 'promo_code']);

            return redirect()->route('track-order')->with('status', 'Order confirmed for cash on delivery.');
        }

        $checkoutUrl = $this->createPayMongoCheckoutSession($order);
        session(['paymongo_checkout_url' => $checkoutUrl]);

        return redirect()->away($checkoutUrl);
    }

    public function paymongoSuccess(): RedirectResponse
    {
        session()->forget(['cart', 'promo_code']);

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
        $promoCode = session('promo_code');
        $totals = $this->calculateTotals($cartItems, $promoCode);
        $voucher = $this->voucherFor($promoCode);

        return compact('cartItems', 'totals', 'promoCode', 'voucher');
    }

    private function calculateTotals($cartItems, ?string $promoCode = null): array
    {
        $subtotal = collect($cartItems)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $voucher = $this->voucherFor($promoCode);
        $discount = $voucher && $subtotal > 0
            ? round($subtotal * ($voucher['value'] / 100))
            : 0;
        $deliveryFee = $subtotal > 0 ? self::DELIVERY_FEE : 0;
        $taxableAmount = max(0, $subtotal - $discount);
        $tax = $taxableAmount > 0 ? round($taxableAmount * self::TAX_RATE) : 0;
        $total = $taxableAmount + $deliveryFee + $tax;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'delivery_fee' => $deliveryFee,
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

    private function createPayMongoCheckoutSession(array $order): string
    {
        $secretKey = config('services.paymongo.secret_key');

        abort_if(blank($secretKey), 500, 'PayMongo secret key is not configured.');

        $subtotal = max(1, collect($order['items'])->sum(fn ($item) => $item['price'] * $item['quantity']));
        $discountMultiplier = max(0, ($subtotal - $order['totals']['discount']) / $subtotal);

        $lineItems = collect($order['items'])->map(fn ($item) => [
            'currency' => 'PHP',
            'amount' => (int) round($item['price'] * $discountMultiplier * 100),
            'name' => $order['totals']['discount'] > 0 ? "{$item['name']} ({$order['totals']['promo_code']} applied)" : $item['name'],
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
