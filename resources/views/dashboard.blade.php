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

    <!-- STATS -->
    <div class="grid grid-3">
        <div class="card m-0" data-aos="fade-up" data-aos-delay="100">
            <p class="text-gray mt-0">TOTAL SALES</p>
            <h2>₱{{ number_format($totalSales ?? 0, 2) }}</h2>
            <div class="progress">
                <div class="progress-bar" @style(['width' => ($salesProgress ?? 50) . '%'])></div>
            </div>
        </div>

        <div class="card m-0" data-aos="fade-up" data-aos-delay="200">
            <p class="text-gray mt-0">ACTIVE ORDERS</p>
            <h2>{{ $activeOrders ?? 0 }}</h2>
            <p class="text-gray fs-14">Next delivery in {{ $nextDelivery ?? 'N/A' }}</p>
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
            <h3>Inventory</h3>
            @foreach($inventory ?? [] as $item)
                <div class="inventory-item">
                    <div class="inventory-top">
                        <span>{{ $item['name'] }}</span>
                        <span class="text-red">{{ $item['stock'] }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" @style(['width' => ($item['percent'] ?? 0) . '%', 'transition-delay' => (0.5 + $loop->index * 0.1) . 's'])></div>
                    </div>
                </div>
            @endforeach
            <button class="btn btn-light w-full mt-16">
                Update Stock Levels
            </button>
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
                    @foreach($orders ?? [] as $order)
                    <tr>
                        <td class="text-bold">{{ $order['id'] }}</td>
                        <td>{{ $order['customer'] }}</td>
                        <td class="text-gray">{{ $order['item'] }}</td>
                        <td>
                            <span class="badge 
                                @if($order['status']=='Preparing') blue 
                                @elseif($order['status']=='Delivered') green 
                                @else yellow 
                                @endif">
                                {{ $order['status'] }}
                            </span>
                        </td>
                        <td class="text-bold">₱{{ number_format($order['amount'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- TRENDING -->
        <div class="trending m-0" style="max-width: none;" data-aos="fade-up" data-aos-delay="200">
            <h3 class="mt-0">Trending This Week</h3>
            @foreach($trending ?? [] as $trend)
                <div class="trend-item">
                    <span>{{ $trend['name'] }}</span>
                    <span>{{ $trend['percent'] }}%</span>
                </div>
            @endforeach
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
