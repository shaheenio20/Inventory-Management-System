<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Purchase Order') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('purchases.index') }}" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-medium">
                        Back to Purchase
                    </a>
                </div>
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Supplier</h3>
                            <p class="text-gray-700">{{ $purchase->supplier->name ?? 'N/A' }}</p>
                            <p class="text-gray-500 text-sm">{{ $purchase->supplier->email ?? 'No email provided' }}</p>
                            <p class="text-gray-500 text-sm">{{ $purchase->supplier->phone ?? 'No phone number' }}</p>
                            <p class="text-gray-500 text-sm">{{ $purchase->supplier->address ?? 'No address available' }}</p>
                        </div>
                        <div>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">Reference</span>
                                    <p class="font-medium text-gray-900">{{ $purchase->reference_no }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Purchase Date</span>
                                    <p class="font-medium text-gray-900">{{ $purchase->purchase_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Total Amount</span>
                                    <p class="font-medium text-gray-900">${{ number_format($purchase->total_amount, 2) }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Status</span>
                                    <p class="font-medium text-gray-900 capitalize">{{ $purchase->status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Purchase Items</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="p-4 font-semibold text-gray-600">Product</th>
                                        <th class="p-4 font-semibold text-gray-600">Quantity</th>
                                        <th class="p-4 font-semibold text-gray-600">Unit Cost</th>
                                        <th class="p-4 font-semibold text-gray-600">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase->items as $item)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="p-4 text-gray-900">{{ $item->product->name ?? 'Unknown product' }}</td>
                                        <td class="p-4 text-gray-700">{{ $item->quantity }}</td>
                                        <td class="p-4 text-gray-700">${{ number_format($item->unit_cost, 2) }}</td>
                                        <td class="p-4 text-gray-700">${{ number_format($item->quantity * $item->unit_cost, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($purchase->status === 'pending')
                    <form method="POST" action="{{ route('purchases.receive', $purchase->id) }}" class="mt-6">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-medium">Receive Purchase</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>