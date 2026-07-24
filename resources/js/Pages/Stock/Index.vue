<template>
  <AdminLayout header="Stock Transactions">
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mb-4 mt-4 sm:mt-0 flex justify-end px-4 sm:px-0">
                    <Link href="/stock/create" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-bold">
                        Add Stock Entry
                    </Link>
                </div>
                <div class="p-4 sm:p-6 text-gray-900">
                    <form @submit.prevent="submitFilter" class="mb-6 flex flex-col sm:flex-row gap-4 sm:items-end">
                        <div class="flex-1 sm:max-w-xs w-full">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Type</label>
                            <select v-model="filterType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-bold">
                                <option value="">All Types</option>
                                <option value="in">Stock In</option>
                                <option value="out">Stock Out</option>
                                <option value="adjustment">Adjustment</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="w-full sm:w-auto">
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-bold">Filter</button>
                        </div>
                    </form>

                    <!-- Mobile view (Card layout) -->
                    <div class="block md:hidden space-y-4">
                        <div v-for="transaction in transactions.data" :key="transaction.id" class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-800 shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-bold text-gray-900 dark:text-white text-lg">{{ transaction.product?.name || 'Unknown Product' }}</span>
                                <span class="px-2 py-1 text-xs font-bold rounded-full capitalize" :class="{
                                    'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400': transaction.type === 'in',
                                    'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400': transaction.type === 'out',
                                    'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400': transaction.type === 'adjustment' || transaction.type === 'transfer'
                                }">
                                    {{ transaction.type }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 space-y-1.5 mt-3">
                                <p class="flex justify-between"><strong>Quantity:</strong> <span>{{ transaction.quantity }}</span></p>
                                <p class="flex justify-between"><strong>Reference:</strong> <span>{{ transaction.reference || '—' }}</span></p>
                                <p class="flex justify-between"><strong>Notes:</strong> <span>{{ transaction.notes || '—' }}</span></p>
                                <p class="flex justify-between text-xs text-gray-500 mt-2"><strong>Date:</strong> <span>{{ new Date(transaction.created_at).toLocaleDateString() }}</span></p>
                            </div>
                        </div>
                        <div v-if="transactions.data.length === 0" class="text-center p-6 text-gray-500 italic border rounded-lg bg-gray-50 dark:bg-gray-800/50">
                            No stock transactions have been recorded yet.
                        </div>
                    </div>

                    <!-- Desktop view (Table layout) -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th class="p-4 font-semibold text-gray-600 dark:text-gray-300">Product</th>
                                    <th class="p-4 font-semibold text-gray-600 dark:text-gray-300">Type</th>
                                    <th class="p-4 font-semibold text-gray-600 dark:text-gray-300">Quantity</th>
                                    <th class="p-4 font-semibold text-gray-600 dark:text-gray-300">Reference</th>
                                    <th class="p-4 font-semibold text-gray-600 dark:text-gray-300">Notes</th>
                                    <th class="p-4 font-semibold text-gray-600 dark:text-gray-300">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="transaction in transactions.data" :key="transaction.id" class="border-b hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-800/50 transition">
                                    <td class="p-4 text-gray-900 dark:text-gray-100">{{ transaction.product?.name || 'Unknown Product' }}</td>
                                    <td class="p-4 text-gray-700 dark:text-gray-300 capitalize">
                                        <span class="px-2 py-1 text-xs font-bold rounded-full" :class="{
                                            'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400': transaction.type === 'in',
                                            'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400': transaction.type === 'out',
                                            'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400': transaction.type === 'adjustment' || transaction.type === 'transfer'
                                        }">
                                            {{ transaction.type }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-700 dark:text-gray-300">{{ transaction.quantity }}</td>
                                    <td class="p-4 text-gray-600 dark:text-gray-400">{{ transaction.reference || '—' }}</td>
                                    <td class="p-4 text-gray-600 dark:text-gray-400">{{ transaction.notes || '—' }}</td>
                                    <td class="p-4 text-gray-600 dark:text-gray-400">{{ new Date(transaction.created_at).toLocaleDateString() }}</td>
                                </tr>
                                <tr v-if="transactions.data.length === 0">
                                    <td colspan="6" class="p-6 text-center text-gray-500 italic">No stock transactions have been recorded yet.</td>
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
import { ref } from 'vue';

const props = defineProps({
    transactions: Object,
    filters: Object
});

const filterType = ref(props.filters?.type || '');

const submitFilter = () => {
    router.get('/stock', { type: filterType.value }, { preserveState: true });
};
</script>
