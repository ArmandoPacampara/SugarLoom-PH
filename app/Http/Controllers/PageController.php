<?php

namespace App\Http\Controllers; // THIS LINE IS CRITICAL

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

    /*
    * About page
    */

    public function about()
    {
        return view('about');
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
}

