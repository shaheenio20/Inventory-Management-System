<template>
  <AdminLayout header="Sales Records">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="mb-4 flex justify-end">
                        <Link href="/sales/create" class="bg-indigo-600 m-2 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-bold">
                            Add Sale
                        </Link>
                    </div>
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="p-4 font-semibold text-gray-600">Invoice</th>
                                    <th class="p-4 font-semibold text-gray-600">Customer</th>
                                    <th class="p-4 font-semibold text-gray-600">Date</th>
                                    <th class="p-4 font-semibold text-gray-600">Total</th>
                                    <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="sale in sales.data" :key="sale.id" class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-900">{{ sale.invoice_no }}</td>
                                    <td class="p-4 text-gray-600">{{ sale.customer_name || 'Walk-in' }}</td>
                                    <td class="p-4 text-gray-600">{{ new Date(sale.sale_date).toLocaleDateString() }}</td>
                                    <td class="p-4 text-gray-700">${{ parseFloat(sale.total_amount).toFixed(2) }}</td>
                                    <td class="p-4 text-right space-x-2 flex justify-end">
                                        <Link :href="`/sales/${sale.id}`" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-200 transition">View</Link>
                                        <Link :href="`/sales/${sale.id}/invoice`" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700 transition">Invoice</Link>
                                    </td>
                                </tr>
                                <tr v-if="sales.data.length === 0">
                                    <td colspan="5" class="p-6 text-center text-gray-500 italic">No sales have been recorded yet.</td>
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
import { Link } from '@inertiajs/vue3';

defineProps({
    sales: Object
});
</script>
