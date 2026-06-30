<template>
  <AdminLayout header="Reports & Analysis">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <Link href="/reports?period=daily" :class="`px-3 py-2 rounded-md text-sm font-medium ${period === 'daily' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-200'}`">Daily</Link>
                <Link href="/reports?period=monthly" :class="`px-3 py-2 rounded-md text-sm font-medium ${period === 'monthly' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-200'}`">Monthly</Link>
                <Link href="/reports?period=yearly" :class="`px-3 py-2 rounded-md text-sm font-medium ${period === 'yearly' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-200'}`">Yearly</Link>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 uppercase tracking-wider">Total Sales</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-3">${{ parseFloat(totalSalesValue).toFixed(2) }}</h3>
                    <p class="text-sm text-gray-500 mt-2">Orders: {{ totalSalesCount }}</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 uppercase tracking-wider">Total Purchase Cost</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-3">${{ parseFloat(totalPurchaseCost).toFixed(2) }}</h3>
                    <p class="text-sm text-gray-500 mt-2">For {{ period }}</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 uppercase tracking-wider">Gross Profit</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-3">${{ parseFloat(grossProfit).toFixed(2) }}</h3>
                    <p class="text-sm text-gray-500 mt-2">Margin: {{ grossProfitMargin }}%</p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500 uppercase tracking-wider">Current Inventory Value</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-3">${{ parseFloat(stockValue).toFixed(2) }}</h3>
                    <p class="text-sm text-gray-500 mt-2">Updated: {{ latestInventoryUpdate ? new Date(latestInventoryUpdate).toLocaleString() : 'No transactions' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 bg-white rounded-xl shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Stock Report</h3>
                        <span class="text-sm text-gray-500">Sorted by quantity</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="p-4 text-sm font-semibold text-gray-600">Product</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Stock</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Price</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in stockReportProducts" :key="item.id" class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 text-gray-900">{{ item.name }}</td>
                                    <td class="p-4 text-gray-700">{{ item.stock_quantity }}</td>
                                    <td class="p-4 text-gray-700">${{ parseFloat(item.price).toFixed(2) }}</td>
                                    <td class="p-4 text-gray-900 font-semibold">${{ (item.stock_quantity * item.price).toFixed(2) }}</td>
                                </tr>
                                <tr v-if="stockReportProducts.length === 0">
                                    <td colspan="4" class="p-6 text-center text-gray-500 italic">No products available.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Low Stock Products</h3>
                    <div class="space-y-3">
                        <div v-for="product in lowStockProducts" :key="product.id" class="rounded-lg border border-gray-200 p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ product.name }}</p>
                                    <p class="text-sm text-gray-500">{{ product.product_code }}</p>
                                </div>
                                <span class="text-sm font-bold text-red-600">{{ product.stock_quantity }}</span>
                            </div>
                        </div>
                        <p v-if="lowStockProducts.length === 0" class="text-sm text-gray-500 italic">No low stock alerts.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Top Selling Products</h3>
                    <span class="text-sm text-gray-500">By quantity sold</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="p-4 text-sm font-semibold text-gray-600">Product</th>
                                <th class="p-4 text-sm font-semibold text-gray-600">Sold Qty</th>
                                <th class="p-4 text-sm font-semibold text-gray-600">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in topSellingProducts" :key="item.product_id" class="border-b hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-900">{{ item.product?.name || 'Unknown' }}</td>
                                <td class="p-4 text-gray-700">{{ item.sold_quantity }}</td>
                                <td class="p-4 text-gray-900 font-semibold">${{ parseFloat(item.sales_value).toFixed(2) }}</td>
                            </tr>
                            <tr v-if="topSellingProducts.length === 0">
                                <td colspan="3" class="p-6 text-center text-gray-500 italic">No sales data yet.</td>
                            </tr>
                        </tbody>
                    </table>
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
    period: String,
    totalSalesCount: Number,
    totalSalesValue: [Number, String],
    totalPurchaseCost: [Number, String],
    grossProfit: [Number, String],
    grossProfitMargin: [Number, String],
    stockValue: [Number, String],
    lowStockProducts: Array,
    stockReportProducts: Array,
    latestInventoryUpdate: String,
    topSellingProducts: Array
});
</script>
