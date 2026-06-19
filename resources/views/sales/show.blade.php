<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Sale Details') }}</h2>
            <a href="{{ route('sales.index') }}" class="text-gray-600 hover:text-gray-900">Back to Sales</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Customer</h3>
                            <p class="text-gray-700">{{ $sale->customer_name ?? 'Walk-in' }}</p>
                            <p class="text-gray-500 text-sm">{{ $sale->customer_phone ?? 'No phone provided' }}</p>
                        </div>
                        <div>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">Invoice</span>
                                    <p class="font-medium text-gray-900">{{ $sale->invoice_no }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Sale Date</span>
                                    <p class="font-medium text-gray-900">{{ $sale->sale_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Total Amount</span>
                                    <p class="font-medium text-gray-900">${{ number_format($sale->total_amount, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Products Sold</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="p-4 font-semibold text-gray-600">Product</th>
                                        <th class="p-4 font-semibold text-gray-600">Quantity</th>
                                        <th class="p-4 font-semibold text-gray-600">Unit Price</th>
                                        <th class="p-4 font-semibold text-gray-600">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale->items as $item)
                                        <tr class="border-b hover:bg-gray-50 transition">
                                            <td class="p-4 text-gray-900">{{ $item->product->name ?? 'Unknown product' }}</td>
                                            <td class="p-4 text-gray-700">{{ $item->quantity }}</td>
                                            <td class="p-4 text-gray-700">${{ number_format($item->unit_price, 2) }}</td>
                                            <td class="p-4 text-gray-700">${{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
