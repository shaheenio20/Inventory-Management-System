<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Sale') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="mb-4 flex justify-end">
                        <a href="{{ route('sales.index') }}" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                            Back to Sales
                        </a>
                    </div>
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('sales.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="customer_name" :value="__('Customer Name')" />
                                <x-text-input id="customer_name" name="customer_name" type="text" class="mt-1 block w-full" value="{{ old('customer_name') }}" />
                                <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="customer_phone" :value="__('Customer Phone')" />
                                <x-text-input id="customer_phone" name="customer_phone" type="text" class="mt-1 block w-full" value="{{ old('customer_phone') }}" />
                                <x-input-error :messages="$errors->get('customer_phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="sale_date" :value="__('Sale Date')" />
                                <x-text-input id="sale_date" name="sale_date" type="date" class="mt-1 block w-full" value="{{ old('sale_date', now()->toDateString()) }}" required />
                                <x-input-error :messages="$errors->get('sale_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Sale Products') }}</h3>

                            <div id="sale-items" class="space-y-4">
                                @for($i = 0; $i < 2; $i++)
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end border border-gray-200 rounded-lg p-4">
                                        <div>
                                            <x-input-label :for="'products['.$i.'][product_id]'" :value="__('Product')" />
                                            <select id="products[{{ $i }}][product_id]" name="products[{{ $i }}][product_id]" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="" selected>Choose product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->stock_quantity }} available)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label :for="'products['.$i.'][quantity]'" :value="__('Quantity')" />
                                            <x-text-input id="products[{{ $i }}][quantity]" name="products[{{ $i }}][quantity]" type="number" min="1" class="mt-1 block w-full" />
                                        </div>
                                        <div>
                                            <x-input-label :for="'products['.$i.'][unit_price]'" :value="__('Unit Price')" />
                                            <x-text-input id="products[{{ $i }}][unit_price]" name="products[{{ $i }}][unit_price]" type="number" step="0.01" min="0" class="mt-1 block w-full" />
                                        </div>
                                        <button type="button" onclick="removeSaleRow(this)" class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
                                    </div>
                                @endfor
                            </div>

                            <button type="button" onclick="addSaleRow()" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Add another product</button>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('sales.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button>{{ __('Save Sale') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addSaleRow() {
            const container = document.getElementById('sale-items');
            const index = container.children.length;
            const row = document.createElement('div');
            row.className = 'grid grid-cols-1 md:grid-cols-4 gap-4 items-end border border-gray-200 rounded-lg p-4';
            const productOptions = Array.from(document.querySelectorAll('#sale-items select[id^="products"] option')).map(option => option.outerHTML).join('');
            row.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="products[${index}][product_id]">Product</label>
                    <select id="products[${index}][product_id]" name="products[${index}][product_id]" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        ${productOptions}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="products[${index}][quantity]">Quantity</label>
                    <input id="products[${index}][quantity]" name="products[${index}][quantity]" type="number" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="products[${index}][unit_price]">Unit Price</label>
                    <input id="products[${index}][unit_price]" name="products[${index}][unit_price]" type="number" step="0.01" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <button type="button" onclick="removeSaleRow(this)" class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
            `;
            container.appendChild(row);
        }

        function removeSaleRow(button) {
            const row = button.closest('div.grid');
            if (row && document.querySelectorAll('#sale-items > div').length > 1) {
                row.remove();
            }
        }
    </script>
</x-admin-layout>
