<template>
  <AdminLayout header="New Stock Transaction">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mb-4 flex justify-end">
                        <Link href="/stock" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-medium">
                            Back to Stock
                        </Link>
                    </div>
                <div class="p-6 text-gray-900">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="product_id" class="block font-medium text-sm text-gray-700">Product</label>
                                <select id="product_id" v-model="form.product_id" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="" disabled>Select a product</option>
                                    <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }} ({{ product.stock_quantity }} in stock)</option>
                                </select>
                                <div v-if="form.errors.product_id" class="text-sm text-red-600 mt-2">{{ form.errors.product_id }}</div>
                            </div>

                            <div>
                                <label for="type" class="block font-medium text-sm text-gray-700">Transaction Type</label>
                                <select id="type" v-model="form.type" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="in">Stock In</option>
                                    <option value="out">Stock Out</option>
                                    <option value="adjustment">Stock Adjustment</option>
                                    <option value="transfer">Inventory Transfer</option>
                                </select>
                                <div v-if="form.errors.type" class="text-sm text-red-600 mt-2">{{ form.errors.type }}</div>
                            </div>

                            <div>
                                <label for="quantity" class="block font-medium text-sm text-gray-700">Quantity</label>
                                <input id="quantity" v-model="form.quantity" type="number" min="1" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <div v-if="form.errors.quantity" class="text-sm text-red-600 mt-2">{{ form.errors.quantity }}</div>
                            </div>

                            <div>
                                <label for="reference" class="block font-medium text-sm text-gray-700">Reference</label>
                                <input id="reference" v-model="form.reference" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <div v-if="form.errors.reference" class="text-sm text-red-600 mt-2">{{ form.errors.reference }}</div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="notes" class="block font-medium text-sm text-gray-700">Notes</label>
                                <textarea id="notes" v-model="form.notes" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                <div v-if="form.errors.notes" class="text-sm text-red-600 mt-2">{{ form.errors.notes }}</div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 items-stretch justify-end mt-6 sm:flex-row sm:items-center">
                            <Link href="/stock" class="text-gray-600 hover:text-gray-900 sm:mr-4 text-center">Cancel</Link>
                            <button type="submit" :disabled="form.processing" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
                                Save Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
    products: Array
});

const form = useForm({
    product_id: '',
    type: 'in',
    quantity: 1,
    reference: '',
    notes: ''
});

const submit = () => {
    form.post('/stock');
};
</script>
