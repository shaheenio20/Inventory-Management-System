<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use Illuminate\Http\Request;

class StockTransactionController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'nullable|in:in,out,adjustment,transfer',
        ]);

        $transactions = StockTransaction::with('product')
            ->when($request->type, fn ($query, $type) => $query->where('type', $type))
            ->when($request->search, function ($query, $search) {
                $query->whereHas('product', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orWhere('reference', 'like', "%{$search}%")
                ->orWhere('notes', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('stock.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:in,out,adjustment,transfer',
            'quantity'   => 'required|integer|min:1',
            'reference'  => 'nullable|string|max:255',
            'notes'      => 'nullable|string',
        ]);

        StockTransaction::create($request->all());

        // Update product stock
        $product = Product::find($request->product_id);
        if (in_array($request->type, ['in', 'transfer'])) {
            $product->increment('stock_quantity', $request->quantity);
        } elseif ($request->type === 'out') {
            $product->decrement('stock_quantity', $request->quantity);
        } else { // adjustment
            $product->stock_quantity = $request->quantity;
            $product->save();
        }

        return redirect()->route('stock.index')->with('success', 'Stock transaction recorded successfully.');
    }
}
