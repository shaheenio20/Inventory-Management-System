<template>
  <AdminLayout header="Add Supplier">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mb-4 flex justify-end">
                    <Link href="/suppliers" class="mt-2 mr-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                        Back to Suppliers
                    </Link>
                </div>
                <div class="p-6 text-gray-900">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Supplier Name</label>
                                <input id="name" v-model="form.name" type="text" required autofocus class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                <div v-if="form.errors.name" class="text-sm text-red-600 mt-2">{{ form.errors.name }}</div>
                            </div>

                            <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">Email Address</label>
                                <input id="email" v-model="form.email" type="email" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                <div v-if="form.errors.email" class="text-sm text-red-600 mt-2">{{ form.errors.email }}</div>
                            </div>

                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">Phone Number</label>
                                <input id="phone" v-model="form.phone" type="text" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                <div v-if="form.errors.phone" class="text-sm text-red-600 mt-2">{{ form.errors.phone }}</div>
                            </div>

                            <div>
                                <label for="address" class="block font-medium text-sm text-gray-700">Address</label>
                                <textarea id="address" v-model="form.address" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                <div v-if="form.errors.address" class="text-sm text-red-600 mt-2">{{ form.errors.address }}</div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <Link href="/suppliers" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</Link>
                            <button type="submit" :disabled="form.processing" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Save Supplier
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

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: ''
});

const submit = () => {
    form.post('/suppliers');
};
</script>
