<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Product Details') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3 space-y-2">
                <div class="mb-1 flex justify-end">
                    <a href="{{ route('products.index') }}" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-medium">
                        Back to Product
                    </a>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="font-semibold text-gray-900 text-lg mb-3">Overview</h3>
                        <p class="text-gray-700 mb-3"><strong>Product Code:</strong> {{ $product->product_code }}</p>
                        <p class="text-gray-700 mb-3"><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                        <p class="text-gray-700 mb-3"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        <p class="text-gray-700 mb-3"><strong>Current Stock:</strong> {{ $product->stock_quantity }}</p>
                        <p class="text-gray-700 mb-3"><strong>Inventory Value:</strong> ${{ number_format($product->stock_quantity * $product->price, 2) }}</p>
                    </div>

                    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
                        <h3 class="font-semibold text-gray-900 text-lg mb-4">Movement History</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="p-4 text-sm font-semibold text-gray-600">Date</th>
                                        <th class="p-4 text-sm font-semibold text-gray-600">Type</th>
                                        <th class="p-4 text-sm font-semibold text-gray-600">Qty</th>
                                        <th class="p-4 text-sm font-semibold text-gray-600">Reference</th>
                                        <th class="p-4 text-sm font-semibold text-gray-600">Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($product->stockTransactions()->latest()->get() as $transaction)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="p-4 text-gray-700">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                        <td class="p-4 text-gray-700 capitalize">{{ $transaction->type }}</td>
                                        <td class="p-4 text-gray-700">{{ $transaction->quantity }}</td>
                                        <td class="p-4 text-gray-600">{{ $transaction->reference ?? '—' }}</td>
                                        <td class="p-4 text-gray-600">{{ $transaction->notes ?? '—' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="p-6 text-center text-gray-500 italic">No stock movement recorded for this product yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>