<template>
  <div class="flex bg-gray-200">
    <!-- ===== SIDEBAR ===== -->
    <nav class="sidebar hidden sm:flex bg-gray-900 text-white fixed top-0 left-0 flex-col z-50" :class="{ 'mobile-open': isMobileSidebarOpen }">
        <!-- Logo -->
        <div class="px-6 py-5 border-b border-gray-700 flex items-center justify-between gap-3 shrink-0">
            <Link href="/dashboard" class="flex items-center space-x-3">
                <div class="w-8 h-8 shrink-0 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-boxes text-white text-sm"></i>
                </div>
                <span class="text-lg font-bold text-white">Notus IMS</span>
            </Link>
            <button @click="isMobileSidebarOpen = false" class="sm:hidden p-2 rounded-md bg-gray-800 text-white hover:bg-gray-700 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Nav Links -->
        <div class="flex-1 px-4 py-6 overflow-y-auto custom-scrollbar">
            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-3 px-2">Main</p>
            <ul class="space-y-1">
                <li>
                    <Link href="/dashboard" :class="['sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200', { 'active': $page.url === '/dashboard' }]">
                        <i class="fas fa-tachometer-alt w-5 text-center text-blue-400"></i>
                        <span>Dashboard</span>
                    </Link>
                </li>
            </ul>

            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mt-6 mb-3 px-2">Inventory</p>
            <ul class="space-y-1">
                <li v-if="['admin', 'manager'].includes($page.props.auth.user.role)">
                    <Link href="/categories" :class="['sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200', { 'active': $page.url.startsWith('/categories') }]">
                        <i class="fas fa-tags w-5 text-center text-green-400"></i>
                        <span>Categories</span>
                    </Link>
                </li>
                <li>
                    <Link href="/products" :class="['sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200', { 'active': $page.url.startsWith('/products') }]">
                        <i class="fas fa-box w-5 text-center text-yellow-400"></i>
                        <span>Products</span>
                    </Link>
                </li>
                <li v-if="['admin', 'manager'].includes($page.props.auth.user.role)">
                    <Link href="/stock" :class="['sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200', { 'active': $page.url.startsWith('/stock') }]">
                        <i class="fas fa-layer-group w-5 text-center text-purple-400"></i>
                        <span>Stock Management</span>
                    </Link>
                </li>
            </ul>

            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mt-6 mb-3 px-2">Transactions</p>
            <ul class="space-y-1">
                <li>
                    <Link href="/suppliers" :class="['sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200', { 'active': $page.url.startsWith('/suppliers') }]">
                        <i class="fas fa-truck w-5 text-center text-orange-400"></i>
                        <span>Suppliers</span>
                    </Link>
                </li>
                <li v-if="['admin', 'manager'].includes($page.props.auth.user.role)">
                    <Link href="/purchases" :class="['sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200', { 'active': $page.url.startsWith('/purchases') }]">
                        <i class="fas fa-shopping-bag w-5 text-center text-pink-400"></i>
                        <span>Purchases</span>
                    </Link>
                </li>
                <li>
                    <Link href="/sales" :class="['sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200', { 'active': $page.url.startsWith('/sales') }]">
                        <i class="fas fa-cash-register w-5 text-center text-teal-400"></i>
                        <span>Sales</span>
                    </Link>
                </li>
                <li v-if="['admin', 'manager'].includes($page.props.auth.user.role)">
                    <Link href="/reports" :class="['sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200', { 'active': $page.url.startsWith('/reports') }]">
                        <i class="fas fa-chart-line w-5 text-center text-yellow-400"></i>
                        <span>Reports</span>
                    </Link>
                </li>
            </ul>

            <template v-if="$page.props.auth.user.role === 'admin'">
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mt-6 mb-3 px-2">Admin</p>
                <ul class="space-y-1">
                    <li>
                        <Link href="/users" :class="['sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200', { 'active': $page.url.startsWith('/users') }]">
                            <i class="fas fa-users w-5 text-center text-red-400"></i>
                            <span>User Management</span>
                        </Link>
                    </li>
                </ul>
            </template>

            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mt-6 mb-3 px-2">Account</p>
            <ul class="space-y-1">
                <li>
                    <Link href="/profile" :class="['sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200', { 'active': $page.url.startsWith('/profile') }]">
                        <i class="fas fa-user-cog w-5 text-center text-blue-400"></i>
                        <span>Profile Settings</span>
                    </Link>
                </li>
                <li>
                    <Link href="/logout" method="post" as="button" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-red-400 hover:text-red-300 w-full text-left">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span>Log Out</span>
                    </Link>
                </li>
            </ul>
        </div>

        <!-- User at bottom -->
        <div class="px-4 py-4 border-t border-gray-700 mt-auto shrink-0">
            <div class="flex items-center space-x-3 px-3 py-2">
                <div class="w-8 h-8 shrink-0 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold">
                    {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ $page.props.auth.user.name }}</p>
                    <p class="text-xs text-gray-400 uppercase">{{ $page.props.auth.user.role || 'Staff' }}</p>
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content flex-1 min-h-screen">
        <!-- Top Navbar -->
        <div class="bg-white shadow-sm px-6 py-3 flex items-center justify-between sticky top-0 z-40">
            <div class="flex items-center gap-3">
                <button @click="isMobileSidebarOpen = true" class="sm:hidden p-2 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 v-if="header" class="text-xl font-bold text-gray-800">{{ header }}</h1>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <form @submit.prevent="submitSearch" class="relative hidden sm:block">
                    <input type="text" v-model="searchQuery" placeholder="Search..." class="pl-9 pr-10 py-1.5 bg-gray-100 rounded-full text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400 w-48">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                    <button v-if="searchQuery" type="button" @click="resetSearch" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </form>
                <button class="relative text-gray-500 hover:text-gray-800">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                </button>
                <Link href="/profile" title="Profile">
                    <div class="w-8 h-8 shrink-0 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold shadow-sm hover:ring-2 hover:ring-blue-300 transition">
                        {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                    </div>
                </Link>
            </div>
        </div>

        <!-- Page Slot -->
        <main>
            <slot></slot>
        </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

defineProps({
    header: String
});

const isMobileSidebarOpen = ref(false);
const page = usePage();

const searchQuery = ref('');

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    searchQuery.value = urlParams.get('search') || '';
});

const submitSearch = () => {
    router.get(window.location.pathname, { search: searchQuery.value }, { preserveState: true, replace: true });
};

const resetSearch = () => {
    searchQuery.value = '';
    submitSearch();
};
</script>

<style>
.sidebar { width: 250px; height: 100vh; }
.sidebar-link { transition: all 0.2s; }
.sidebar-link:hover, .sidebar-link.active { background: rgba(255,255,255,0.15); border-radius: 6px; }
.main-content { margin-left: 250px; }
@media (max-width: 768px) {
    .main-content { margin-left: 0; }
    .sidebar.mobile-open {
        display: flex !important;
        position: fixed;
        width: 250px;
        height: 100vh;
        left: 0;
        top: 0;
        z-index: 60;
        background: #111827;
    }
}
.custom-scrollbar::-webkit-scrollbar { height: 4px; width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }
</style>
