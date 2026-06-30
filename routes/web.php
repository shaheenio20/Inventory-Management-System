<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);

    // Stock Management
    Route::get('/stock', [\App\Http\Controllers\StockTransactionController::class, 'index'])->name('stock.index');
    Route::get('/stock/create', [\App\Http\Controllers\StockTransactionController::class, 'create'])->name('stock.create');
    Route::post('/stock', [\App\Http\Controllers\StockTransactionController::class, 'store'])->name('stock.store');

    // Purchase Management
    Route::resource('purchases', \App\Http\Controllers\PurchaseController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('/purchases/{purchase}/receive', [\App\Http\Controllers\PurchaseController::class, 'receive'])->name('purchases.receive');

    // Sales Management
    Route::resource('sales', \App\Http\Controllers\SaleController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('/sales/{sale}/invoice', [\App\Http\Controllers\SaleController::class, 'invoice'])->name('sales.invoice');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // User Management (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/toggle-active', [\App\Http\Controllers\UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::patch('/users/{user}/role', [\App\Http\Controllers\UserController::class, 'updateRole'])->name('users.update-role');
    });
});

require __DIR__.'/auth.php';
