<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>
                :root {
            --pink-deep:   #d8547b; 
            --pink-nav: #e06b87;
            --pink-light:  #f8bac9;
            --pink-pale:   #ffd7e1;
            --cream:       #fffcfc; 
            --dark:        #1a1018;
            --text-body:   #4a3d45;
            --text-muted:  #8a7080;
            --white:       #ffffff;
            --gray-btn:    #f3eff1;
            --radius-card: 24px;
            --radius-pill: 999px;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 4rem;
            height: 70px;
            background: var(--pink-nav);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .logo {
            font-size: 1.1rem;
            font-weight: 900;
            color: white;
            letter-spacing: 0;
            text-decoration: none;
        }
        .nav-links {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 2.5rem;
        }

        .nav-links a {
            color: var(--white);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 400;
            transition: opacity 0.2s;
        }

        .nav-links a:hover { opacity: 0.8; }
        .nav-links a.active { color: var(--white); }

        .nav-actions {
            display: flex;
            gap: 0.8rem;
        }

        .nav-actions > button,
        .nav-actions > a,
        .nav-actions > span {
            width: 38px; height: 38px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.5);
            background: transparent;
            color: var(--dark);
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: background 0.2s;
            padding: 0;
        }
        .nav-actions > button:hover,
        .nav-actions > a:hover,
        .nav-actions > span:hover { background: rgba(255,255,255,0.2); }
        .nav-actions svg { width: 16px; height: 16px; fill: currentColor; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fdf2f8;
            color: #111827;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 24px;
        }

        .flex {
            display: flex;
        }

        .between {
            justify-content: space-between;
            align-items: center;
        }

        .gap {
            gap: 16px;
        }

        .grid {
            display: grid;
            gap: 24px;
        }

        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .grid-2-1 {
            grid-template-columns: 2fr 1fr;
        }

        .card {
            margin: 20px;
            background: white;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        h1 {
            font-size: 24px;
            margin: 0;
        }

        h2 {
            font-size: 28px;
            margin: 10px 0;
        }

        h3 {
            margin-bottom: 16px;
        }

        .btn {
            padding: 10px 16px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
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

        .badge {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
        }

        .blue { background: #dbeafe; color: #2563eb; }
        .green { background: #dcfce7; color: #16a34a; }
        .yellow { background: #fef9c3; color: #ca8a04; }

        .inventory-item {
            margin-bottom: 16px;
        }

        .inventory-top {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .text-red {
            color: red;
        }

        .trending {
            background: #fb7185;
            color: white;
            padding: 24px;
            border-radius: 20px;
            margin-top: 24px;
            max-width: 400px;
        }

        .trend-item {
            display: flex;
            justify-content: space-between;
            background: white;
            color: black;
            padding: 10px 16px;
            border-radius: 999px;
            margin-bottom: 10px;
        }

    </style>
</head>

<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="logo">SugarLoom PH</a>
    <div class="nav-links">
        <a href="{{ route('catalog') }}">Catalog</a>
        <a href="{{ route('track-order') }}">Track Order</a>
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </div>
    <div class="nav-actions">
        <a href="{{ route('cart.index') }}" aria-label="Cart">
            <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
        </a>
        <span aria-label="Account">
            <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        </span>
    </div>
</nav>

<div class="container">

    <!-- HEADER -->
    <div class="flex between">
        <h1>Dashboard</h1>

        <div class="flex gap">
            <button class="btn btn-light">Export Report</button>
            <button class="btn btn-primary">+ New Batch</button>
        </div>
    </div>

    <!-- STATS -->
    <div class="grid grid-3">

        <div class="card">
            <p>TOTAL SALES</p>
            <h2>₱{{ number_format($totalSales ?? 0, 2) }}</h2>

            <div class="progress">
                <div class="progress-bar" style="width: {{ $salesProgress ?? 50 }}%"></div>
            </div>
        </div>

        <div class="card">
            <p>ACTIVE ORDERS</p>
            <h2>{{ $activeOrders ?? 0 }}</h2>
            <p>Next delivery in {{ $nextDelivery ?? 'N/A' }}</p>
        </div>

        <div class="card">
            <p>LOW STOCK ALERTS</p>
            <h2>{{ $lowStockCount ?? 0 }} Items</h2>
        </div>

    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-2-1">

        <div class="card">
            <h3>Demand Prediction</h3>

            <div class="chart">
                @foreach($demandData ?? [50,70,90,120,110,80,60] as $value)
                    <div class="bar" style="height: {{ $value }}px"></div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <h3>Inventory</h3>

            @foreach($inventory ?? [] as $item)
                <div class="inventory-item">

                    <div class="inventory-top">
                        <span>{{ $item['name'] }}</span>
                        <span class="text-red">{{ $item['stock'] }}</span>
                    </div>

                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $item['percent'] ?? 0 }}%"></div>
                    </div>

                </div>
            @endforeach

            <button class="btn btn-light" style="width:100%; margin-top:10px;">
                Update Stock Levels
            </button>
        </div>

    </div>

    <!-- ORDERS -->
    <div class="card" style="margin-top: 24px;">
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
                    <td>{{ $order['id'] }}</td>
                    <td>{{ $order['customer'] }}</td>
                    <td>{{ $order['item'] }}</td>

                    <td>
                        <span class="badge
                            @if($order['status']=='Preparing') blue
                            @elseif($order['status']=='Delivered') green
                            @else yellow
                            @endif">
                            {{ $order['status'] }}
                        </span>
                    </td>

                    <td>₱{{ number_format($order['amount'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- TRENDING -->
    <div class="trending">
        <h3>Trending This Week</h3>

        @foreach($trending ?? [] as $trend)
            <div class="trend-item">
                <span>{{ $trend['name'] }}</span>
                <span>{{ $trend['percent'] }}%</span>
            </div>
        @endforeach
    </div>

</div>

</body>
</html>
