<template>
  <AdminLayout header="Admin Dashboard">
    <div class="px-6 py-8 max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-shield text-2xl text-blue-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome to the Admin Dashboard</h2>
            <p class="text-gray-500">This is a dedicated workspace for administrators. You can manage users, view system-wide reports, and oversee all operations here.</p>
        </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
