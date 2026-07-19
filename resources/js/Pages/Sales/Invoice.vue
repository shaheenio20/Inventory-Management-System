<template>
  <AdminLayout header="Invoice">
    <div class="py-12 print:py-0 print:bg-white">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 print:px-0 print:max-w-none">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg print:shadow-none print:rounded-none">
                <div class="mb-4 flex justify-end gap-2 print:hidden">
                    <Link href="/pos" class="m-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition font-bold shadow">
                        <i class="fas fa-desktop mr-1"></i> Back to POS
                    </Link>
                    <Link href="/sales" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-bold shadow">
                        <i class="fas fa-list mr-1"></i> Sales List
                    </Link>
                </div>
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">Invoice</h3>
                                <p class="text-sm text-gray-500">Invoice No: {{ sale.invoice_no }}</p>
                                <p class="text-sm text-gray-500">Date: {{ new Date(sale.sale_date).toLocaleDateString() }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Customer</p>
                                <p class="font-medium text-gray-900">{{ sale.customer_name || 'Walk-in' }}</p>
                                <p class="text-gray-500">{{ sale.customer_phone || 'No phone' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mb-6">
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

                    <div class="flex justify-end">
                        <div class="w-full md:w-1/3 bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between text-gray-600 mb-2">
                                <span>Subtotal</span>
                                <span>${{ parseFloat(sale.total_amount).toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-900 font-semibold text-lg">
                                <span>Total</span>
                                <span>${{ parseFloat(sale.total_amount).toFixed(2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 text-right print:hidden">
                        <button @click="printInvoice" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-bold">Print Invoice</button>
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

const printInvoice = () => {
    window.print();
};
</script>
