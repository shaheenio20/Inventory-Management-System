<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Stock Transactions') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('stock.create') }}" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-medium">
                        Add Stock Entry
                    </a>
                </div>
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('stock.index') }}" class="mb-6 grid gap-4 sm:grid-cols-[minmax(0,240px)_auto] items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Types</option>
                                <option value="in" {{ request('type') === 'in' ? 'selected' : '' }}>Stock In</option>
                                <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Stock Out</option>
                                <option value="adjustment" {{ request('type') === 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                                <option value="transfer" {{ request('type') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                        </div>
                        <div class="flex sm:justify-end">
                            <button type="submit" class="inline-flex w-full justify-center sm:w-auto items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-medium">Filter</button>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="p-4 font-semibold text-gray-600">Product</th>
                                    <th class="p-4 font-semibold text-gray-600">Type</th>
                                    <th class="p-4 font-semibold text-gray-600">Quantity</th>
                                    <th class="p-4 font-semibold text-gray-600">Reference</th>
                                    <th class="p-4 font-semibold text-gray-600">Notes</th>
                                    <th class="p-4 font-semibold text-gray-600">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-900">{{ $transaction->product->name ?? 'Unknown Product' }}</td>
                                    <td class="p-4 text-gray-700 capitalize">{{ $transaction->type }}</td>
                                    <td class="p-4 text-gray-700">{{ $transaction->quantity }}</td>
                                    <td class="p-4 text-gray-600">{{ $transaction->reference ?? '—' }}</td>
                                    <td class="p-4 text-gray-600">{{ $transaction->notes ?? '—' }}</td>
                                    <td class="p-4 text-gray-600">{{ $transaction->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-500 italic">No stock transactions have been recorded yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">{{ $transactions->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>