<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public string $notificationType,
    ) {
        $this->order->loadMissing('items');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: match ($this->notificationType) {
                'placed' => "We received your SugarLoom order {$this->order->order_number}",
                Order::STATUS_OUT_FOR_DELIVERY => "Your SugarLoom order {$this->order->order_number} is out for delivery",
                Order::STATUS_CANCELLED => "Your SugarLoom order {$this->order->order_number} was cancelled",
                Order::STATUS_DELIVERED => "Your SugarLoom order {$this->order->order_number} has been delivered",
                default => "SugarLoom order update for {$this->order->order_number}",
            },
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-notification',
        );
    }
}
