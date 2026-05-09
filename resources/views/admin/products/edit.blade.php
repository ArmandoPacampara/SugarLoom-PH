@extends('layouts.app')

@section('title', 'Edit Product | SugarLoom PH')

@section('styles')
    <style>
        body {
            background: #fdf2f8;
            color: #111827;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 24px;
        }

        .card {
            background: white;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        h1 { font-size: 24px; margin: 0 0 8px 0; font-weight: 600; }
        .subtitle { color: #6b7280; font-size: 14px; margin-bottom: 24px; }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 6px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="file"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #fb7185;
            box-shadow: 0 0 0 2px rgba(251, 113, 133, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #fb7185;
        }

        .checkbox-item label {
            margin: 0;
            cursor: pointer;
            font-weight: 400;
        }

        .image-preview {
            margin-top: 12px;
            max-width: 200px;
        }

        .image-preview img {
            width: 100%;
            height: auto;
            border-radius: 6px;
        }

        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 4px;
        }

        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fca5a5;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

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

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            flex: 1;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-primary {
            background: #fb7185;
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            background: #f43f5e;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }

        .header a {
            color: #6b7280;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .header a:hover {
            color: #374151;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="header">
            <div>
                <h1>Edit Product</h1>
                <p class="subtitle">Update product details</p>
            </div>
            <a href="{{ route('admin.inventory') }}">← Back</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Please fix the errors below:</strong>
                <ul style="margin: 6px 0 0 18px; padding: 0; font-size: 13px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                @error('name') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Short Description</label>
                <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" maxlength="500">
                @error('short_description') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Full Description *</label>
                <textarea name="description" required>{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Price (PHP) *</label>
                <input type="number" name="price" step="0.01" min="0.01" value="{{ old('price', $product->price) }}" required>
                @error('price') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Stock Quantity *</label>
                <input type="number" name="stock_quantity" min="0" max="9999" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                @error('stock_quantity') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Category *</label>
                <select name="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="sweet" @selected(old('category', $product->category) === 'sweet')>Sweet</option>
                    <option value="savory" @selected(old('category', $product->category) === 'savory')>Savory</option>
                    <option value="beverage" @selected(old('category', $product->category) === 'beverage')>Beverage</option>
                    <option value="specialty" @selected(old('category', $product->category) === 'specialty')>Specialty</option>
                </select>
                @error('category') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Rating (0-5)</label>
                <input type="number" name="rating" step="0.1" min="0" max="5" value="{{ old('rating', $product->rating) }}">
                @error('rating') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" accept="image/*">
                @if ($product->image)
                    <div class="image-preview">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                    </div>
                @endif
                @error('image') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label style="display: block; margin-bottom: 12px; font-weight: 500;">Status</label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $product->is_active))>
                        <label for="is_active">Available</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="is_best_seller" name="is_best_seller" value="1" @checked(old('is_best_seller', $product->is_best_seller))>
                        <label for="is_best_seller">Best Seller</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="is_bakers_choice" name="is_bakers_choice" value="1" @checked(old('is_bakers_choice', $product->is_bakers_choice))>
                        <label for="is_bakers_choice">Baker's Choice</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="is_top_pick" name="is_top_pick" value="1" @checked(old('is_top_pick', $product->is_top_pick))>
                        <label for="is_top_pick">Top Pick</label>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <a href="{{ route('admin.inventory') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection