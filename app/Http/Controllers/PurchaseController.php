<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $purchases = Purchase::with('supplier')
            ->when($request->search, function ($query, $search) {
                $query->where('reference_no', 'like', "%{$search}%")
                      ->orWhereHas('supplier', function ($query) use ($search) {
                          $query->where('name', 'like', "%{$search}%");
                      });
            })->latest()->paginate(20)->withQueryString();

        return \Inertia\Inertia::render('Purchases/Index', ['purchases' => $purchases]);
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products  = Product::all();
        return \Inertia\Inertia::render('Purchases/Create', ['suppliers' => $suppliers, 'products' => $products]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'          => 'required|exists:suppliers,id',
            'purchase_date'        => 'required|date',
            'products'             => 'required|array|min:1',
            'products.*.product_id'=> 'required|exists:products,id',
            'products.*.quantity'  => 'required|integer|min:1',
            'products.*.unit_cost' => 'required|numeric|min:0',
        ]);

        $totalAmount = 0;
        foreach ($request->products as $item) {
            $totalAmount += $item['quantity'] * $item['unit_cost'];
        }

        $purchase = Purchase::create([
            'supplier_id'   => $request->supplier_id,
            'reference_no'  => 'PO-' . strtoupper(uniqid()),
            'purchase_date' => $request->purchase_date,
            'total_amount'  => $totalAmount,
            'status'        => 'pending',
        ]);

        foreach ($request->products as $item) {
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id'  => $item['product_id'],
                'quantity'    => $item['quantity'],
                'unit_cost'   => $item['unit_cost'],
            ]);
        }

        return redirect()->route('purchases.index')->with('success', 'Purchase order created successfully.');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product']);
        return \Inertia\Inertia::render('Purchases/Show', ['purchase' => $purchase]);
    }

    public function receive(Purchase $purchase)
    {
        if ($purchase->status === 'received') {
            return redirect()->route('purchases.show', $purchase)->with('error', 'Already received.');
        }

        foreach ($purchase->items as $item) {
            $item->product->increment('stock_quantity', $item->quantity);

            StockTransaction::create([
                'product_id' => $item->product_id,
                'type'       => 'in',
                'quantity'   => $item->quantity,
                'reference'  => $purchase->reference_no,
                'notes'      => 'Purchase received from ' . $purchase->supplier->name,
            ]);
        }

        $purchase->update(['status' => 'received']);

        return redirect()->route('purchases.show', $purchase)->with('success', 'Purchase items received and stock updated.');
    }
}
