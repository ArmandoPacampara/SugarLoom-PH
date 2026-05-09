<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackOrderController extends Controller
{
    public function index(Request $request): View
    {
        $trackingNumber = trim((string) $request->query('tracking_number'));
        $order = null;

        if ($trackingNumber !== '') {
            $order = Order::with('items')
                ->where('order_number', $trackingNumber)
                ->first();
        }

        return view('track-order', [
            'trackingNumber' => $trackingNumber,
            'order' => $order,
            'steps' => [
                Order::STATUS_PENDING => [
                    'label' => 'Order Confirmed',
                    'description' => 'We have received your order.',
                ],
                Order::STATUS_PREPARING => [
                    'label' => 'Preparing Sweets',
                    'description' => 'Our bakers are preparing your items.',
                ],
                Order::STATUS_OUT_FOR_DELIVERY => [
                    'label' => 'Out for Delivery',
                    'description' => 'Your order is with the rider.',
                ],
                Order::STATUS_DELIVERED => [
                    'label' => 'Delivered',
                    'description' => 'Your order has been delivered.',
                ],
            ],
        ]);
    }
}
