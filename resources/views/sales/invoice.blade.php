<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Invoice') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('sales.index') }}" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                        Back to Sale
                    </a>
                </div>
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">Invoice</h3>
                                <p class="text-sm text-gray-500">Invoice No: {{ $sale->invoice_no }}</p>
                                <p class="text-sm text-gray-500">Date: {{ $sale->sale_date->format('M d, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Customer</p>
                                <p class="font-medium text-gray-900">{{ $sale->customer_name ?? 'Walk-in' }}</p>
                                <p class="text-gray-500">{{ $sale->customer_phone ?? 'No phone' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mb-6">
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

                    <div class="flex justify-end">
                        <div class="w-full md:w-1/3 bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between text-gray-600 mb-2">
                                <span>Subtotal</span>
                                <span>${{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-900 font-semibold text-lg">
                                <span>Total</span>
                                <span>${{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 text-right">
                        <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-medium">Print Invoice</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>