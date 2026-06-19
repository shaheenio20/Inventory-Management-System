<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $sales = Sale::when($request->search, function ($query, $search) {
                $query->where('invoice_no', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%")
                      ->orWhere('customer_phone', 'like', "%{$search}%");
            })->latest()->paginate(20)->withQueryString();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'          => 'nullable|string|max:255',
            'customer_phone'         => 'nullable|string|max:20',
            'sale_date'              => 'required|date',
            'products'               => 'required|array|min:1',
            'products.*.product_id'  => 'required|exists:products,id',
            'products.*.quantity'    => 'required|integer|min:1',
            'products.*.unit_price'  => 'required|numeric|min:0',
        ]);

        $totalAmount = 0;
        foreach ($request->products as $item) {
            $totalAmount += $item['quantity'] * $item['unit_price'];
        }

        $sale = Sale::create([
            'invoice_no'     => 'INV-' . strtoupper(uniqid()),
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'sale_date'      => $request->sale_date,
            'total_amount'   => $totalAmount,
        ]);

        foreach ($request->products as $item) {
            SaleItem::create([
                'sale_id'    => $sale->id,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);

            // Deduct stock
            $product = Product::find($item['product_id']);
            $product->decrement('stock_quantity', $item['quantity']);

            StockTransaction::create([
                'product_id' => $item['product_id'],
                'type'       => 'out',
                'quantity'   => $item['quantity'],
                'reference'  => $sale->invoice_no,
                'notes'      => 'Sold to ' . ($request->customer_name ?? 'Walk-in'),
            ]);
        }

        return redirect()->route('sales.show', $sale)->with('success', 'Sale recorded successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product');
        return view('sales.show', compact('sale'));
    }

    public function invoice(Sale $sale)
    {
        $sale->load('items.product');
        return view('sales.invoice', compact('sale'));
    }
}
