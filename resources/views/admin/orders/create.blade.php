@extends('layouts.app')

@section('title', 'Record Walk-in Order | SugarLoom PH')

@section('styles')
    <style>
        body { background: #fdf2f8; color: #111827; }
        .container { max-width: 900px; margin: auto; padding: 24px; }
        .card { background: white; padding: 32px; border-radius: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
        h1 { font-size: 24px; margin: 0 0 8px 0; font-weight: 600; }
        .subtitle { color: #6b7280; font-size: 14px; margin-bottom: 32px; }
        
        .form-section { margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #f3f4f6; }
        .section-title { font-size: 16px; font-weight: 700; color: #374151; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group.full { grid-column: span 2; }

        label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 13px; color: #374151; }
        input, select { width: 100%; padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 12px; font-size: 14px; background: #f9fafb; transition: all 0.2s; }
        input:focus, select:focus { outline: none; border-color: #fb7185; background: white; box-shadow: 0 0 0 4px rgba(251, 113, 133, 0.1); }

        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .items-table th { text-align: left; padding: 12px; color: #6b7280; font-size: 12px; text-transform: uppercase; border-bottom: 2px solid #f3f4f6; }
        .items-table td { padding: 12px; border-bottom: 1px solid #f3f4f6; }

        .btn { padding: 12px 24px; border-radius: 999px; border: none; cursor: pointer; font-weight: 600; transition: all 0.2s; font-size: 14px; text-align: center; text-decoration: none; display: inline-block; }
        .btn-primary { background: #fb7185; color: white; box-shadow: 0 4px 12px rgba(251, 113, 133, 0.2); }
        .btn-light { background: #f3f4f6; color: #374151; }
        .btn-danger { background: #fee2e2; color: #dc2626; padding: 8px 12px; font-size: 12px; }

        .summary { background: #fdf2f8; padding: 20px; border-radius: 16px; margin-top: 24px; text-align: right; }
        .total-row { font-size: 20px; font-weight: 800; color: #be123c; margin-top: 8px; }

        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="header">
            <div>
                <h1>Record Walk-in Order</h1>
                <p class="subtitle">Manually enter a sale from the physical store</p>
            </div>
            <a href="{{ route('admin.orders') }}" style="color: #fb7185; font-weight: 600; text-decoration: none;">← Back to Orders</a>
        </div>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #dc2626; padding: 166px; border-radius: 12px; margin-bottom: 24px; font-size: 14px;">
                <strong>Please fix the errors below:</strong>
                <ul style="margin-top: 8px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.orders.store') }}" method="POST" id="order-form">
            @csrf

            <!-- CUSTOMER INFO -->
            <div class="form-section">
                <div class="section-title">Customer Information</div>
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Customer Name *</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', 'Walk-in Customer') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email (Optional)</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}">
                    </div>
                    <div class="form-group">
                        <label>Phone Number (Optional)</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}">
                    </div>
                </div>
            </div>

            <!-- ITEMS -->
            <div class="form-section" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                <div class="section-title">Order Items</div>
                <table class="items-table" id="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="width: 120px;">Price</th>
                            <th style="width: 100px;">Qty</th>
                            <th style="width: 120px;">Subtotal</th>
                            <th style="width: 50px;"></th>
                        </tr>
                    </thead>
                    <tbody id="items-body">
                        <!-- Items will be added here -->
                    </tbody>
                </table>
                <button type="button" class="btn btn-light" id="add-item-btn" style="width: 100%;">+ Add Item</button>
            </div>

            <div class="summary">
                <div class="muted" style="font-size: 14px; color: #6b7280;">ORDER TOTAL</div>
                <div class="total-row">PHP <span id="grand-total">0.00</span></div>
            </div>

            <div style="margin-top: 32px; display: flex; gap: 12px;">
                <a href="{{ route('admin.orders') }}" class="btn btn-light" style="flex: 1;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="flex: 2;">Record Sale</button>
            </div>
        </form>
    </div>
</div>

<template id="item-row-template">
    <tr class="item-row">
        <td>
            <select name="items[INDEX][product_id]" class="product-select" required onchange="updateRow(this)">
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">
                        {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                    </option>
                @endforeach
            </select>
        </td>
        <td class="price-cell">PHP 0.00</td>
        <td>
            <input type="number" name="items[INDEX][quantity]" value="1" min="1" required class="quantity-input" oninput="updateRow(this)">
        </td>
        <td class="subtotal-cell">PHP 0.00</td>
        <td>
            <button type="button" class="btn btn-danger" onclick="removeRow(this)">×</button>
        </td>
    </tr>
</template>
@endsection

@section('scripts')
<script>
    let rowIndex = 0;
    const itemsBody = document.getElementById('items-body');
    const template = document.getElementById('item-row-template').innerHTML;
    const grandTotalSpan = document.getElementById('grand-total');

    function addRow() {
        const newRow = template.replace(/INDEX/g, rowIndex++);
        itemsBody.insertAdjacentHTML('beforeend', newRow);
    }

    function removeRow(btn) {
        btn.closest('tr').remove();
        calculateGrandTotal();
    }

    function updateRow(el) {
        const row = el.closest('tr');
        const select = row.querySelector('.product-select');
        const qtyInput = row.querySelector('.quantity-input');
        const priceCell = row.querySelector('.price-cell');
        const subtotalCell = row.querySelector('.subtotal-cell');

        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption.value) {
            const price = parseFloat(selectedOption.dataset.price);
            const stock = parseInt(selectedOption.dataset.stock);
            const qty = parseInt(qtyInput.value) || 0;

            if (qty > stock) {
                alert(`Only ${stock} items in stock!`);
                qtyInput.value = stock;
            }

            const subtotal = price * qty;
            priceCell.textContent = `PHP ${price.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
            subtotalCell.textContent = `PHP ${subtotal.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        } else {
            priceCell.textContent = 'PHP 0.00';
            subtotalCell.textContent = 'PHP 0.00';
        }

        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const select = row.querySelector('.product-select');
            const qtyInput = row.querySelector('.quantity-input');
            const selectedOption = select.options[select.selectedIndex];
            
            if (selectedOption.value) {
                const price = parseFloat(selectedOption.dataset.price);
                const qty = parseInt(qtyInput.value) || 0;
                total += price * qty;
            }
        });
        grandTotalSpan.textContent = total.toLocaleString(undefined, {minimumFractionDigits: 2});
    }

    document.getElementById('add-item-btn').addEventListener('click', addRow);

    // Add first row on load
    addRow();
</script>
@endsection
