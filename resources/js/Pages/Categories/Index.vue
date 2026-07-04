<template>
  <AdminLayout header="Categories">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex justify-end">
                        <Link href="/categories/create" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-bold">
                            Add Category
                        </Link>
                    </div>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="p-4 font-semibold text-gray-600">ID</th>
                                <th class="p-4 font-semibold text-gray-600">Name</th>
                                <th class="p-4 font-semibold text-gray-600">Description</th>
                                <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in categories" :key="category.id" class="border-b hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-700">{{ category.id }}</td>
                                <td class="p-4 font-medium text-gray-900">{{ category.name }}</td>
                                <td class="p-4 text-gray-600">{{ category.description || 'N/A' }}</td>
                                <td class="p-4 text-right space-x-2 flex justify-end">
                                    <Link :href="`/categories/${category.id}/edit`" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1.5 text-sm  text-white hover:bg-blue-700 transition font-bold">Edit</Link>
                                    <button @click="deleteCategory(category.id)" class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-bold text-white hover:bg-red-700 transition">Delete</button>
                                </td>
                            </tr>
                            <tr v-if="categories.length === 0">
                                <td colspan="4" class="p-6 text-center text-gray-500 italic">No categories found. Click "Add Category" to create one!</td>
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
import { Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    categories: Array
});

const deleteCategory = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this category?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/categories/${id}`, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Category deleted successfully.',
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
