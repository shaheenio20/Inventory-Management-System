<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Supplier Details') }}</h2>
            <a href="{{ route('suppliers.index') }}" class="text-gray-600 hover:text-gray-900">Back to Suppliers</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $supplier->name }}</h3>
                                <p class="text-sm text-gray-500">Supplier since {{ $supplier->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium text-gray-900">{{ $supplier->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium text-gray-900">{{ $supplier->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Address</p>
                                <p class="font-medium text-gray-900">{{ $supplier->address ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Purchase History</h3>
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">{{ $supplier->purchases->count() }} orders</span>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-100 border-b">
                                            <th class="p-4 font-semibold text-gray-600">Reference</th>
                                            <th class="p-4 font-semibold text-gray-600">Date</th>
                                            <th class="p-4 font-semibold text-gray-600">Total</th>
                                            <th class="p-4 font-semibold text-gray-600">Status</th>
                                            <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($supplier->purchases as $purchase)
                                            <tr class="border-b hover:bg-gray-50 transition">
                                                <td class="p-4 text-gray-900">{{ $purchase->reference_no }}</td>
                                                <td class="p-4 text-gray-600">{{ $purchase->purchase_date->format('M d, Y') }}</td>
                                                <td class="p-4 text-gray-700">${{ number_format($purchase->total_amount, 2) }}</td>
                                                <td class="p-4 text-gray-600">{{ ucfirst($purchase->status) }}</td>
                                                <td class="p-4 text-right">
                                                    <a href="{{ route('purchases.show', $purchase->id) }}" class="text-blue-600 hover:underline">View</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="p-6 text-center text-gray-500 italic">No purchase history for this supplier yet.</td>
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
    </div>
</x-admin-layout>
