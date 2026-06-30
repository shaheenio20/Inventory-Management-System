<template>
  <AdminLayout header="New Purchase Order">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="mb-4 flex justify-end">
                        <Link href="/purchases" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-medium">
                            Back to Purchase
                        </Link>
                    </div>
                <div class="p-6 text-gray-900">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="supplier_id" class="block font-medium text-sm text-gray-700">Supplier</label>
                                <select id="supplier_id" v-model="form.supplier_id" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="" disabled>Select a supplier</option>
                                    <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>
                                </select>
                                <div v-if="form.errors.supplier_id" class="text-sm text-red-600 mt-2">{{ form.errors.supplier_id }}</div>
                            </div>

                            <div>
                                <label for="purchase_date" class="block font-medium text-sm text-gray-700">Purchase Date</label>
                                <input id="purchase_date" v-model="form.purchase_date" type="date" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                <div v-if="form.errors.purchase_date" class="text-sm text-red-600 mt-2">{{ form.errors.purchase_date }}</div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Purchase Items</h3>

                            <div class="space-y-4">
                                <div v-for="(item, index) in form.products" :key="index" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end border border-gray-200 rounded-lg p-4">
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700">Product</label>
                                        <select v-model="item.product_id" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="" disabled>Choose product</option>
                                            <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700">Quantity</label>
                                        <input v-model="item.quantity" type="number" min="1" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    </div>
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700">Unit Cost</label>
                                        <input v-model="item.unit_cost" type="number" step="0.01" min="0" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    </div>
                                    <button type="button" @click="removeRow(index)" class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
                                </div>
                            </div>

                            <button type="button" @click="addRow" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-medium">Add another item</button>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <Link href="/purchases" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</Link>
                            <button type="submit" :disabled="form.processing" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition font-medium">
                                Save Purchase Order
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
    suppliers: Array,
    products: Array
});

const form = useForm({
    supplier_id: '',
    purchase_date: new Date().toISOString().split('T')[0],
    products: [
        { product_id: '', quantity: 1, unit_cost: 0 }
    ]
});

const addRow = () => {
    form.products.push({ product_id: '', quantity: 1, unit_cost: 0 });
};

const removeRow = (index) => {
    if (form.products.length > 1) {
        form.products.splice(index, 1);
    }
};

const submit = () => {
    form.post('/purchases');
};
</script>
