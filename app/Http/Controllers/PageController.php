<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Homepage
     */
    public function home()
    {
        $bestSellers = Product::bestSellers()->take(3)->get();
        $quizProducts = Product::active()
            ->orderByDesc('rating')
            ->orderBy('sort_order')
            ->take(10)
            ->get();
        $quizProductRecommendations = $quizProducts
            ->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => (float) $product->price,
                'rating' => (float) $product->rating,
                'image' => $product->image ? asset($product->image) : asset('images/placeholder-cookie.png'),
                'stock' => $product->stock_quantity,
                'category' => $product->category,
            ])
            ->values();
        $testimonials = Testimonial::active()->take(3)->get();
        
        // Fetch order ratings from delivered orders
        $orderRatings = Order::where('status', Order::STATUS_DELIVERED)
            ->whereNotNull('rating')
            ->latest('reviewed_at')
            ->take(3)
            ->get();

        return view('home', compact('bestSellers', 'quizProductRecommendations', 'testimonials', 'orderRatings'));
    }
    public function about()
    {
        return view('about');
    }
    public function show()
    {
        return view('products.show');
    }
    /**
     * Catalog page
     */
    public function catalog(Request $request)
    {
        $bakersChoice = Product::bakersChoice()->first();
        $topPick      = Product::topPick()->first();

        $category = $request->query('category', 'all');
        $search = $request->query('search');

        $products = Product::active()
            ->when($category !== 'all', fn($q) => $q->where('category', $category))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('rating')
            ->orderBy('sort_order')
            ->get();

        if ($request->ajax()) {
            return view('partials.product-list', compact('products', 'search'))->render();
        }

        return view('catalog', compact('bakersChoice', 'topPick', 'products', 'category', 'search'));
    }

    // public function show($slug)
    // {
    //     $product = Product::where('slug', $slug)->firstOrFail();

    //     $suggestions = Product::active()
    //         ->where('id', '!=', $product->id)
    //         ->inRandomOrder()
    //         ->take(3)
    //         ->get();

    //     return view('products.show', compact('product', 'suggestions'));
    // }
    
}
