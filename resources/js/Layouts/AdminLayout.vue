<template>
  <div class="flex bg-gray-200 dark:bg-gray-800 min-h-screen">
    <!-- ===== SIDEBAR ===== -->
    <nav class="sidebar hidden sm:flex bg-gray-900 dark:bg-gray-950 text-white fixed top-0 left-0 flex-col z-50" :class="{ 'mobile-open': isMobileSidebarOpen }">
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
                    <button @click="handleLogout" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-red-400 hover:text-red-300 w-full text-left">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span>Log Out</span>
                    </button>
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
    <div class="main-content flex-1 min-h-screen text-gray-900 dark:text-gray-100">
        <!-- Top Navbar -->
        <div class="bg-white dark:bg-gray-900 shadow-sm dark:shadow-gray-800/50 dark:border-b dark:border-gray-800 px-6 py-3 flex items-center justify-between sticky top-0 z-40">
            <div class="flex items-center gap-3">
                <button @click="isMobileSidebarOpen = true" class="sm:hidden p-2 rounded-md bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 v-if="header" class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ header }}</h1>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <form @submit.prevent="submitSearch" class="relative hidden sm:block">
                    <input type="text" v-model="searchQuery" placeholder="Search..." class="pl-9 pr-10 py-1.5 bg-gray-100 dark:bg-gray-800 dark:text-gray-200 rounded-full text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 w-48 border border-transparent dark:border-gray-700">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 dark:text-gray-500 text-xs"></i>
                    <button v-if="searchQuery" type="button" @click="resetSearch" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </form>
                <!-- Dark Mode Toggle -->
                <button @click="toggleDarkMode" class="text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 focus:outline-none transition-colors">
                    <i class="fas" :class="isDarkMode ? 'fa-sun text-yellow-400' : 'fa-moon'"></i>
                </button>
                <!-- Notifications Dropdown -->
                <div class="relative notification-container">
                    <button @click="isNotificationOpen = !isNotificationOpen" class="relative text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 focus:outline-none transition-colors">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">5</span>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <transition 
                        enter-active-class="transition ease-out duration-200" 
                        enter-from-class="opacity-0 scale-95 translate-y-2" 
                        enter-to-class="opacity-100 scale-100 translate-y-0" 
                        leave-active-class="transition ease-in duration-150" 
                        leave-from-class="opacity-100 scale-100 translate-y-0" 
                        leave-to-class="opacity-0 scale-95 translate-y-2">
                        <div v-show="isNotificationOpen" class="absolute right-0 mt-3 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden z-50">
                            <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Notifications</span>
                                <button class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition">Mark all as read</button>
                            </div>
                            <div class="max-h-80 overflow-y-auto custom-scrollbar">
                                <!-- Out of stock -->
                                <div class="px-4 py-3 border-b border-gray-50 dark:border-gray-700 hover:bg-blue-50/50 dark:hover:bg-gray-700 transition cursor-pointer flex gap-3 items-start">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold truncate">🔴 Product is out of stock</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">Laptop Dell XPS 13</p>
                                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">2 mins ago</p>
                                    </div>
                                </div>
                                <!-- Expires soon -->
                                <div class="px-4 py-3 border-b border-gray-50 dark:border-gray-700 hover:bg-blue-50/50 dark:hover:bg-gray-700 transition cursor-pointer flex gap-3 items-start">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold truncate">🟠 Product expires in 15 days</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">Premium Antivirus License</p>
                                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">1 hour ago</p>
                                    </div>
                                </div>
                                <!-- New supplier -->
                                <div class="px-4 py-3 border-b border-gray-50 dark:border-gray-700 hover:bg-blue-50/50 dark:hover:bg-gray-700 transition cursor-pointer flex gap-3 items-start">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold truncate">🟢 New supplier added</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">TechCorp Industries</p>
                                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">3 hours ago</p>
                                    </div>
                                </div>
                                <!-- Purchase received -->
                                <div class="px-4 py-3 border-b border-gray-50 dark:border-gray-700 hover:bg-blue-50/50 dark:hover:bg-gray-700 transition cursor-pointer flex gap-3 items-start">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold truncate">🔵 Purchase received</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">PO #4021 - 50 Items</p>
                                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">Yesterday</p>
                                    </div>
                                </div>
                                <!-- Invoice paid -->
                                <div class="px-4 py-3 hover:bg-blue-50/50 dark:hover:bg-gray-700 transition cursor-pointer flex gap-3 items-start">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold truncate">🟡 Invoice paid</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">INV-2023-089 completed</p>
                                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">Yesterday</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-2 border-t border-gray-100 dark:border-gray-700 text-center">
                                <Link href="#" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold transition">View all notifications</Link>
                            </div>
                        </div>
                    </transition>
                </div>
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
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

defineProps({
    header: String
});

const isMobileSidebarOpen = ref(false);
const isNotificationOpen = ref(false);
const isDarkMode = ref(false);
const page = usePage();

const searchQuery = ref('');

const closeNotifications = (e) => {
    if (!e.target.closest('.notification-container')) {
        isNotificationOpen.value = false;
    }
};

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    searchQuery.value = urlParams.get('search') || '';
    document.addEventListener('click', closeNotifications);
    
    // Initialize dark mode state
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        isDarkMode.value = true;
    } else {
        isDarkMode.value = false;
    }
});

onUnmounted(() => {
    document.removeEventListener('click', closeNotifications);
});

const submitSearch = () => {
    router.get(window.location.pathname, { search: searchQuery.value }, { preserveState: true, replace: true });
};

const resetSearch = () => {
    searchQuery.value = '';
    submitSearch();
};

const toggleDarkMode = () => {
    if (isDarkMode.value) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('color-theme', 'light');
        isDarkMode.value = false;
    } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('color-theme', 'dark');
        isDarkMode.value = true;
    }
};

const handleLogout = () => {
    Swal.fire({
        title: 'Ready to logout?',
        text: "You are going to logged out!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Logout'
    }).then((result) => {
        if (result.isConfirmed) {
            router.post('/logout');
        }
    });
};
</script>

<style>
.sidebar { width: 250px; height: 100vh; }
.sidebar-link { transition: all 0.2s; }
.sidebar-link span { font-weight: 600; }
.sidebar-link:hover, .sidebar-link.active { background: rgba(255,255,255,0.15); border-radius: 6px; }
.sidebar-link:not(.text-red-400):hover span, .sidebar-link:not(.text-red-400).active span { color: #60a5fa; font-weight: 700; }
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
