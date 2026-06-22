<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Purchase Orders') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="mb-4 flex justify-end">
                        <a href="{{ route('purchases.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition m-2 font-medium">
                            Add Purchase Order
                        </a>
                    </div>
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="p-4 font-semibold text-gray-600">Reference</th>
                                    <th class="p-4 font-semibold text-gray-600">Supplier</th>
                                    <th class="p-4 font-semibold text-gray-600">Date</th>
                                    <th class="p-4 font-semibold text-gray-600">Total</th>
                                    <th class="p-4 font-semibold text-gray-600">Status</th>
                                    <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $purchase)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="p-4 text-gray-900">{{ $purchase->reference_no }}</td>
                                        <td class="p-4 text-gray-600">{{ $purchase->supplier->name ?? 'N/A' }}</td>
                                        <td class="p-4 text-gray-600">{{ $purchase->purchase_date->format('M d, Y') }}</td>
                                        <td class="p-4 text-gray-700">${{ number_format($purchase->total_amount, 2) }}</td>
                                        <td class="p-4 text-gray-600">{{ ucfirst($purchase->status) }}</td>
                                        <td class="p-4 text-right">
                                            <a href="{{ route('purchases.show', $purchase->id) }}" class="text-blue-600 hover:underline">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-6 text-center text-gray-500 italic">No purchase orders found yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">{{ $purchases->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
