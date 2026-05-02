<?php

namespace App\Http\Controllers;

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
        $testimonials = Testimonial::active()->take(3)->get();

        return view('home', compact('bestSellers', 'testimonials'));
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

        $products = Product::active()
            ->when($category !== 'all', fn($q) => $q->where('category', $category))
            ->orderByDesc('rating')
            ->orderBy('sort_order')
            ->get();

        return view('catalog', compact('bakersChoice', 'topPick', 'products', 'category'));
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