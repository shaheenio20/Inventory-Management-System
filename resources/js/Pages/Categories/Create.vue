<template>
  <AdminLayout header="Add New Category">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label for="name" class="block font-bold text-sm text-gray-700">Category Name</label>
                            <input id="name" type="text" v-model="form.name" required autofocus class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                            <div v-if="form.errors.name" class="text-sm text-red-600 mt-2">{{ form.errors.name }}</div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block font-bold text-sm text-gray-700">Description (Optional)</label>
                            <textarea id="description" v-model="form.description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                            <div v-if="form.errors.description" class="text-sm text-red-600 mt-2">{{ form.errors.description }}</div>
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-4">
                            <Link href="/categories" class="text-gray-600 hover:text-gray-900">Cancel</Link>
                            <button type="submit" :disabled="form.processing" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Save Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const form = useForm({
    name: '',
    description: ''
});

const submit = () => {
    form.post('/categories', {
        onSuccess: () => {
            Swal.fire({
                title: 'Success!',
                text: 'Category created successfully.',
                icon: 'success',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }
    });
};
</script>
