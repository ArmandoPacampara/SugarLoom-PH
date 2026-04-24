@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 mt-8">

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold" style="color: var(--text-dark)">Dashboard</h1>

        <div class="flex gap-4">
            <button class="bg-white shadow px-4 py-2 rounded-full font-semibold text-sm transition hover:-translate-y-0.5" style="color: var(--text-body)">
                Export Report
            </button>
            <button class="px-4 py-2 rounded-full text-white font-semibold text-sm transition hover:-translate-y-0.5" style="background: var(--pink-btn); box-shadow: 0 4px 14px rgba(206, 90, 122, 0.3);">
                + New Batch
            </button>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white p-6 rounded-3xl shadow-lg border border-pink-50">
            <p class="text-sm font-semibold uppercase tracking-wider" style="color: var(--text-muted)">Total Sales</p>

            <h2 class="text-3xl font-bold mt-2" style="color: var(--text-dark)">
                ₱{{ number_format($totalSales ?? 0, 2) }}
            </h2>

            <div class="w-full bg-pink-100 h-2 rounded mt-4">
                <div class="h-2 rounded"
                     style="background: var(--pink-btn)"
                     @style(['width: ' . ($salesProgress ?? 50) . '%'])>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-lg border border-pink-50">
            <p class="text-sm font-semibold uppercase tracking-wider" style="color: var(--text-muted)">Active Orders</p>

            <h2 class="text-3xl font-bold mt-2" style="color: var(--text-dark)">
                {{ $activeOrders ?? 0 }}
            </h2>

            <p class="text-sm mt-2 font-medium" style="color: var(--text-body)">
                Next delivery in {{ $nextDelivery ?? 'N/A' }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-lg border border-pink-50">
            <p class="text-sm font-semibold uppercase tracking-wider" style="color: var(--text-muted)">Low Stock Alerts</p>

            <h2 class="text-3xl font-bold mt-2" style="color: var(--text-dark)">
                {{ $lowStockCount ?? 0 }} Items
            </h2>
        </div>

    </div>

    <div class="grid md:grid-cols-3 gap-6">

        <div class="md:col-span-2 bg-white p-6 rounded-3xl shadow-lg border border-pink-50">
            <h3 class="font-bold mb-6 text-lg" style="color: var(--text-dark)">Demand Prediction</h3>

            <div class="flex items-end gap-4 h-40">
                @foreach($demandData ?? [50,70,90,120,110,80,60] as $value)
                    <div class="w-full rounded-t-xl opacity-80 hover:opacity-100 transition"
                         style="background: var(--pink-nav)"
                         @style(['height: ' . $value . 'px'])>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-lg border border-pink-50">
            <h3 class="font-bold mb-6 text-lg" style="color: var(--text-dark)">Inventory</h3>

            @foreach($inventory ?? [] as $item)
                <div class="mb-4">
                    <div class="flex justify-between text-sm font-medium mb-1">
                        <span style="color: var(--text-body)">{{ $item['name'] }}</span>
                        <span class="text-red-500">{{ $item['stock'] }}</span>
                    </div>

                    <div class="w-full bg-pink-100 h-2 rounded">
                        <div class="h-2 rounded"
                             style="background: var(--pink-btn)"
                             @style(['width: ' . ($item['percent'] ?? 0) . '%'])>
                        </div>
                    </div>
                </div>
            @endforeach

            <button class="w-full mt-6 py-2.5 rounded-full font-semibold text-sm transition" style="background: var(--pink-bg-base); color: var(--text-dark)">
                Update Stock Levels
            </button>
        </div>

    </div>

    <div class="bg-white p-6 rounded-3xl mt-8 shadow-lg border border-pink-50">
        <h3 class="font-bold mb-4 text-lg" style="color: var(--text-dark)">Recent Orders</h3>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b border-pink-100">
                    <th class="pb-3 font-semibold" style="color: var(--text-muted)">Order ID</th>
                    <th class="pb-3 font-semibold" style="color: var(--text-muted)">Customer</th>
                    <th class="pb-3 font-semibold" style="color: var(--text-muted)">Item</th>
                    <th class="pb-3 font-semibold" style="color: var(--text-muted)">Status</th>
                    <th class="pb-3 font-semibold" style="color: var(--text-muted)">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders ?? [] as $order)
                <tr class="border-b border-pink-50 last:border-0 hover:bg-pink-50/30 transition">
                    <td class="py-3 font-medium" style="color: var(--text-dark)">{{ $order['id'] }}</td>
                    <td class="py-3" style="color: var(--text-body)">{{ $order['customer'] }}</td>
                    <td class="py-3" style="color: var(--text-body)">{{ $order['item'] }}</td>
                    <td class="py-3">
                        <span @class([
                            'px-3 py-1 rounded-full text-xs font-semibold',
                            'bg-blue-100 text-blue-700'   => $order['status'] == 'Preparing',
                            'bg-green-100 text-green-700' => $order['status'] == 'Delivered',
                            'bg-yellow-100 text-yellow-700' => $order['status'] != 'Preparing' && $order['status'] != 'Delivered'
                        ])>
                            {{ $order['status'] }}
                        </span>
                    </td>
                    <td class="py-3 font-bold" style="color: var(--text-dark)">₱{{ number_format($order['amount'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-6 rounded-3xl mt-8 max-w-md shadow-lg" style="background: var(--text-accent); color: white;">
        <h3 class="font-bold mb-4 text-lg">Trending This Week</h3>

        @foreach($trending ?? [] as $trend)
            <div class="flex justify-between bg-white/10 rounded-full px-5 py-2.5 mb-3 backdrop-blur-sm border border-white/20">
                <span class="font-medium">{{ $trend['name'] }}</span>
                <span class="font-bold">{{ $trend['percent'] }}%</span>
            </div>
        @endforeach
    </div>

</div>
@endsection