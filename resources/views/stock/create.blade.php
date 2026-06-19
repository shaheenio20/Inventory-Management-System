<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('New Stock Transaction') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mb-4 flex justify-end">
                        <a href="{{ route('stock.index') }}" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                            Back to Stock
                        </a>
                    </div>
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('stock.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <x-input-label for="product_id" :value="__('Product')" />
                                <select id="product_id" name="product_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="" disabled selected>Select a product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->stock_quantity }} in stock)</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="type" :value="__('Transaction Type')" />
                                <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Stock In</option>
                                    <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Stock Out</option>
                                    <option value="adjustment" {{ old('type') == 'adjustment' ? 'selected' : '' }}>Stock Adjustment</option>
                                    <option value="transfer" {{ old('type') == 'transfer' ? 'selected' : '' }}>Inventory Transfer</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" name="quantity" type="number" min="1" class="mt-1 block w-full" value="{{ old('quantity') }}" required />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="reference" :value="__('Reference')" />
                                <x-text-input id="reference" name="reference" type="text" class="mt-1 block w-full" value="{{ old('reference') }}" />
                                <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="notes" :value="__('Notes')" />
                                <textarea id="notes" name="notes" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 items-stretch justify-end mt-6 sm:flex-row sm:items-center">
                            <a href="{{ route('stock.index') }}" class="text-gray-600 hover:text-gray-900 sm:mr-4 text-center">Cancel</a>
                            <x-primary-button class="w-full sm:w-auto">{{ __('Save Transaction') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
