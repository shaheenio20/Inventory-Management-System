<template>
  <AdminLayout header="Add New Product">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form @submit.prevent="submit" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block font-bold text-sm text-gray-700">Product Name</label>
                                <input id="name" v-model="form.name" type="text" required autofocus class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                <div v-if="form.errors.name" class="text-sm text-red-600 mt-2">{{ form.errors.name }}</div>
                            </div>

                            <!-- Product Code -->
                            <div>
                                <label for="product_code" class="block font-bold text-sm text-gray-700">Product Code</label>
                                <input id="product_code" v-model="form.product_code" type="text" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                <div v-if="form.errors.product_code" class="text-sm text-red-600 mt-2">{{ form.errors.product_code }}</div>
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block font-bold text-sm text-gray-700">Category</label>
                                <select id="category_id" v-model="form.category_id" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="" disabled>Select a category</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                </select>
                                <div v-if="form.errors.category_id" class="text-sm text-red-600 mt-2">{{ form.errors.category_id }}</div>
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block font-bold text-sm text-gray-700">Price ($)</label>
                                <input id="price" v-model="form.price" type="number" step="0.01" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                <div v-if="form.errors.price" class="text-sm text-red-600 mt-2">{{ form.errors.price }}</div>
                            </div>

                            <!-- Stock Quantity -->
                            <div>
                                <label for="stock_quantity" class="block font-bold text-sm text-gray-700">Initial Stock Quantity</label>
                                <input id="stock_quantity" v-model="form.stock_quantity" type="number" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                <div v-if="form.errors.stock_quantity" class="text-sm text-red-600 mt-2">{{ form.errors.stock_quantity }}</div>
                            </div>

                            <!-- Image -->
                            <div>
                                <label for="image" class="block font-bold text-sm text-gray-700">Product Image</label>
                                <input id="image" type="file" @input="form.image = $event.target.files[0]" accept="image/*" class="block mt-1 w-full border-gray-300" />
                                <div v-if="form.errors.image" class="text-sm text-red-600 mt-2">{{ form.errors.image }}</div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <label for="description" class="block font-bold text-sm text-gray-700">Description</label>
                            <textarea id="description" v-model="form.description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                            <div v-if="form.errors.description" class="text-sm text-red-600 mt-2">{{ form.errors.description }}</div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-4">
                            <Link href="/products" class="text-gray-600 hover:text-gray-900">Cancel</Link>
                            <button type="submit" :disabled="form.processing" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Save Product
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

defineProps({
    categories: Array
});

const form = useForm({
    name: '',
    product_code: '',
    category_id: '',
    price: '',
    stock_quantity: 0,
    image: null,
    description: ''
});

const submit = () => {
    form.post('/products', {
        onSuccess: () => {
            Swal.fire({
                title: 'Success!',
                text: 'Product created successfully.',
                icon: 'success',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }
    });
};
</script>
