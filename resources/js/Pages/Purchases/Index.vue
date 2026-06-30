<template>
  <AdminLayout header="Purchase Orders">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="mb-4 flex justify-end">
                        <Link href="/purchases/create" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition m-2 font-medium">
                            Add Purchase Order
                        </Link>
                    </div>
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="p-4 font-semibold text-gray-600">Reference</th>
                                    <th class="p-4 font-semibold text-gray-600">Supplier</th>
                                    <th class="p-4 font-semibold text-gray-600">Date</th>
                                    <th class="p-4 font-semibold text-gray-600">Total</th>
                                    <th class="p-4 font-semibold text-gray-600">Status</th>
                                    <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="purchase in purchases.data" :key="purchase.id" class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-900">{{ purchase.reference_no }}</td>
                                    <td class="p-4 text-gray-600">{{ purchase.supplier?.name || 'N/A' }}</td>
                                    <td class="p-4 text-gray-600">{{ new Date(purchase.purchase_date).toLocaleDateString() }}</td>
                                    <td class="p-4 text-gray-700">${{ parseFloat(purchase.total_amount).toFixed(2) }}</td>
                                    <td class="p-4 text-gray-600 capitalize">{{ purchase.status }}</td>
                                    <td class="p-4 text-right">
                                        <Link :href="`/purchases/${purchase.id}`" class="text-blue-600 hover:underline">View</Link>
                                    </td>
                                </tr>
                                <tr v-if="purchases.data.length === 0">
                                    <td colspan="6" class="p-6 text-center text-gray-500 italic">No purchase orders found yet.</td>
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
    purchases: Object
});
</script>
