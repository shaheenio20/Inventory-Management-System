<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Inventory') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar { width: 250px; min-height: 100vh; }
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(255,255,255,0.15); border-radius: 6px; }
        .stat-card { transition: transform 0.2s, box-shadow 0.2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
        .main-content { margin-left: 250px; }
        @media (max-width: 768px) {
            .main-content { margin-left: 0; }
        }
        .sidebar.mobile-open { display: flex; }
        @media (max-width: 768px) {
            .sidebar.mobile-open {
                position: fixed;
                width: 250px;
                height: 100vh;
                left: 0;
                top: 0;
                z-index: 60;
                background: #111827;
            }
        }
    </style>
</head>
<body class="bg-gray-200">

<div class="flex">

    <!-- ===== SIDEBAR ===== -->
    <nav class="sidebar hidden sm:flex bg-gray-900 text-white fixed top-0 left-0 flex flex-col z-50 overflow-y-auto">
        <!-- Logo -->
        <div class="px-6 py-5 border-b border-gray-700 flex items-center justify-between gap-3">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-boxes text-white text-sm"></i>
                </div>
                <span class="text-lg font-bold text-white">Notus IMS</span>
            </a>
            <button id="sidebarClose" class="sm:hidden p-2 rounded-md bg-gray-800 text-white hover:bg-gray-700 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Nav Links -->
        <div class="flex-1 px-4 py-6">
            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-3 px-2">Main</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200">
                        <i class="fas fa-tachometer-alt w-5 text-center text-blue-400"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>

            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mt-6 mb-3 px-2">Inventory</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('categories.index') }}" class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200">
                        <i class="fas fa-tags w-5 text-center text-green-400"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200">
                        <i class="fas fa-box w-5 text-center text-yellow-400"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('stock.index') }}" class="sidebar-link {{ request()->routeIs('stock.*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200">
                        <i class="fas fa-layer-group w-5 text-center text-purple-400"></i>
                        <span>Stock Management</span>
                    </a>
                </li>
            </ul>

            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mt-6 mb-3 px-2">Transactions</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('suppliers.index') }}" class="sidebar-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200">
                        <i class="fas fa-truck w-5 text-center text-orange-400"></i>
                        <span>Suppliers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('purchases.index') }}" class="sidebar-link {{ request()->routeIs('purchases.*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200">
                        <i class="fas fa-shopping-bag w-5 text-center text-pink-400"></i>
                        <span>Purchases</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sales.index') }}" class="sidebar-link {{ request()->routeIs('sales.*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200">
                        <i class="fas fa-cash-register w-5 text-center text-teal-400"></i>
                        <span>Sales</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.index') }}" class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200">
                        <i class="fas fa-chart-line w-5 text-center text-yellow-400"></i>
                        <span>Reports</span>
                    </a>
                </li>
            </ul>

            @if(auth()->user()->role === 'admin')
            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mt-6 mb-3 px-2">Admin</p>
            <ul class="space-y-1">
                <li>
                    <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 text-sm text-gray-200">
                        <i class="fas fa-users w-5 text-center text-red-400"></i>
                        <span>User Management</span>
                    </a>
                </li>
            </ul>
            @endif
        </div>

        <!-- User at bottom -->
        <div class="px-4 py-4 border-t border-gray-700">
            <div class="flex items-center space-x-3 px-3 py-2">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 uppercase">{{ auth()->user()->role ?? 'Staff' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-white transition" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content flex-1 min-h-screen">

        <!-- Top Navbar -->
        <div class="bg-white shadow-sm px-6 py-3 flex items-center justify-between sticky top-0 z-40">
            <div class="flex items-center gap-3">
                <button id="sidebarToggle" class="sm:hidden p-2 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    @isset($header)
                        <h1 class="text-xl font-bold text-gray-800">{{ $header }}</h1>
                    @endisset
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <form method="GET" action="{{ url()->current() }}" class="relative">
                @foreach(request()->except('search') as $key => $value)
                    @if(is_array($value))
                        @foreach($value as $item)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="pl-9 pr-10 py-1.5 bg-gray-100 rounded-full text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400 w-48">
                <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                @if(request('search'))
                    <button type="button" id="searchReset" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                @endif
            </form>
            <button class="relative text-gray-500 hover:text-gray-800">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                </button>
                <a href="{{ route('profile.edit') }}">
                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </a>
            </div>
        </div>

        <!-- Page Slot -->
        <main>
            {{ $slot }}
        </main>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const toggle = document.getElementById('sidebarToggle');
        const close = document.getElementById('sidebarClose');

        const toggleSidebar = () => {
            sidebar?.classList.toggle('mobile-open');
        };

        toggle?.addEventListener('click', toggleSidebar);
        close?.addEventListener('click', toggleSidebar);

        document.addEventListener('click', function (event) {
            if (window.innerWidth <= 768 && sidebar?.classList.contains('mobile-open')) {
                const target = event.target;
                if (target !== sidebar && !sidebar?.contains(target) && target !== toggle && !toggle?.contains(target)) {
                    sidebar.classList.remove('mobile-open');
                }
            }
        });

        const searchReset = document.getElementById('searchReset');
        const searchInput = document.querySelector('input[name="search"]');
        const searchForm = searchInput?.closest('form');

        searchReset?.addEventListener('click', function () {
            if (searchInput) {
                searchInput.value = '';
            }
            searchForm?.submit();
        });
    });
</script>
</body>
</html>
