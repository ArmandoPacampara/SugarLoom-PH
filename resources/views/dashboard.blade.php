<!-- @format -->
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-50 text-gray-900">

<div class="max-w-7xl mx-auto p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold">Dashboard</h1>

        <div class="flex gap-4">
            <button class="bg-white shadow px-4 py-2 rounded-full">
                Export Report
            </button>
            <button class="bg-rose-400 text-white px-4 py-2 rounded-full">
                + New Batch
            </button>
        </div>
    </div>

    <!-- STATS -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">

        <!-- TOTAL SALES -->
        <div class="bg-white p-6 rounded-3xl shadow-lg">
            <p class="text-sm text-gray-500">TOTAL SALES</p>

            <h2 class="text-3xl font-bold mt-2">
                ₱{{ number_format($totalSales ?? 0, 2) }}
            </h2>

            <div class="w-full bg-pink-100 h-2 rounded mt-4">
                <div class="bg-rose-400 h-2 rounded"
                     style="width: {{ $salesProgress ?? 50 }}%">
                </div>
            </div>
        </div>

        <!-- ACTIVE ORDERS -->
        <div class="bg-white p-6 rounded-3xl shadow-lg">
            <p class="text-sm text-gray-500">ACTIVE ORDERS</p>

            <h2 class="text-3xl font-bold mt-2">
                {{ $activeOrders ?? 0 }}
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Next delivery in {{ $nextDelivery ?? 'N/A' }}
            </p>
        </div>

        <!-- LOW STOCK -->
        <div class="bg-white p-6 rounded-3xl shadow-lg">
            <p class="text-sm text-gray-500">LOW STOCK ALERTS</p>

            <h2 class="text-3xl font-bold mt-2">
                {{ $lowStockCount ?? 0 }} Items
            </h2>
        </div>

    </div>


    <!-- MAIN GRID -->
    <div class="grid md:grid-cols-3 gap-6">

        <!-- DEMAND CHART -->
        <div class="md:col-span-2 bg-white p-6 rounded-3xl shadow-lg">

            <h3 class="font-semibold mb-4">Demand Prediction</h3>

            <div class="flex items-end gap-4 h-40">
                @foreach($demandData ?? [50,70,90,120,110,80,60] as $value)
                    <div class="bg-rose-300 w-full rounded-t-xl"
                         style="height: {{ $value }}px">
                    </div>
                @endforeach
            </div>

        </div>


        <!-- INVENTORY -->
        <div class="bg-white p-6 rounded-3xl shadow-lg">

            <h3 class="font-semibold mb-4">Inventory</h3>

            @foreach($inventory ?? [] as $item)
                <div class="mb-4">

                    <div class="flex justify-between text-sm">
                        <span>{{ $item['name'] }}</span>
                        <span class="text-red-500">{{ $item['stock'] }}</span>
                    </div>

                    <div class="w-full bg-pink-100 h-2 rounded mt-1">
                        <div class="bg-rose-400 h-2 rounded"
                             style="width: {{ $item['percent'] ?? 0 }}%">
                        </div>
                    </div>

                </div>
            @endforeach

            <button class="w-full mt-4 bg-pink-100 py-2 rounded-full">
                Update Stock Levels
            </button>

        </div>

    </div>


    <!-- ORDERS -->
    <div class="bg-white p-6 rounded-3xl mt-8 shadow-lg">

        <h3 class="font-semibold mb-4">Recent Orders</h3>

        <table class="w-full text-sm">

            <thead>
                <tr class="text-gray-500 text-left">
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Item</th>
                    <th>Status</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders ?? [] as $order)
                <tr class="border-t">

                    <td>{{ $order['id'] }}</td>
                    <td>{{ $order['customer'] }}</td>
                    <td>{{ $order['item'] }}</td>

                    <td>
                        <span class="px-2 py-1 rounded-full text-xs
                            @if($order['status'] == 'Preparing') bg-blue-100 text-blue-600
                            @elseif($order['status'] == 'Delivered') bg-green-100 text-green-600
                            @else bg-yellow-100 text-yellow-600
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


    <!-- TRENDING (DARKER PINK) -->
    <div class="bg-rose-400 text-white p-6 rounded-3xl mt-8 max-w-md shadow-lg">

        <h3 class="font-semibold mb-4">Trending This Week</h3>

        @foreach($trending ?? [] as $trend)
            <div class="flex justify-between bg-white text-gray-900 rounded-full px-4 py-2 mb-2">
                <span>{{ $trend['name'] }}</span>
                <span class="font-semibold">{{ $trend['percent'] }}%</span>
            </div>
        @endforeach

    </div>

</div>

</body>
</html>