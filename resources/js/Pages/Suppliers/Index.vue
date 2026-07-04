<template>
  <AdminLayout header="Suppliers">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="mb-4 flex justify-end">
                        <Link v-if="['admin', 'manager'].includes($page.props.auth.user.role)" href="/suppliers/create" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition m-2 font-bold">
                            Add Supplier
                        </Link>
                    </div>
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="p-4 font-semibold text-gray-600">Name</th>
                                    <th class="p-4 font-semibold text-gray-600">Email</th>
                                    <th class="p-4 font-semibold text-gray-600">Phone</th>
                                    <th class="p-4 font-semibold text-gray-600">Purchases</th>
                                    <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="supplier in suppliers" :key="supplier.id" class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 font-bold text-gray-900">{{ supplier.name }}</td>
                                    <td class="p-4 text-gray-600">{{ supplier.email || '—' }}</td>
                                    <td class="p-4 text-gray-600">{{ supplier.phone || '—' }}</td>
                                    <td class="p-4 text-gray-700">{{ supplier.purchases_count }}</td>
                                    <td class="p-4 text-right space-x-2 flex justify-end">
                                        <Link :href="`/suppliers/${supplier.id}`" class="inline-flex items-center rounded-md bg-slate-100 px-3 py-1.5 text-sm font-bold text-slate-700 hover:bg-slate-200 transition">View</Link>
                                        <template v-if="['admin', 'manager'].includes($page.props.auth.user.role)">
                                            <Link :href="`/suppliers/${supplier.id}/edit`" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-bold text-white hover:bg-indigo-700 transition">Edit</Link>
                                            <button @click="deleteSupplier(supplier.id)" class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-bold text-white hover:bg-red-700 transition">Delete</button>
                                        </template>
                                    </td>
                                </tr>
                                <tr v-if="suppliers.length === 0">
                                    <td colspan="5" class="p-6 text-center text-gray-500 italic">No suppliers found. Click "Add Supplier" to create one.</td>
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
import Swal from 'sweetalert2';

defineProps({
    suppliers: Array
});

const deleteSupplier = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this supplier?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/suppliers/${id}`, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Supplier deleted successfully.',
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
