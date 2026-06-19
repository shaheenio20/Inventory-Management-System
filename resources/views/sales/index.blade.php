<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Sales Records') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="mb-4 flex justify-end">
                        <a href="{{ route('sales.create') }}" class="bg-indigo-600 m-2 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                            Add Sale
                        </a>
                    </div>
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="p-4 font-semibold text-gray-600">Invoice</th>
                                    <th class="p-4 font-semibold text-gray-600">Customer</th>
                                    <th class="p-4 font-semibold text-gray-600">Date</th>
                                    <th class="p-4 font-semibold text-gray-600">Total</th>
                                    <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="p-4 text-gray-900">{{ $sale->invoice_no }}</td>
                                        <td class="p-4 text-gray-600">{{ $sale->customer_name ?? 'Walk-in' }}</td>
                                        <td class="p-4 text-gray-600">{{ $sale->sale_date->format('M d, Y') }}</td>
                                        <td class="p-4 text-gray-700">${{ number_format($sale->total_amount, 2) }}</td>
                                        <td class="p-4 text-right space-x-2 flex justify-end">
                                            <a href="{{ route('sales.show', $sale->id) }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-200 transition">View</a>
                                            <a href="{{ route('sales.invoice', $sale->id) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700 transition">Invoice</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-6 text-center text-gray-500 italic">No sales have been recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">{{ $sales->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
