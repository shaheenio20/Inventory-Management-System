<template>
  <AdminLayout header="Product Details">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3 space-y-2">
                <div class="mb-1 flex justify-end">
                    <Link href="/products" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-medium">
                        Back to Products
                    </Link>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="font-semibold text-gray-900 text-lg mb-3">Overview</h3>
                        <p class="text-gray-700 mb-3"><strong>Product Code:</strong> {{ product.product_code }}</p>
                        <p class="text-gray-700 mb-3"><strong>Category:</strong> {{ product.category?.name || 'N/A' }}</p>
                        <p class="text-gray-700 mb-3"><strong>Price:</strong> ${{ parseFloat(product.price).toFixed(2) }}</p>
                        <p class="text-gray-700 mb-3"><strong>Current Stock:</strong> {{ product.stock_quantity }}</p>
                        <p class="text-gray-700 mb-3"><strong>Inventory Value:</strong> ${{ (product.stock_quantity * product.price).toFixed(2) }}</p>
                    </div>

                    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
                        <h3 class="font-semibold text-gray-900 text-lg mb-4">Movement History</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="p-4 text-sm font-semibold text-gray-600">Date</th>
                                        <th class="p-4 text-sm font-semibold text-gray-600">Type</th>
                                        <th class="p-4 text-sm font-semibold text-gray-600">Qty</th>
                                        <th class="p-4 text-sm font-semibold text-gray-600">Reference</th>
                                        <th class="p-4 text-sm font-semibold text-gray-600">Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="transaction in product.stock_transactions" :key="transaction.id" class="border-b hover:bg-gray-50 transition">
                                        <td class="p-4 text-gray-700">{{ new Date(transaction.created_at).toLocaleString() }}</td>
                                        <td class="p-4 text-gray-700 capitalize">{{ transaction.type }}</td>
                                        <td class="p-4 text-gray-700">{{ transaction.quantity }}</td>
                                        <td class="p-4 text-gray-600">{{ transaction.reference || '—' }}</td>
                                        <td class="p-4 text-gray-600">{{ transaction.notes || '—' }}</td>
                                    </tr>
                                    <tr v-if="!product.stock_transactions || product.stock_transactions.length === 0">
                                        <td colspan="5" class="p-6 text-center text-gray-500 italic">No stock movement recorded for this product yet.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    product: Object
});
</script>
