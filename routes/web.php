<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/home', [PageController::class, 'home'])->name('home');

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }
    
}

