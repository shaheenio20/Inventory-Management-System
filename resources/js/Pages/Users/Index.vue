<template>
  <AdminLayout header="User Management">
    <div class="px-6 py-8 max-w-7xl mx-auto">
        <div v-if="$page.props.flash.success" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ $page.props.flash.success }}</span>
        </div>
        <div v-if="$page.props.flash.error" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ $page.props.flash.error }}</span>
        </div>
        <div v-if="Object.keys($page.props.errors).length > 0" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <ul class="list-disc list-inside text-sm">
                <li v-for="error in $page.props.errors" :key="error">{{ error }}</li>
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-base">Users List</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase font-semibold">Name</th>
                            <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase font-semibold">Email</th>
                            <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase font-semibold">Role</th>
                            <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase font-semibold">Status</th>
                            <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ user.name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ user.email }}</td>
                            <td class="px-6 py-4">
                                <select 
                                    v-model="user.role" 
                                    @change="updateRole(user)"
                                    :disabled="$page.props.auth.user.id === user.id"
                                    class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-1 pl-2 pr-8"
                                >
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                    <option value="staff">Staff</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <span v-if="user.is_active" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                                <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <template v-if="$page.props.auth.user.id !== user.id">
                                    <Link 
                                        :href="`/users/${user.id}/toggle-active`" 
                                        method="patch" 
                                        as="button"
                                        preserve-scroll
                                        class="text-xs font-medium px-3 py-1 rounded transition"
                                        :class="user.is_active ? 'bg-orange-100 text-orange-700 hover:bg-orange-200' : 'bg-green-100 text-green-700 hover:bg-green-200'"
                                    >
                                        {{ user.is_active ? 'Deactivate' : 'Activate' }}
                                    </Link>
                                </template>
                                <span v-else class="text-xs text-gray-400 italic">Current User</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-100 flex gap-1 flex-wrap">
                <template v-for="(link, i) in users.links" :key="i">
                    <Link 
                        v-if="link.url" 
                        :href="link.url"
                        class="px-3 py-1 border rounded text-sm"
                        :class="link.active ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-gray-700 hover:bg-gray-50'"
                        v-html="link.label"
                    />
                    <span 
                        v-else 
                        class="px-3 py-1 border rounded bg-gray-100 text-gray-400 text-sm"
                        v-html="link.label"
                    ></span>
                </template>
            </div>
        </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    users: Object
});

const updateRole = (user) => {
    router.patch(`/users/${user.id}/role`, {
        role: user.role
    }, {
        preserveScroll: true
    });
};
</script>
