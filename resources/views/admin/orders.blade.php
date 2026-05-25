@extends('layouts.app')

@section('title', 'Order Management | SugarLoom PH')

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
            overflow: hidden;
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
            vertical-align: top;
            font-size: 14px;
        }

        .order-number { font-weight: 700; color: #111827; }
        .muted { color: #6b7280; font-size: 13px; line-height: 1.5; }
        .amount { font-weight: 700; color: #be123c; white-space: nowrap; }

        .status-form { 
            display: flex; 
            flex-direction: column; 
            gap: 8px; 
        }
        
        .select, .input { 
            border: 1px solid #e5e7eb; 
            border-radius: 8px; 
            padding: 8px 12px; 
            font-size: 13px; 
        }
        
        .save-btn { 
            border: 0; 
            border-radius: 8px; 
            background: #fb7185; 
            color: white; 
            font-weight: 600; 
            padding: 8px 12px; 
            cursor: pointer; 
            font-size: 12px;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-paid { background: #dcfce7; color: #166534; }
        .badge-pending { background: #fef3c7; color: #92400e; }

        @media (max-width: 900px) {
            .card { overflow-x: auto; }
            table { min-width: 800px; }
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="header">
        <h1>Order Management</h1>
        <div class="flex gap">
            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">+ Add Walk-in Order</a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif

    <div class="tabs">
        <a href="{{ route('admin.dashboard') }}" class="tab">Dashboard</a>
        <a href="{{ route('admin.inventory') }}" class="tab">Inventory</a>
        <a href="{{ route('admin.orders') }}" class="tab active">Orders</a>
        <a href="{{ route('admin.user_index') }}" class="tab">Users</a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th style="width: 250px;">Update Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <div class="order-number">{{ $order->order_number }}</div>
                            <div class="muted">{{ optional($order->placed_at)->format('M d, Y h:i A') ?? 'No date' }}</div>
                        </td>
                        <td>
                            <div class="product-name" style="font-weight: 600;">{{ $order->customer_name }}</div>
                            <div class="muted">{{ $order->customer_email }}</div>
                            <div class="muted">{{ $order->customer_phone }}</div>
                            <div class="muted" style="max-width: 200px;">{{ $order->shipping_address }}, {{ $order->city }}</div>
                        </td>
                        <td class="muted">{{ $order->items_summary ?: 'No items' }}</td>
                        <td>
                            <div class="amount">PHP {{ number_format($order->total, 2) }}</div>
                            <div class="muted">{{ strtoupper($order->payment_method) }}</div>
                            <span class="badge {{ $order->payment_status === 'paid' ? 'badge-paid' : 'badge-pending' }}">
                                {{ $order->payment_status }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="status-form">
                                @csrf
                                @method('PATCH')
                                <select class="select" name="status">
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <input class="input" type="text" name="lalamove_tracking_number" value="{{ old('lalamove_tracking_number', $order->lalamove_tracking_number) }}" placeholder="Lalamove tracking #">
                                <button class="save-btn" type="submit">Update Order</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 48px; color: #6b7280;">
                            <div style="font-size: 32px; margin-bottom: 12px;">🍪</div>
                            No orders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 24px;">
        {{ $orders->links() }}
    </div>
</div>
@endsection
