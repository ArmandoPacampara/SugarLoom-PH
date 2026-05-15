<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PREPARING = 'preparing';
    public const STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';

    public const PAYMENT_PENDING = 'pending';
    public const PAYMENT_PAID = 'paid';

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'city',
        'postal_code',
        'payment_method',
        'payment_status',
        'status',
        'lalamove_tracking_number',
        'lalamove_quotation_id',
        'subtotal',
        'discount',
        'points_redeemed',
        'points_discount',
        'delivery_fee',
        'delivery_lat',
        'delivery_lng',
        'lalamove_quote_expires_at',
        'tax',
        'total',
        'promo_code',
        'placed_at',
        'rating',
        'review_comment',
        'reviewed_at',
        'review_reward_points_awarded',
        'review_reward_points',
        'address_validation_status',
        'address_validation_message',
        'address_validation_overridden',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'points_redeemed' => 'integer',
        'points_discount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'delivery_lat' => 'decimal:7',
        'delivery_lng' => 'decimal:7',
        'lalamove_quote_expires_at' => 'datetime',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'placed_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'review_reward_points_awarded' => 'boolean',
        'review_reward_points' => 'integer',
        'address_validation_overridden' => 'boolean',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PREPARING => 'Preparing',
            self::STATUS_OUT_FOR_DELIVERY => 'Out for Delivery',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statuses()[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getItemsSummaryAttribute(): string
    {
        return $this->items
            ->map(fn (OrderItem $item) => "{$item->quantity}x {$item->product_name}")
            ->join(', ');
    }
}
