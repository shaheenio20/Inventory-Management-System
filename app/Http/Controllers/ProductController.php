<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = \App\Models\Product::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('product_code', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('category', function ($query) use ($search) {
                          $query->where('name', 'like', "%{$search}%");
                      });
            })->get();

        return \Inertia\Inertia::render('Products/Index', ['products' => $products]);
    }
    
    public function create()
    {
        $categories = \App\Models\Category::all();
        return \Inertia\Inertia::render('Products/Create', ['categories' => $categories]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'product_code' => 'required|string|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock_quantity' => 'required|integer',
        ]);
        
        $product = \App\Models\Product::create($request->all());
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $product->image = $imageName;
            $product->save();
        }
        
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }
    
    public function edit(\App\Models\Product $product)
    {
        $categories = \App\Models\Category::all();
        return \Inertia\Inertia::render('Products/Edit', ['product' => $product, 'categories' => $categories]);
    }

    public function show(\App\Models\Product $product)
    {
        $product->load(['category', 'stockTransactions']);
        return \Inertia\Inertia::render('Products/Show', ['product' => $product]);
    }
    
    public function update(Request $request, \App\Models\Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'product_code' => 'required|string|max:255|unique:products,product_code,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock_quantity' => 'required|integer',
        ]);
        
        $product->update($request->all());
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $product->image = $imageName;
            $product->save();
        }
        
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    
    public function destroy(\App\Models\Product $product)
    {
        $product->delete();
        
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}