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

    /**
     * Catalog page
     */
    public function catalog()
    {
        // return view('catalog');
    }
}

