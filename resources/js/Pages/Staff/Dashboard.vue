<template>
  <AdminLayout header="Staff Dashboard">
    <!-- Hero Section -->
    <div class="bg-gradient-to-l from-slate-900 via-indigo-800 to-cyan-900 px-6 pt-8 pb-32 relative">
        <div class="max-w-7xl mx-auto">
            <p class="text-blue-200 text-sm mb-6">
                <i class="fas fa-home mr-1"></i> / <span class="text-white font-medium ml-1">Dashboard</span>
            </p>

            <!-- Stat Cards Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-4xl">
                <!-- Total Products -->
                <div class="bg-white rounded-xl shadow-lg p-5 transition transform hover:-translate-y-1 hover:shadow-2xl">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Available Products</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ totalProducts }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-indigo-500 rounded-full flex items-center justify-center shadow-md">
                            <i class="fas fa-box text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Sales -->
                <div class="bg-white rounded-xl shadow-lg p-5 transition transform hover:-translate-y-1 hover:shadow-2xl">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Sales</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ totalSales }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-pink-500 rounded-full flex items-center justify-center shadow-md">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Tables Section -->
    <div class="px-6 -mt-20 max-w-7xl mx-auto pb-10 relative z-10">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <!-- Recent Sales Table (2/3 width) -->
            <div class="xl:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 text-base">Recent Sales</h3>
                    <Link href="/sales" class="text-xs text-blue-600 hover:underline font-medium">See All</Link>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase font-semibold">Invoice</th>
                                <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase font-semibold">Customer</th>
                                <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase font-semibold">Amount</th>
                                <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase font-semibold">Date</th>
                                <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="sale in recentSales" :key="sale.id" class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-mono font-semibold text-blue-600 text-xs">#{{ sale.invoice_no }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ sale.customer_name || 'Walk-in' }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800">${{ parseFloat(sale.total_amount).toFixed(2) }}</td>
                                <td class="px-6 py-4 text-gray-500 text-xs">{{ sale.sale_date }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-circle text-green-500 mr-1 text-xs"></i> Completed
                                    </span>
                                </td>
                            </tr>
                            <tr v-if="recentSales.length === 0">
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic text-sm">
                                    <i class="fas fa-receipt text-3xl mb-2 block text-gray-300"></i>
                                    No sales recorded yet.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions Panel (1/3 width) -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6">
                <h3 class="font-bold text-gray-800 text-base mb-5">Quick Actions</h3>
                <div class="space-y-3">
                    <Link href="/sales/create" class="flex items-center space-x-3 p-3 rounded-lg border border-gray-100 hover:bg-pink-50 hover:border-pink-200 transition group">
                        <div class="w-9 h-9 bg-pink-100 rounded-lg flex items-center justify-center group-hover:bg-pink-500 transition">
                            <i class="fas fa-cash-register text-pink-600 text-sm group-hover:text-white"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Process New Sale</span>
                    </Link>
                    <Link href="/products" class="flex items-center space-x-3 p-3 rounded-lg border border-gray-100 hover:bg-indigo-50 hover:border-indigo-200 transition group">
                        <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-500 transition">
                            <i class="fas fa-box text-indigo-600 text-sm group-hover:text-white"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">View Products</span>
                    </Link>
                    <Link href="/suppliers" class="flex items-center space-x-3 p-3 rounded-lg border border-gray-100 hover:bg-orange-50 hover:border-orange-200 transition group">
                        <div class="w-9 h-9 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-500 transition">
                            <i class="fas fa-truck text-orange-600 text-sm group-hover:text-white"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">View Suppliers</span>
                    </Link>
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
    totalProducts: Number,
    totalSales: Number,
    recentSales: Array
});
</script>
