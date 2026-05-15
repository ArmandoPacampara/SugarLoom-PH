@extends('layouts.app')

@section('title', 'Edit Product | SugarLoom PH')

@section('styles')
    <style>
        body {
            background: #fdf2f8;
            color: #111827;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 24px 24px 80px;
        }

        .card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            padding: 32px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        h1 { font-size: 24px; margin: 0 0 8px 0; font-weight: 600; }
        .subtitle { color: #6b7280; font-size: 14px; margin-bottom: 24px; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full {
            grid-column: span 2;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 13px;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s;
            background: #f9fafb;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #fb7185;
            background: white;
            box-shadow: 0 0 0 4px rgba(251, 113, 133, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .checkbox-group {
            display: flex;
            gap: 24px;
            background: #fdf2f8;
            padding: 16px;
            border-radius: 12px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #fb7185;
        }

        .checkbox-item label {
            margin: 0;
            cursor: pointer;
            font-weight: 500;
            text-transform: none;
            letter-spacing: normal;
        }

        .image-section {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .image-preview {
            width: 150px;
            height: 150px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            flex-shrink: 0;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .error-message {
            color: #dc2626;
            font-size: 12px;
            margin-top: 6px;
            font-weight: 500;
        }

        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #f3f4f6;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            font-size: 14px;
            text-align: center;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            flex: 1;
        }

        .btn-primary {
            background: #fb7185;
            color: white;
            flex: 2;
            box-shadow: 0 4px 12px rgba(251, 113, 133, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(251, 113, 133, 0.3);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
        }

        .back-link {
            color: #fb7185;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="header">
            <div>
                <h1>Edit Product</h1>
                <p class="subtitle">Refine your product details and availability</p>
            </div>
            <a href="{{ route('admin.inventory') }}" class="back-link">← Back to Inventory</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Please fix the errors below:</strong>
                <ul style="margin: 8px 0 0 18px; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-grid">
                <div class="form-group full">
                    <label>Product Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="e.g. Classic Chocolate Chip" required>
                    @error('name') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <div class="form-group full">
                    <label>Short Description</label>
                    <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" placeholder="A brief hook for the catalog" maxlength="500">
                    @error('short_description') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <div class="form-group full">
                    <label>Full Description *</label>
                    <textarea name="description" placeholder="Describe the flavors, ingredients, and why customers will love it..." required>{{ old('description', $product->description) }}</textarea>
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
                        <option value="specialty" @selected(old('category', $product->category) === 'specialty')>Specialty</option>
                    </select>
                    @error('category') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label>Customer Rating (0-5)</label>
                    <input type="number" name="rating" step="0.1" min="0" max="5" value="{{ old('rating', $product->rating) }}">
                    @error('rating') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <div class="form-group full">
                    <label>Product Image</label>
                    <div class="image-section">
                        <div class="image-preview" id="imagePreview" style="display: {{ $product->image ? 'block' : 'none' }};">
                            <img id="imagePreviewImg" src="{{ $product->image ? asset($product->image) : asset('images/placeholder.png') }}" alt="{{ $product->name }}" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                        </div>
                        <div style="flex-grow: 1;">
                            <input id="productImage" type="file" name="image" accept="image/*">
                            <p class="muted" style="margin-top: 8px;">Recommended size: 800x800px. PNG or JPG.</p>
                        </div>
                    </div>
                    @error('image') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <div class="form-group full">
                    <label>Product Status & Featured</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $product->is_active))>
                            <label for="is_active">Show in Catalog</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="is_bakers_choice" name="is_bakers_choice" value="1" @checked(old('is_bakers_choice', $product->is_bakers_choice))>
                            <label for="is_bakers_choice">Baker's Choice ✨</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <a href="{{ route('admin.inventory') }}" class="btn btn-secondary">Discard Changes</a>
                <button type="submit" class="btn btn-primary">Save Product Details</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        const editProductImageInput = document.getElementById('productImage');
        const editImagePreview = document.getElementById('imagePreview');
        const editImagePreviewImg = document.getElementById('imagePreviewImg');

        if (editProductImageInput) {
            editProductImageInput.addEventListener('change', function () {
                const file = this.files?.[0];

                if (!file) {
                    editImagePreview.style.display = 'none';
                    editImagePreviewImg.src = '';
                    return;
                }

                editImagePreviewImg.src = URL.createObjectURL(file);
                editImagePreview.style.display = 'block';
            });
        }
    </script>
@endsection
