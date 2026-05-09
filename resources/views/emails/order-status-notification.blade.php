@php
    $title = match ($notificationType) {
        'placed' => 'Order placed successfully',
        \App\Models\Order::STATUS_OUT_FOR_DELIVERY => 'Your order is out for delivery',
        \App\Models\Order::STATUS_CANCELLED => 'Your order was cancelled',
        \App\Models\Order::STATUS_DELIVERED => 'Your order has been delivered',
        default => 'Order status update',
    };

    $message = match ($notificationType) {
        'placed' => 'Thank you for ordering from SugarLoom PH. We received your order and will prepare it soon.',
        \App\Models\Order::STATUS_OUT_FOR_DELIVERY => 'Your sweets are now with our Lalamove rider.',
        \App\Models\Order::STATUS_CANCELLED => 'Your order has been cancelled. If you have questions, please contact SugarLoom PH support.',
        \App\Models\Order::STATUS_DELIVERED => 'Your order has been delivered. We hope it made your day sweeter.',
        default => 'There is an update to your SugarLoom PH order.',
    };
@endphp

<div style="font-family: Arial, sans-serif; color: #2b1b24; line-height: 1.6;">
    <h1 style="color: #d8547b;">{{ $title }}</h1>
    <p>Hello {{ $order->customer_name }},</p>
    <p>{{ $message }}</p>

    @if($notificationType === \App\Models\Order::STATUS_OUT_FOR_DELIVERY)
        <div style="background: #fff1f2; border: 2px solid #fb7185; border-radius: 14px; padding: 18px; margin: 22px 0;">
            <div style="font-size: 13px; color: #9f1239; font-weight: 700; text-transform: uppercase;">Lalamove tracking number</div>
            <div style="font-size: 28px; color: #be123c; font-weight: 800; margin-top: 6px;">{{ $order->lalamove_tracking_number ?: 'To be provided' }}</div>
        </div>
    @endif

    <div style="background: #fafafa; border-radius: 12px; padding: 16px; margin-top: 20px;">
        <p style="margin: 0 0 8px;"><strong>Order:</strong> {{ $order->order_number }}</p>
        <p style="margin: 0 0 8px;"><strong>Status:</strong> {{ $order->status_label }}</p>
        <p style="margin: 0 0 8px;"><strong>Items:</strong> {{ $order->items_summary }}</p>
        <p style="margin: 0;"><strong>Total:</strong> PHP {{ number_format($order->total, 2) }}</p>
    </div>

    <p style="margin-top: 22px;">You can track your order anytime using your order number on the SugarLoom PH tracking page.</p>
</div>
