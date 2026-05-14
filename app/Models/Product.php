<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'price',
        'stock_quantity',
        'image',
        'category',
        'rating',
        'is_best_seller',
        'is_top_pick',
        'is_bakers_choice',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price'           => 'decimal:2',
        'stock_quantity'  => 'integer',
        'rating'          => 'decimal:1',
        'is_best_seller'  => 'boolean',
        'is_top_pick'     => 'boolean',
        'is_bakers_choice'=> 'boolean',
        'is_active'       => 'boolean',
    ];

    /* ── Scopes ─────────────────────────────────────── */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBestSellers($query)
    {
        return $query->active()
            ->withCount(['orderItems as total_sales' => function ($query) {
                $query->select(\DB::raw('sum(quantity)'));
            }])
            ->orderByDesc('total_sales')
            ->limit(3);
    }

    public function scopeTopPick($query)
    {
        return $query->active()
            ->orderByDesc('rating')
            ->limit(1);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeBakersChoice($query)
    {
        return $query->active()->where('is_bakers_choice', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->active()->where('category', $category)->orderBy('sort_order');
    }

    /* ── Methods ────────────────────────────────────── */

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function isOutOfStock(): bool
    {
        return $this->stock_quantity <= 0;
    }
}
