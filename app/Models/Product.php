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
            ->where('is_best_seller', true)
            ->orderBy('sort_order')
            ->limit(3);
    }

    public function scopeTopPick($query)
    {
        return $query->active()->where('is_top_pick', true);
    }

    public function scopeBakersChoice($query)
    {
        return $query->active()->where('is_bakers_choice', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->active()->where('category', $category)->orderBy('sort_order');
    }
}

