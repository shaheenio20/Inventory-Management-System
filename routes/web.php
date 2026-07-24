<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        $role = \Illuminate\Support\Facades\Auth::user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'manager') return redirect()->route('manager.dashboard');
        if ($role === 'staff') return redirect()->route('staff.dashboard');
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $totalProducts = \App\Models\Product::count();
    $totalStock    = \App\Models\Product::sum('stock_quantity');
    $totalSales    = \App\Models\Sale::count();
    $lowStockCount = \App\Models\Product::where('stock_quantity', '<=', 5)->count();
    $lowStockProducts = \App\Models\Product::where('stock_quantity', '<=', 5)->latest()->take(5)->get();
    $recentSales   = \App\Models\Sale::latest()->take(5)->get();
    $categories    = \App\Models\Category::withCount('products')->get();

    return \Inertia\Inertia::render('Dashboard', compact(
        'totalProducts', 'totalStock', 'totalSales',
        'lowStockCount', 'lowStockProducts', 'recentSales', 'categories'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Role-specific dashboards
    Route::middleware('role:admin')->get('/admin/dashboard', function () {
        $totalProducts = \App\Models\Product::count();
        $totalStock    = \App\Models\Product::sum('stock_quantity');
        $totalSales    = \App\Models\Sale::count();
        $lowStockCount = \App\Models\Product::where('stock_quantity', '<=', 5)->count();
        $lowStockProducts = \App\Models\Product::where('stock_quantity', '<=', 5)->latest()->take(5)->get();
        $recentSales   = \App\Models\Sale::latest()->take(5)->get();
        $categories    = \App\Models\Category::withCount('products')->get();

        return \Inertia\Inertia::render('Dashboard', compact(
            'totalProducts', 'totalStock', 'totalSales',
            'lowStockCount', 'lowStockProducts', 'recentSales', 'categories'
        ));
    })->name('admin.dashboard');

    Route::middleware('role:manager')->get('/manager/dashboard', function () {
        $totalProducts = \App\Models\Product::count();
        $totalStock    = \App\Models\Product::sum('stock_quantity');
        $totalSales    = \App\Models\Sale::count();
        $lowStockCount = \App\Models\Product::where('stock_quantity', '<=', 5)->count();
        $lowStockProducts = \App\Models\Product::where('stock_quantity', '<=', 5)->latest()->take(5)->get();
        $recentSales   = \App\Models\Sale::latest()->take(5)->get();
        $categories    = \App\Models\Category::withCount('products')->get();

        return \Inertia\Inertia::render('Manager/Dashboard', compact(
            'totalProducts', 'totalStock', 'totalSales',
            'lowStockCount', 'lowStockProducts', 'recentSales', 'categories'
        ));
    })->name('manager.dashboard');

    Route::middleware('role:staff')->get('/staff/dashboard', function () {
        $totalProducts = \App\Models\Product::count();
        $totalSales    = \App\Models\Sale::count();
        $recentSales   = \App\Models\Sale::latest()->take(5)->get();

        return \Inertia\Inertia::render('Staff/Dashboard', compact(
            'totalProducts', 'totalSales', 'recentSales'
        ));
    })->name('staff.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // All Roles (Admin, Manager, Staff)
    // Products (Staff can only view, Admin/Manager can manage)
    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show')->where('product', '[0-9]+');
    
    // Suppliers (Staff can only view, Admin/Manager can manage)
    Route::get('/suppliers', [\App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/{supplier}', [\App\Http\Controllers\SupplierController::class, 'show'])->name('suppliers.show')->where('supplier', '[0-9]+');

    // Sales & POS (All Roles)

    Route::resource('sales', \App\Http\Controllers\SaleController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('/sales/{sale}/invoice', [\App\Http\Controllers\SaleController::class, 'invoice'])->name('sales.invoice');

    // Admin & Manager Only
    Route::middleware('role:admin,manager')->group(function () {
        Route::resource('categories', \App\Http\Controllers\CategoryController::class);
        
        // Products (Create, Store, Edit, Update, Destroy)
        Route::resource('products', \App\Http\Controllers\ProductController::class)->except(['index', 'show']);
        
        // Suppliers (Create, Store, Edit, Update, Destroy)
        Route::resource('suppliers', \App\Http\Controllers\SupplierController::class)->except(['index', 'show']);

        // Stock Management
        Route::get('/stock', [\App\Http\Controllers\StockTransactionController::class, 'index'])->name('stock.index');
        Route::get('/stock/create', [\App\Http\Controllers\StockTransactionController::class, 'create'])->name('stock.create');
        Route::post('/stock', [\App\Http\Controllers\StockTransactionController::class, 'store'])->name('stock.store');

        // Purchase Management
        Route::resource('purchases', \App\Http\Controllers\PurchaseController::class)->only(['index', 'create', 'store', 'show']);
        Route::post('/purchases/{purchase}/receive', [\App\Http\Controllers\PurchaseController::class, 'receive'])->name('purchases.receive');

        // Reports
        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    });

    // Admin Only
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/toggle-active', [\App\Http\Controllers\UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::patch('/users/{user}/role', [\App\Http\Controllers\UserController::class, 'updateRole'])->name('users.update-role');
    });
});

require __DIR__.'/auth.php';
