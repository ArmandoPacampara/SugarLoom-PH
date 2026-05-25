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

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 24px 24px 80px; /* Added 80px bottom padding */
        }

        .flex { display: flex; }
        .between { justify-content: space-between; align-items: center; }
        .gap { gap: 16px; }

        .grid { display: grid; gap: 24px; }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-2-1 { grid-template-columns: 2fr 1fr; }

        .card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            padding: 24px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.4);
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
            text-decoration: none;
            font-size: 14px;
        }

        .btn-light {
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: var(--dark);
        }

        .btn-primary {
            background: #fb7185;
            color: white;
        }
        
        .btn-export {
            background: var(--dark);
            color: white;
            display: inline-flex;
            align-items: center;
            transition: opacity 0.2s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-export:hover { opacity: 0.85; color: white; }
        .btn-export svg { width: 18px; height: 18px; margin-right: 8px; }

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

        .status-form { display: flex; gap: 8px; align-items: center; }
        .status-select {
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

        .trending {
            background: #fb7185;
            color: white;
            padding: 24px;
            border-radius: 20px;
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
        .mb-10 { margin-bottom: 10px; }
        .m-0 { margin: 0; }
        .text-gray { color: gray; }
        .text-bold { font-weight: bold; }
        .fs-14 { font-size: 14px; }
        .empty-state { color: gray; padding: 12px 0; }

        .chart-wrap { position: relative; height: 300px; }
        
        .stat-label { color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: 700; }
        .stat-value { color: #be123c; font-size: 28px; font-weight: 800; margin-top: 8px; }

        @media (max-width: 800px) {
            .grid-3, .grid-2-1 { grid-template-columns: 1fr; }
        }
    </style>
@endsection

@section('content')
<div class="container">

    <div class="flex between mb-10">
        <h1>Admin Dashboard</h1>
        <div class="flex gap">
            <a href="{{ route('admin.export') }}" class="btn btn-export">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV Report
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="card" style="margin: 0 0 20px; color: #166534; background: #dcfce7; padding: 12px 24px; border-radius: 12px;">
            {{ session('status') }}
        </div>
    @endif

    <div class="tabs" style="display: flex; background: white; border-radius: 12px; padding: 4px; margin-bottom: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <a href="{{ route('admin.dashboard') }}" class="tab active" style="flex: 1; padding: 12px 24px; border-radius: 8px; text-align: center; text-decoration: none; color: white; font-weight: 500; background: #fb7185; box-shadow: 0 2px 8px rgba(251, 113, 133, 0.3);">Dashboard</a>
        <a href="{{ route('admin.inventory') }}" class="tab" style="flex: 1; padding: 12px 24px; border-radius: 8px; text-align: center; text-decoration: none; color: #6b7280; font-weight: 500; transition: all 0.2s;">Inventory</a>
        <a href="{{ route('admin.orders') }}" class="tab" style="flex: 1; padding: 12px 24px; border-radius: 8px; text-align: center; text-decoration: none; color: #6b7280; font-weight: 500; transition: all 0.2s;">Orders</a>
        <a href="{{ route('admin.users') }}" class="tab" style="flex: 1; padding: 12px 24px; border-radius: 8px; text-align: center; text-decoration: none; color: #6b7280; font-weight: 500; transition: all 0.2s;">Users</a>
    </div>

    <div class="grid grid-3">
        <div class="card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-label">REVENUE THIS MONTH</div>
            <div class="stat-value">PHP {{ number_format($monthlyRevenue, 2) }}</div>
            <div class="progress">
                <div class="progress-bar" @style(['width' => ($salesProgress ?? 50) . '%'])></div>
            </div>
        </div>

        <div class="card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-label">ORDERS THIS MONTH</div>
            <div class="stat-value">{{ $ordersThisMonth }}</div>
            <p class="text-gray fs-14">Active: {{ $activeOrders ?? 0 }} (Next: {{ $nextDelivery ?? 'N/A' }})</p>
        </div>

        <div class="card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-label">AVERAGE ORDER VALUE</div>
            <div class="stat-value">PHP {{ number_format($averageOrderValue, 2) }}</div>
            <p class="text-gray fs-14">{{ $lowStockCount ?? 0 }} items with low stock</p>
        </div>
    </div>

    <div class="grid grid-2-1 mt-24">
        <div class="card" data-aos="fade-right">
            <h3>Revenue Trend (Last 14 Days)</h3>
            <div class="chart-wrap"><canvas id="revenueLine"></canvas></div>
        </div>

        <div class="card" data-aos="fade-left">
            <h3>Orders by Status</h3>
            <div class="chart-wrap"><canvas id="statusPie"></canvas></div>
        </div>
    </div>

    <div class="grid grid-2-1 mt-24">
        <div class="card" data-aos="fade-up">
            <h3>Top Products Sold</h3>
            <div class="chart-wrap"><canvas id="productsBar"></canvas></div>
        </div>

        <div class="trending" data-aos="fade-up" data-aos-delay="200">
            <h3 style="color: white;">Trending This Week</h3>
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

    <div class="card mt-24" data-aos="fade-up">
        <div class="flex between mb-16">
            <h3>Recent Orders</h3>
            <a href="{{ route('admin.orders') }}" class="btn btn-light" style="font-size: 12px; padding: 6px 12px;">View All</a>
        </div>
        <div style="overflow-x: auto;">
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
                        <td colspan="5" class="empty-state" style="text-align: center; padding: 32px 0;">
                            <div style="font-size: 32px; margin-bottom: 8px;">🍪</div>
                            No customer orders yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    AOS.init({
        once: true,
        duration: 800,
        easing: 'ease-out-cubic'
    });

    const chartColors = ['#fb7185', '#f59e0b', '#22c55e', '#38bdf8', '#a78bfa', '#64748b', '#f97316', '#14b8a6'];

    // Revenue Line Chart
    new Chart(document.getElementById('revenueLine'), {
        type: 'line',
        data: {
            labels: @json($lineLabels),
            datasets: [{
                label: 'Revenue',
                data: @json($lineRevenue),
                borderColor: '#fb7185',
                backgroundColor: 'rgba(251, 113, 133, 0.15)',
                fill: true,
                tension: 0.35
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Top Products Bar Chart
    new Chart(document.getElementById('productsBar'), {
        type: 'bar',
        data: {
            labels: @json($barLabels),
            datasets: [{
                label: 'Quantity sold',
                data: @json($barValues),
                backgroundColor: '#fb7185',
                borderRadius: 6
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            indexAxis: 'y',
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                y: { grid: { display: false } }
            }
        }
    });

    // Status Pie Chart
    new Chart(document.getElementById('statusPie'), {
        type: 'pie',
        data: {
            labels: @json($pieLabels),
            datasets: [{
                data: @json($pieValues),
                backgroundColor: chartColors
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection