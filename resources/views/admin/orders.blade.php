@extends('layouts.app')

@section('title', 'Order Management | SugarLoom PH')

@section('styles')
    <style>
        body { background: #fdf2f8; color: #111827; }
        .container { max-width: 1200px; margin: auto; padding: 24px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; }
        h1 { font-size: 24px; margin: 0; font-weight: 600; }
        .btn { padding: 10px 18px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; font-size: 14px; }
        .btn-light { background: #f3f4f6; color: #374151; }
        .btn-primary { background: #fb7185; color: white; }
        .alert { background: #dcfce7; color: #166534; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
        .tabs { display: flex; background: white; border-radius: 8px; padding: 4px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
        .tab { flex: 1; padding: 12px 16px; border-radius: 6px; text-align: center; text-decoration: none; color: #6b7280; font-weight: 600; font-size: 14px; }
        .tab.active { background: #fb7185; color: white; }
        .card { background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; color: #6b7280; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0; padding: 14px 16px; background: #fff7fb; }
        td { padding: 16px; border-top: 1px solid #f3f4f6; vertical-align: top; font-size: 14px; }
        .order-number { font-weight: 700; color: #111827; }
        .muted { color: #6b7280; font-size: 13px; line-height: 1.5; }
        .amount { font-weight: 700; color: #be123c; white-space: nowrap; }
        .status-form { display: grid; grid-template-columns: minmax(150px, 1fr) minmax(180px, 1fr) auto; gap: 8px; align-items: center; }
        .input, .select { border: 1px solid #e5e7eb; border-radius: 6px; padding: 9px 10px; font: inherit; min-width: 0; }
        .save-btn { border: 0; border-radius: 6px; background: #fb7185; color: white; font-weight: 700; padding: 10px 14px; cursor: pointer; }
        .empty-state { text-align: center; color: #6b7280; padding: 40px 16px; }
        .pager { margin-top: 18px; }
        @media (max-width: 900px) {
            .card { overflow-x: auto; }
            table { min-width: 960px; }
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="header">
        <h1>Orders</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Back to Dashboard</a>
    </div>

    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert" style="background: #fee2e2; color: #991b1b;">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="tabs">
        <a href="{{ route('admin.dashboard') }}" class="tab">Dashboard</a>
        <a href="{{ route('admin.inventory') }}" class="tab">Inventory</a>
        <a href="{{ route('admin.orders') }}" class="tab active">Orders</a>
        <a href="{{ route('admin.analytics') }}" class="tab">Analytics</a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status and Lalamove Tracking</th>
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
                            <strong>{{ $order->customer_name }}</strong>
                            <div class="muted">{{ $order->customer_email }}</div>
                            <div class="muted">{{ $order->customer_phone }}</div>
                            <div class="muted">{{ $order->shipping_address }}, {{ $order->city }} {{ $order->postal_code }}</div>
                        </td>
                        <td class="muted">{{ $order->items_summary ?: 'No items' }}</td>
                        <td>
                            <div class="amount">PHP {{ number_format($order->total, 2) }}</div>
                            <div class="muted">{{ strtoupper($order->payment_method) }} / {{ ucfirst($order->payment_status) }}</div>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="status-form">
                                @csrf
                                @method('PATCH')
                                <select class="select" name="status" aria-label="Status for {{ $order->order_number }}">
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <input class="input" type="text" name="lalamove_tracking_number" value="{{ old('lalamove_tracking_number', $order->lalamove_tracking_number) }}" placeholder="Lalamove tracking no.">
                                <button class="save-btn" type="submit">Save</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No customer orders yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pager">
        {{ $orders->links() }}
    </div>
</div>
@endsection
