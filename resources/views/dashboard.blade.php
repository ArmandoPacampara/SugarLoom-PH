@extends('layouts.app')

@section('title', 'Admin Dashboard | SugarLoom PH')

@section('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --pink-deep:   #d8547b; 
            --pink-light:  #f8bac9;
            --pink-pale:   #ffd7e1;
            --cream:       #fffcfc; 
            --dark:        #1a1018;
            --gray-btn:    #f3eff1;
        }

        body {
            background: #fdf2f8;
            color: #111827;
            scroll-behavior: smooth;
        }

        /* ── ANIMATIONS ── */
        @keyframes growUp {
            from { transform: scaleY(0); transform-origin: bottom; }
            to { transform: scaleY(1); transform-origin: bottom; }
        }
        .bar { animation: growUp 1s ease-out backwards; }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 24px;
        }

        .flex { display: flex; }
        .between { justify-content: space-between; align-items: center; }
        .gap { gap: 16px; }

        .grid { display: grid; gap: 24px; }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-2-1 { grid-template-columns: 2fr 1fr; }

        .card {
            margin: 20px 0;
            background: white;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(216, 84, 123, 0.1); }

        h1 { font-size: 24px; margin: 0; }
        h2 { font-size: 28px; margin: 10px 0; }
        h3 { margin-bottom: 16px; margin-top: 0; }

        .btn {
            padding: 10px 16px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-light {
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background: #fb7185;
            color: white;
        }

        .progress {
            width: 100%;
            height: 8px;
            background: #fbcfe8;
            border-radius: 10px;
            margin-top: 10px;
        }

        .progress-bar {
            height: 8px;
            background: #fb7185;
            border-radius: 10px;
        }

        .chart {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            height: 160px;
        }

        .bar {
            flex: 1;
            background: #fda4af;
            border-radius: 10px 10px 0 0;
            transition: all 0.3s;
        }
        .bar:hover { background: #fb7185; transform: scaleX(1.1); }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            color: gray;
            font-weight: normal;
            padding-bottom: 10px;
        }

        td {
            padding: 10px 0;
            border-top: 1px solid #eee;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .blue { background: #dbeafe; color: #2563eb; }
        .green { background: #dcfce7; color: #16a34a; }
        .yellow { background: #fef9c3; color: #ca8a04; }
        .red { background: #fee2e2; color: #dc2626; }
        .status-form { display: flex; gap: 8px; align-items: center; }
        .status-select, .stock-input {
            border: 1px solid #f3d4dc;
            border-radius: 999px;
            padding: 7px 10px;
            background: white;
        }
        .mini-btn {
            padding: 7px 10px;
            border-radius: 999px;
            border: 0;
            background: #fb7185;
            color: white;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }

        .inventory-item { margin-bottom: 16px; }
        
        .inventory-top {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .text-red { color: #ef4444; font-weight: bold; }

        .trending {
            background: #fb7185;
            color: white;
            padding: 24px;
            border-radius: 20px;
            margin-top: 24px;
            max-width: 400px;
            transition: all 0.3s;
            box-shadow: 0 8px 25px rgba(251, 113, 133, 0.3);
        }
        .trending:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(251, 113, 133, 0.4); }

        .trend-item {
            display: flex;
            justify-content: space-between;
            background: white;
            color: black;
            padding: 10px 16px;
            border-radius: 999px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .mt-24 { margin-top: 24px; }
        .mt-10 { margin-top: 10px; }
        .mt-0 { margin-top: 0; }
        .mb-10 { margin-bottom: 10px; }
        .mb-16 { margin-bottom: 16px; }
        .m-0 { margin: 0; }
        .w-full { width: 100%; }
        .text-gray { color: gray; }
        .text-bold { font-weight: bold; }
        .fs-14 { font-size: 14px; }
        .empty-state { color: gray; padding: 12px 0; }
    </style>
@endsection

@section('content')
<div class="container">

    <!-- HEADER -->
    <div class="flex between mb-10">
        <h1>Admin Dashboard</h1>
        <div class="flex gap">
            <button class="btn btn-light">Export Report</button>
            <button class="btn btn-primary">+ New Batch</button>
        </div>
    </div>

    @if (session('status'))
        <div class="card" style="margin: 0 0 20px; color: #166534; background: #dcfce7;">
            {{ session('status') }}
        </div>
    @endif

    <!-- TABS -->
    <div class="tabs" style="display: flex; background: white; border-radius: 12px; padding: 4px; margin-bottom: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <a href="{{ route('admin.dashboard') }}" class="tab active" style="flex: 1; padding: 12px 24px; border-radius: 8px; text-align: center; text-decoration: none; color: white; font-weight: 500; background: #fb7185; box-shadow: 0 2px 8px rgba(251, 113, 133, 0.3);">Dashboard</a>
        <a href="{{ route('admin.inventory') }}" class="tab" style="flex: 1; padding: 12px 24px; border-radius: 8px; text-align: center; text-decoration: none; color: #6b7280; font-weight: 500; transition: all 0.2s;">Inventory</a>
        <a href="#" class="tab" style="flex: 1; padding: 12px 24px; border-radius: 8px; text-align: center; text-decoration: none; color: #6b7280; font-weight: 500; transition: all 0.2s;">Orders</a>
        <a href="#" class="tab" style="flex: 1; padding: 12px 24px; border-radius: 8px; text-align: center; text-decoration: none; color: #6b7280; font-weight: 500; transition: all 0.2s;">Analytics</a>
    </div>

    <!-- STATS -->
    <div class="grid grid-3">
        <div class="card m-0" data-aos="fade-up" data-aos-delay="100">
            <p class="text-gray mt-0">TOTAL SALES</p>
            <h2>PHP {{ number_format($totalSales ?? 0, 2) }}</h2>
            <div class="progress">
                <div class="progress-bar" @style(['width' => ($salesProgress ?? 50) . '%'])></div>
            </div>
        </div>

        <div class="card m-0" data-aos="fade-up" data-aos-delay="200">
            <p class="text-gray mt-0">ACTIVE ORDERS</p>
            <h2>{{ $activeOrders ?? 0 }}</h2>
            <p class="text-gray fs-14">Next delivery: {{ $nextDelivery ?? 'N/A' }}</p>
        </div>

        <div class="card m-0" data-aos="fade-up" data-aos-delay="300">
            <p class="text-gray mt-0">LOW STOCK ALERTS</p>
            <h2>{{ $lowStockCount ?? 0 }} Items</h2>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-2-1 mt-24">
        <div class="card m-0" data-aos="fade-right">
            <h3>Demand Prediction</h3>
            <div class="chart">
                @foreach($demandData ?? [50,70,90,120,110,80,60] as $value)
                    <div class="bar" @style(['height' => $value . 'px', 'animation-delay' => ($loop->index * 100) . 'ms'])></div>
                @endforeach
            </div>
        </div>

        <div class="card m-0" data-aos="fade-left">
            <h3>Quick Actions</h3>
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <a href="{{ route('admin.inventory') }}" class="btn btn-primary" style="text-align: center; text-decoration: none;">📦 Manage Inventory</a>
                <button class="btn btn-light">📊 View Reports</button>
                <button class="btn btn-light">👥 Customer Support</button>
            </div>
        </div>
    </div>

    <!-- ORDERS & TRENDING ROW -->
    <div class="grid grid-2-1 mt-24">
        
        <!-- ORDERS -->
        <div class="card m-0" data-aos="fade-up">
            <h3>Recent Orders</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Item</th>
                        <th>Status</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders ?? [] as $order)
                    <tr>
                        <td class="text-bold">{{ $order->order_number }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td class="text-gray">{{ $order->items_summary }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="status-form">
                                @csrf
                                @method('PATCH')
                                <select class="status-select" name="status" aria-label="Status for {{ $order->order_number }}">
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button class="mini-btn" type="submit">Save</button>
                            </form>
                        </td>
                        <td class="text-bold">PHP {{ number_format($order->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">No customer orders yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- TRENDING -->
        <div class="trending m-0" style="max-width: none;" data-aos="fade-up" data-aos-delay="200">
            <h3 class="mt-0">Trending This Week</h3>
            @forelse($trending ?? [] as $trend)
                <div class="trend-item">
                    <span>{{ $trend->product_name }}</span>
                    <span>{{ $trend->total_quantity }} sold</span>
                </div>
            @empty
                <div class="trend-item">
                    <span>No sales yet</span>
                    <span>0</span>
                </div>
            @endforelse
        </div>

    </div>

</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        duration: 800,
        easing: 'ease-out-cubic'
    });
</script>
@endsection


