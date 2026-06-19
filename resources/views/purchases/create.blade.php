<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('New Purchase Order') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="mb-4 flex justify-end">
                        <a href="{{ route('purchases.index') }}" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                            Back to Purchases
                        </a>
                    </div>
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('purchases.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="supplier_id" :value="__('Supplier')" />
                                <select id="supplier_id" name="supplier_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="" disabled selected>Select a supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="purchase_date" :value="__('Purchase Date')" />
                                <x-text-input id="purchase_date" name="purchase_date" type="date" class="mt-1 block w-full" value="{{ old('purchase_date') }}" required />
                                <x-input-error :messages="$errors->get('purchase_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Purchase Items') }}</h3>

                            <div id="purchase-items" class="space-y-4">
                                @for($i = 0; $i < 3; $i++)
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end border border-gray-200 rounded-lg p-4">
                                        <div>
                                            <x-input-label :for="'products['.$i.'][product_id]'" :value="__('Product')" />
                                            <select id="products[{{ $i }}][product_id]" name="products[{{ $i }}][product_id]" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="" selected>Choose product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label :for="'products['.$i.'][quantity]'" :value="__('Quantity')" />
                                            <x-text-input id="products[{{ $i }}][quantity]" name="products[{{ $i }}][quantity]" type="number" min="1" class="mt-1 block w-full" />
                                        </div>
                                        <div>
                                            <x-input-label :for="'products['.$i.'][unit_cost]'" :value="__('Unit Cost')" />
                                            <x-text-input id="products[{{ $i }}][unit_cost]" name="products[{{ $i }}][unit_cost]" type="number" step="0.01" min="0" class="mt-1 block w-full" />
                                        </div>
                                        <button type="button" onclick="removePurchaseRow(this)" class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
                                    </div>
                                @endfor
                            </div>

                            <button type="button" onclick="addPurchaseRow()" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Add another item</button>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('purchases.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button>{{ __('Save Purchase Order') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addPurchaseRow() {
            const container = document.getElementById('purchase-items');
            const index = container.children.length;
            const row = document.createElement('div');
            row.className = 'grid grid-cols-1 md:grid-cols-4 gap-4 items-end border border-gray-200 rounded-lg p-4';
            row.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="products[${index}][product_id]">Product</label>
                    <select id="products[${index}][product_id]" name="products[${index}][product_id]" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="" selected>Choose product</option>
                        ${Array.from(document.querySelectorAll('#purchase-items select[id^="products"] option')).map(option => option.outerHTML).join('')}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="products[${index}][quantity]">Quantity</label>
                    <input id="products[${index}][quantity]" name="products[${index}][quantity]" type="number" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="products[${index}][unit_cost]">Unit Cost</label>
                    <input id="products[${index}][unit_cost]" name="products[${index}][unit_cost]" type="number" step="0.01" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <button type="button" onclick="removePurchaseRow(this)" class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
            `;
            container.appendChild(row);
        }

        function removePurchaseRow(button) {
            const row = button.closest('div.grid');
            if (row && document.querySelectorAll('#purchase-items > div').length > 1) {
                row.remove();
            }
        }
    </script>
</x-admin-layout>
