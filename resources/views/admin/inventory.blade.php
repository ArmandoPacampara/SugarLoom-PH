@extends('layouts.app')

@section('title', 'Inventory Management | SugarLoom PH')

@section('styles')
    <style>
        body {
            background: #fdf2f8;
            color: #111827;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 24px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        h1 { font-size: 24px; margin: 0; font-weight: 600; }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            font-size: 14px;
        }

        .btn-light {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-light:hover {
            background: #e5e7eb;
        }

        .btn-primary {
            background: #fb7185;
            color: white;
        }

        .btn-primary:hover {
            background: #f43f5e;
        }

        .alert {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            padding: 16px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #fb7185;
        }

        .stat-label {
            color: #6b7280;
            font-size: 12px;
            margin-top: 4px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }

        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            transition: all 0.2s;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .product-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            background: #f3f4f6;
        }

        .product-info {
            padding: 16px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .product-description {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .product-price {
            font-weight: 600;
            color: #fb7185;
        }

        .stock-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .stock-high { background: #dcfce7; color: #166534; }
        .stock-medium { background: #fef3c7; color: #92400e; }
        .stock-low { background: #fee2e2; color: #dc2626; }
        .stock-out { background: #f3f4f6; color: #6b7280; }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .status-available { background: #dcfce7; color: #166534; }
        .status-unavailable { background: #fee2e2; color: #dc2626; }

        .form-inline {
            display: flex;
            gap: 6px;
            align-items: center;
            margin-bottom: 8px;
        }

        .stock-input {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 6px 8px;
            width: 70px;
            text-align: center;
            font-size: 13px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border: none;
            border-radius: 4px;
            background: #fb7185;
            color: white;
            cursor: pointer;
        }

        .btn-sm:hover {
            background: #f43f5e;
        }

        .btn-edit {
            display: block;
            width: 100%;
            padding: 8px;
            background: #f3f4f6;
            color: #374151;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
        }

        .btn-edit:hover {
            background: #e5e7eb;
        }

        .empty-state {
            text-align: center;
            color: #6b7280;
            padding: 48px 20px;
            background: white;
            border-radius: 8px;
        }

        .empty-state h3 {
            margin-bottom: 8px;
            color: #374151;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="header">
        <h1>Inventory</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light">← Dashboard</a>
    </div>

    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $products->count() }}</div>
            <div class="stat-label">Total Products</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $products->where('stock_quantity', '>', 10)->count() }}</div>
            <div class="stat-label">In Stock</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $products->where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0)->count() }}</div>
            <div class="stat-label">Low Stock</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $products->where('stock_quantity', 0)->count() }}</div>
            <div class="stat-label">Out of Stock</div>
        </div>
    </div>

    <!-- PRODUCTS GRID -->
    @if($products->count() > 0)
        <div class="product-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                    <div class="product-info">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-description">{{ $product->description }}</div>

                        <div class="product-details">
                            <span class="product-price">PHP {{ number_format($product->price, 2) }}</span>
                            <span class="stock-badge @if($product->stock_quantity > 20) stock-high @elseif($product->stock_quantity > 10) stock-medium @elseif($product->stock_quantity > 0) stock-low @else stock-out @endif">
                                {{ $product->stock_quantity > 0 ? $product->stock_quantity . ' left' : 'Out of stock' }}
                            </span>
                        </div>

                        <div class="status-badge @if($product->is_active) status-available @else status-unavailable @endif">
                            @if($product->is_active) ✓ Available @else ✕ Unavailable @endif
                        </div>

                        <form method="POST" action="{{ route('admin.products.stock', $product) }}" class="form-inline">
                            @csrf
                            @method('PATCH')
                            <input class="stock-input" type="number" name="stock_quantity" min="0" max="9999" value="{{ $product->stock_quantity }}">
                            <button class="btn-sm" type="submit">Update</button>
                        </form>

                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-edit">✏️ Edit</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <h3>No products yet</h3>
            <p>Add your first product to get started</p>
        </div>
    @endif
</div>
@endsection