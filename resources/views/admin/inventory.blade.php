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
            padding: 24px 24px 80px;
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
            border-radius: 999px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            font-size: 14px;
        }

        .btn-light {
            background: white;
            color: #374151;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .btn-primary {
            background: #fb7185;
            color: white;
            box-shadow: 0 4px 12px rgba(251, 113, 133, 0.2);
        }

        .alert {
            background: #dcfce7;
            color: #166534;
            padding: 12px 24px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .tabs { 
            display: flex; 
            background: white; 
            border-radius: 12px; 
            padding: 4px; 
            margin-bottom: 24px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
        }
        
        .tab { 
            flex: 1; 
            padding: 12px 24px; 
            border-radius: 8px; 
            text-align: center; 
            text-decoration: none; 
            color: #6b7280; 
            font-weight: 500; 
            transition: all 0.2s; 
        }
        
        .tab.active { 
            background: #fb7185; 
            color: white; 
            box-shadow: 0 2px 8px rgba(251, 113, 133, 0.3); 
        }

        .card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        /* ── SEARCH & FILTER ── */
        .toolbar {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            padding: 16px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            align-items: center;
        }

        .search-box {
            flex-grow: 1;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 10px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            font-size: 14px;
            background: #f9fafb;
            transition: all 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #fb7185;
            background: white;
            box-shadow: 0 0 0 3px rgba(251, 113, 133, 0.1);
        }

        .filter-select {
            padding: 10px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            font-size: 14px;
            background: #f9fafb;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px 16px;
            color: #6b7280;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            border-bottom: 2px solid #f3f4f6;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .product-img {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            background: #f3f4f6;
        }

        .product-name {
            font-weight: 600;
            color: #111827;
        }

        .product-cat {
            font-size: 12px;
            color: #6b7280;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #dc2626; }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            display: inline-block;
            text-decoration: none;
        }

        .btn-edit { background: #f3f4f6; color: #374151; }
        .btn-delete { background: #fee2e2; color: #dc2626; margin-left: 4px; }
        .btn-delete:hover { background: #fca5a5; }

        @media (max-width: 768px) {
            .hide-mobile { display: none; }
            .toolbar { flex-direction: column; align-items: stretch; }
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="header">
        <h1>Inventory Management</h1>
        <div class="flex gap">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add New Product</a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif

    <div class="tabs">
        <a href="{{ route('admin.dashboard') }}" class="tab">Dashboard</a>
        <a href="{{ route('admin.inventory') }}" class="tab active">Inventory</a>
        <a href="{{ route('admin.orders') }}" class="tab">Orders</a>
        <a href="{{ route('admin.user_index') }}" class="tab">Users</a>
    </div>

    <!-- SEARCH & FILTERS -->
    <form action="{{ route('admin.inventory') }}" method="GET" class="toolbar" id="filterForm">
        <div class="search-box">
            <input type="text" name="search" class="search-input" id="searchInput" placeholder="Search product name or description..." value="{{ request('search') }}" autocomplete="off">
        </div>
        
        <select name="category" class="filter-select" onchange="this.form.submit()">
            <option value="all">All Categories</option>
            <option value="sweet" @selected(request('category') === 'sweet')>Sweet</option>
            <option value="savory" @selected(request('category') === 'savory')>Savory</option>
            <option value="specialty" @selected(request('category') === 'specialty')>Specialty</option>
        </select>

        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="active" @selected(request('status') === 'active')>Available</option>
            <option value="hidden" @selected(request('status') === 'hidden')>Hidden</option>
            <option value="low_stock" @selected(request('status') === 'low_stock')>Low Stock</option>
            <option value="out_of_stock" @selected(request('status') === 'out_of_stock')>Out of Stock</option>
        </select>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterForm = document.getElementById('filterForm');
            let timeout = null;

            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filterForm.submit();
                }, 500); // Wait 500ms after typing stops before submitting
            });

            // Keep cursor at the end of the input after reload
            if (searchInput.value) {
                searchInput.focus();
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }
        });
    </script>

    <div class="card">
        @if($products->count() > 0)
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="hide-mobile">Category</th>
                            <th>Price</th>
                            <th>Stock Level</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <img src="{{ asset($product->image) }}" alt="" class="product-img" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                        <div>
                                            <div class="product-name">{{ $product->name }}</div>
                                            <div class="product-cat hide-mobile">{{ ucfirst($product->category) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hide-mobile">
                                    <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                                        {{ $product->is_active ? 'Active' : 'Hidden' }}
                                    </span>
                                </td>
                                <td class="product-name">PHP {{ number_format($product->price, 2) }}</td>
                                <td>
                                    <span class="badge @if($product->stock_quantity > 20) badge-success @elseif($product->stock_quantity > 10) badge-warning @else badge-danger @endif">
                                        {{ $product->stock_quantity }} in stock
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex;">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-action btn-edit">Edit</a>
                                        <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-action btn-delete" onclick="confirmDeleteProduct('{{ $product->id }}', '{{ addslashes($product->name) }}')">Remove</button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 64px 24px; color: #6b7280;">
                <div style="font-size: 64px; margin-bottom: 16px; filter: grayscale(0.2);">🍪</div>
                <h3 style="color: #374151; margin-bottom: 8px;">No Products Found</h3>
                <p>We couldn't find any products matching your current search or filters.</p>
                @if($hasFilters)
                    <a href="{{ route('admin.inventory') }}" style="color: #fb7185; text-decoration: underline; margin-top: 12px; display: inline-block;">Clear all filters</a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDeleteProduct(id, name) {
        openConfirmationModal(
            'Remove Product',
            `Are you sure you want to remove "${name}" from your inventory? This action cannot be undone.`,
            function() {
                document.getElementById('delete-form-' + id).submit();
            }
        );
    }
</script>
@endsection
