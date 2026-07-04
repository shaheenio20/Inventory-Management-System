<template>
  <AdminLayout header="Purchase Order">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mb-4 flex justify-end">
                    <Link href="/purchases" class="m-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-bold">
                        Back to Purchase
                    </Link>
                </div>
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Supplier</h3>
                            <p class="text-gray-700">{{ purchase.supplier?.name || 'N/A' }}</p>
                            <p class="text-gray-500 text-sm">{{ purchase.supplier?.email || 'No email provided' }}</p>
                            <p class="text-gray-500 text-sm">{{ purchase.supplier?.phone || 'No phone number' }}</p>
                            <p class="text-gray-500 text-sm">{{ purchase.supplier?.address || 'No address available' }}</p>
                        </div>
                        <div>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">Reference</span>
                                    <p class="font-medium text-gray-900">{{ purchase.reference_no }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Purchase Date</span>
                                    <p class="font-medium text-gray-900">{{ new Date(purchase.purchase_date).toLocaleDateString() }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Total Amount</span>
                                    <p class="font-medium text-gray-900">${{ parseFloat(purchase.total_amount).toFixed(2) }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Status</span>
                                    <p class="font-medium text-gray-900 capitalize">{{ purchase.status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Purchase Items</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="p-4 font-semibold text-gray-600">Product</th>
                                        <th class="p-4 font-semibold text-gray-600">Quantity</th>
                                        <th class="p-4 font-semibold text-gray-600">Unit Cost</th>
                                        <th class="p-4 font-semibold text-gray-600">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in purchase.items" :key="item.id" class="border-b hover:bg-gray-50 transition">
                                        <td class="p-4 text-gray-900">{{ item.product?.name || 'Unknown product' }}</td>
                                        <td class="p-4 text-gray-700">{{ item.quantity }}</td>
                                        <td class="p-4 text-gray-700">${{ parseFloat(item.unit_cost).toFixed(2) }}</td>
                                        <td class="p-4 text-gray-700">${{ (item.quantity * item.unit_cost).toFixed(2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <form v-if="purchase.status === 'pending'" @submit.prevent="receive" class="mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-medium">Receive Purchase</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    purchase: Object
});

const receive = () => {
    Swal.fire({
        title: 'Receive Purchase?',
        text: "This will add the items to your inventory.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, receive it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(`/purchases/${props.purchase.id}/receive`, {}, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Received!',
                        text: 'Purchase order has been received.',
                        icon: 'success',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
};
</script>
