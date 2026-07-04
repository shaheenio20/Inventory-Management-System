<template>
  <AdminLayout header="Sale Details">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mb-4 flex justify-end">
                    <Link href="/sales" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-bold">
                        Back to Sales
                    </Link>
                </div>
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Customer</h3>
                            <p class="text-gray-700">{{ sale.customer_name || 'Walk-in' }}</p>
                            <p class="text-gray-500 text-sm">{{ sale.customer_phone || 'No phone provided' }}</p>
                        </div>
                        <div>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">Invoice</span>
                                    <p class="font-medium text-gray-900">{{ sale.invoice_no }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Sale Date</span>
                                    <p class="font-medium text-gray-900">{{ new Date(sale.sale_date).toLocaleDateString() }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Total Amount</span>
                                    <p class="font-medium text-gray-900">${{ parseFloat(sale.total_amount).toFixed(2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Products Sold</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="p-4 font-semibold text-gray-600">Product</th>
                                        <th class="p-4 font-semibold text-gray-600">Quantity</th>
                                        <th class="p-4 font-semibold text-gray-600">Unit Price</th>
                                        <th class="p-4 font-semibold text-gray-600">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in sale.items" :key="item.id" class="border-b hover:bg-gray-50 transition">
                                        <td class="p-4 text-gray-900">{{ item.product?.name || 'Unknown product' }}</td>
                                        <td class="p-4 text-gray-700">{{ item.quantity }}</td>
                                        <td class="p-4 text-gray-700">${{ parseFloat(item.unit_price).toFixed(2) }}</td>
                                        <td class="p-4 text-gray-700">${{ (item.quantity * item.unit_price).toFixed(2) }}</td>
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
    sale: Object
});
</script>
