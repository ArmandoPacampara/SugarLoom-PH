<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalSales' => 124500,
            'salesProgress' => 70,
            'activeOrders' => 42,
            'nextDelivery' => '2 hours',
            'lowStockCount' => 3,

            'demandData' => [60,80,100,120,110,90,70],

            'inventory' => [
                ['name' => 'Premium Cocoa Powder', 'stock' => '1.2kg Left', 'percent' => 20],
                ['name' => 'Salted Butter Batch', 'stock' => '14.5kg Left', 'percent' => 70],
                ['name' => 'Cookie Dough', 'stock' => '24 Tubs', 'percent' => 80],
            ],

            'orders' => [
                ['id'=>'#SL-4590','customer'=>'Maria Clara','item'=>'Ube Glaze Box','status'=>'Preparing','amount'=>850],
                ['id'=>'#SL-4589','customer'=>'Juan Dela Cruz','item'=>'Classic Choco Batch','status'=>'Delivered','amount'=>1200],
                ['id'=>'#SL-4588','customer'=>'Elena Santos','item'=>'Pastel Party Pack','status'=>'Pending','amount'=>2450],
            ],

            'trending' => [
                ['name'=>'Matcha Velvet','percent'=>45],
                ['name'=>'Burnt Caramel','percent'=>28],
            ]
        ]);
    }
}