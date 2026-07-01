<template>
  <AdminLayout header="Products">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex justify-end">
                        <Link v-if="['admin', 'manager'].includes($page.props.auth.user.role)" href="/products/create" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-medium">
                            Add Product
                        </Link>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="p-4 font-semibold text-gray-600">Code</th>
                                    <th class="p-4 font-semibold text-gray-600">Name</th>
                                    <th class="p-4 font-semibold text-gray-600">Category</th>
                                    <th class="p-4 font-semibold text-gray-600">Stock</th>
                                    <th class="p-4 font-semibold text-gray-600">Price</th>
                                    <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products" :key="product.id" class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-700 font-mono">{{ product.product_code }}</td>
                                    <td class="p-4 font-medium text-gray-900">{{ product.name }}</td>
                                    <td class="p-4 text-gray-600">{{ product.category?.name || 'N/A' }}</td>
                                    <td class="p-4 text-gray-900 font-semibold">{{ product.stock_quantity }}</td>
                                    <td class="p-4 text-green-600 font-semibold">${{ parseFloat(product.price).toFixed(2) }}</td>
                                    <td class="p-4 text-right space-x-2 flex justify-end">
                                        <Link :href="`/products/${product.id}`" class="inline-flex items-center rounded-md bg-slate-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-slate-700 transition">View</Link>
                                        <template v-if="['admin', 'manager'].includes($page.props.auth.user.role)">
                                            <Link :href="`/products/${product.id}/edit`" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-blue-700 transition">Edit</Link>
                                            <button @click="deleteProduct(product.id)" class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-700 transition">Delete</button>
                                        </template>
                                    </td>
                                </tr>
                                <tr v-if="products.length === 0">
                                    <td colspan="6" class="p-6 text-center text-gray-500 italic">No products found. Click "Add Product" to create one!</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    products: Array
});

const deleteProduct = (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(`/products/${id}`);
    }
};
</script>
