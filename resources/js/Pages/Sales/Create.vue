<template>
  <AdminLayout header="Create Sale">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mb-4 flex justify-end">
                    <Link href="/sales" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-bold">
                        Back to Sales
                    </Link>
                </div>
                <div class="p-6 text-gray-900">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="customer_name" class="block font-bold text-sm text-gray-700">Customer Name</label>
                                <input id="customer_name" v-model="form.customer_name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <div v-if="form.errors.customer_name" class="text-sm text-red-600 mt-2">{{ form.errors.customer_name }}</div>
                            </div>

                            <div>
                                <label for="customer_phone" class="block font-bold text-sm text-gray-700">Customer Phone</label>
                                <input id="customer_phone" v-model="form.customer_phone" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <div v-if="form.errors.customer_phone" class="text-sm text-red-600 mt-2">{{ form.errors.customer_phone }}</div>
                            </div>

                            <div>
                                <label for="sale_date" class="block font-bold text-sm text-gray-700">Sale Date</label>
                                <input id="sale_date" v-model="form.sale_date" type="date" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <div v-if="form.errors.sale_date" class="text-sm text-red-600 mt-2">{{ form.errors.sale_date }}</div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sale Products</h3>

                            <div class="space-y-4">
                                <div v-for="(item, index) in form.products" :key="index" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end border border-gray-200 rounded-lg p-4">
                                    <div>
                                        <label class="block font-bold text-sm text-gray-700">Product</label>
                                        <select v-model="item.product_id" @change="updateUnitPrice(index)" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="" disabled>Choose product</option>
                                            <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }} ({{ product.stock_quantity }} available)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block font-bold text-sm text-gray-700">Quantity</label>
                                        <input v-model="item.quantity" type="number" min="1" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    </div>
                                    <div>
                                        <label class="block font-bold text-sm text-gray-700">Unit Price</label>
                                        <input v-model="item.unit_price" type="number" step="0.01" min="0" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    </div>
                                    <button type="button" @click="removeRow(index)" class="text-red-600 hover:text-red-800 text-sm font-bold">Remove</button>
                                </div>
                            </div>

                            <button type="button" @click="addRow" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-bold">Add another product</button>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <Link href="/sales" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</Link>
                            <button type="submit" :disabled="form.processing" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition font-bold">
                                Save Sale
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
import Swal from 'sweetalert2';

const props = defineProps({
    products: Array
});

const form = useForm({
    customer_name: '',
    customer_phone: '',
    sale_date: new Date().toISOString().split('T')[0],
    products: [
        { product_id: '', quantity: 1, unit_price: 0 }
    ]
});

const updateUnitPrice = (index) => {
    const productId = form.products[index].product_id;
    const product = props.products.find(p => p.id === productId);
    if (product) {
        form.products[index].unit_price = product.price;
    }
};

const addRow = () => {
    form.products.push({ product_id: '', quantity: 1, unit_price: 0 });
};

const removeRow = (index) => {
    if (form.products.length > 1) {
        form.products.splice(index, 1);
    }
};

const submit = () => {
    form.post('/sales', {
        onSuccess: () => {
            Swal.fire({
                title: 'Success!',
                text: 'Sale created successfully.',
                icon: 'success',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }
    });
};
</script>
