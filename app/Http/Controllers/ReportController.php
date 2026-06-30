<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->query('period', 'monthly');
        if (! in_array($period, ['daily', 'monthly', 'yearly'])) {
            $period = 'monthly';
        }

        $salesQuery = Sale::query();
        $purchaseQuery = Purchase::query();

        if ($period === 'daily') {
            $salesQuery->whereDate('sale_date', Carbon::today());
            $purchaseQuery->whereDate('purchase_date', Carbon::today());
        } elseif ($period === 'monthly') {
            $salesQuery->whereMonth('sale_date', Carbon::now()->month)
                ->whereYear('sale_date', Carbon::now()->year);
            $purchaseQuery->whereMonth('purchase_date', Carbon::now()->month)
                ->whereYear('purchase_date', Carbon::now()->year);
        } else {
            $salesQuery->whereYear('sale_date', Carbon::now()->year);
            $purchaseQuery->whereYear('purchase_date', Carbon::now()->year);
        }

        $totalSalesCount = $salesQuery->count();
        $totalSalesValue = $salesQuery->sum('total_amount');
        $totalPurchaseCost = $purchaseQuery->sum('total_amount');
        $grossProfit = $totalSalesValue - $totalPurchaseCost;
        $grossProfitMargin = $totalSalesValue > 0 ? round($grossProfit / $totalSalesValue * 100, 2) : 0;

        $stockValue = Product::get()->sum(fn ($product) => $product->stock_quantity * $product->price);
        $lowStockProducts = Product::where('stock_quantity', '<=', 5)
            ->orderBy('stock_quantity', 'asc')
            ->get();
        $stockReportProducts = Product::orderBy('stock_quantity', 'asc')->get();
        $latestInventoryUpdate = StockTransaction::latest()->value('created_at');

        $topSellingProducts = SaleItem::select('product_id', DB::raw('SUM(quantity) as sold_quantity'), DB::raw('SUM(quantity * unit_price) as sales_value'))
            ->groupBy('product_id')
            ->orderByDesc('sold_quantity')
            ->take(8)
            ->with('product')
            ->get();

        return \Inertia\Inertia::render('Reports/Index', [
            'period' => $period,
            'totalSalesCount' => $totalSalesCount,
            'totalSalesValue' => $totalSalesValue,
            'totalPurchaseCost' => $totalPurchaseCost,
            'grossProfit' => $grossProfit,
            'grossProfitMargin' => $grossProfitMargin,
            'stockValue' => $stockValue,
            'lowStockProducts' => $lowStockProducts,
            'stockReportProducts' => $stockReportProducts,
            'latestInventoryUpdate' => $latestInventoryUpdate,
            'topSellingProducts' => $topSellingProducts
        ]);
    }
}
