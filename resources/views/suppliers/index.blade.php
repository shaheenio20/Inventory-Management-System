<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Suppliers') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="mb-4 flex justify-end">
                        <a href="{{ route('suppliers.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition m-2">
                            Add Supplier
                        </a>
                    </div>
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="p-4 font-semibold text-gray-600">Name</th>
                                <th class="p-4 font-semibold text-gray-600">Email</th>
                                <th class="p-4 font-semibold text-gray-600">Phone</th>
                                <th class="p-4 font-semibold text-gray-600">Purchases</th>
                                <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $supplier)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 font-medium text-gray-900">{{ $supplier->name }}</td>
                                    <td class="p-4 text-gray-600">{{ $supplier->email ?? '—' }}</td>
                                    <td class="p-4 text-gray-600">{{ $supplier->phone ?? '—' }}</td>
                                    <td class="p-4 text-gray-700">{{ $supplier->purchases_count }}</td>
                                    <td class="p-4 text-right space-x-2 flex justify-end">
                                        <a href="{{ route('suppliers.show', $supplier->id) }}" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-200 transition">View</a>
                                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700 transition">Edit</a>
                                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-700 transition">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-gray-500 italic">No suppliers found. Click "Add Supplier" to create one.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
