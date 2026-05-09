@extends('layouts.app')

@section('title', 'Analytics | SugarLoom PH')

@section('styles')
    <style>
        body { background: #fdf2f8; color: #111827; }
        .container { max-width: 1200px; margin: auto; padding: 24px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; }
        h1 { font-size: 24px; margin: 0; font-weight: 600; }
        h2 { font-size: 15px; margin: 0 0 16px; font-weight: 700; }
        .btn { padding: 10px 18px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; font-size: 14px; }
        .btn-light { background: #f3f4f6; color: #374151; }
        .tabs { display: flex; background: white; border-radius: 8px; padding: 4px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
        .tab { flex: 1; padding: 12px 16px; border-radius: 6px; text-align: center; text-decoration: none; color: #6b7280; font-weight: 600; font-size: 14px; }
        .tab.active { background: #fb7185; color: white; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card, .chart-card { background: white; border-radius: 8px; padding: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
        .stat-label { color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: 700; letter-spacing: 0; }
        .stat-value { color: #be123c; font-size: 28px; font-weight: 800; margin-top: 8px; }
        .chart-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 16px; }
        .chart-card.wide { grid-column: span 2; }
        .chart-wrap { position: relative; height: 320px; }
        @media (max-width: 800px) {
            .stats-grid, .chart-grid { grid-template-columns: 1fr; }
            .chart-card.wide { grid-column: span 1; }
            .tabs { overflow-x: auto; }
            .tab { min-width: 120px; }
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="header">
        <h1>Analytics</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Back to Dashboard</a>
    </div>

    <div class="tabs">
        <a href="{{ route('admin.dashboard') }}" class="tab">Dashboard</a>
        <a href="{{ route('admin.inventory') }}" class="tab">Inventory</a>
        <a href="{{ route('admin.orders') }}" class="tab">Orders</a>
        <a href="{{ route('admin.analytics') }}" class="tab active">Analytics</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Revenue This Month</div>
            <div class="stat-value">PHP {{ number_format($monthlyRevenue, 2) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Orders This Month</div>
            <div class="stat-value">{{ $ordersThisMonth }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Average Order Value</div>
            <div class="stat-value">PHP {{ number_format($averageOrderValue, 2) }}</div>
        </div>
    </div>

    <div class="chart-grid">
        <div class="chart-card wide">
            <h2>Revenue Trend, Last 14 Days</h2>
            <div class="chart-wrap"><canvas id="revenueLine"></canvas></div>
        </div>

        <div class="chart-card">
            <h2>Top Products Sold</h2>
            <div class="chart-wrap"><canvas id="productsBar"></canvas></div>
        </div>

        <div class="chart-card">
            <h2>Orders by Status</h2>
            <div class="chart-wrap"><canvas id="statusPie"></canvas></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartColors = ['#fb7185', '#f59e0b', '#22c55e', '#38bdf8', '#a78bfa', '#64748b', '#f97316', '#14b8a6'];

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
        options: { responsive: true, maintainAspectRatio: false }
    });

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
        options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y' }
    });

    new Chart(document.getElementById('statusPie'), {
        type: 'pie',
        data: {
            labels: @json($pieLabels),
            datasets: [{
                data: @json($pieValues),
                backgroundColor: chartColors
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endsection
