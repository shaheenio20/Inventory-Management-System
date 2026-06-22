<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Reports & Analysis') }}</h2>
            <div class="flex items-center gap-2">
                <a href="?period=daily" class="px-3 py-2 rounded-md text-sm font-medium {{ $period === 'daily' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-200' }}">Daily</a>
                <a href="?period=monthly" class="px-3 py-2 rounded-md text-sm font-medium {{ $period === 'monthly' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-200' }}">Monthly</a>
                <a href="?period=yearly" class="px-3 py-2 rounded-md text-sm font-medium {{ $period === 'yearly' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-200' }}">Yearly</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 uppercase tracking-wider">Total Sales</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-3">
                        ${{ number_format($totalSalesValue, 2) }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Orders: {{ $totalSalesCount }}</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 uppercase tracking-wider">Total Purchase Cost</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-3">
                        ${{ number_format($totalPurchaseCost, 2) }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">For {{ ucfirst($period) }}</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 uppercase tracking-wider">Gross Profit</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-3">
                        ${{ number_format($grossProfit, 2) }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Margin: {{ $grossProfitMargin }}%</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 uppercase tracking-wider">Current Inventory Value</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-3">
                        ${{ number_format($stockValue, 2) }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Updated: {{ optional($latestInventoryUpdate)->format('M d, Y H:i') ?? 'No transactions' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 bg-white rounded-xl shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Stock Report</h3>
                        <span class="text-sm text-gray-500">Sorted by quantity</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="p-4 text-sm font-semibold text-gray-600">Product</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Stock</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Price</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockReportProducts as $item)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-900">{{ $item->name }}</td>
                                    <td class="p-4 text-gray-700">{{ $item->stock_quantity }}</td>
                                    <td class="p-4 text-gray-700">${{ number_format($item->price, 2) }}</td>
                                    <td class="p-4 text-gray-900 font-semibold">${{ number_format($item->stock_quantity * $item->price, 2) }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="p-6 text-center text-gray-500 italic">No products available.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Low Stock Products</h3>
                    <div class="space-y-3">
                        @forelse($lowStockProducts as $product)
                        <div class="rounded-lg border border-gray-200 p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $product->product_code }}</p>
                                </div>
                                <span class="text-sm font-bold text-red-600">{{ $product->stock_quantity }}</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 italic">No low stock alerts.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Top Selling Products</h3>
                    <span class="text-sm text-gray-500">By quantity sold</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="p-4 text-sm font-semibold text-gray-600">Product</th>
                                <th class="p-4 text-sm font-semibold text-gray-600">Sold Qty</th>
                                <th class="p-4 text-sm font-semibold text-gray-600">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topSellingProducts as $item)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-900">{{ $item->product->name ?? 'Unknown' }}</td>
                                <td class="p-4 text-gray-700">{{ $item->sold_quantity }}</td>
                                <td class="p-4 text-gray-900 font-semibold">${{ number_format($item->sales_value, 2) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="p-6 text-center text-gray-500 italic">No sales data yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
