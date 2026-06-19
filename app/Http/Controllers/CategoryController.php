<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = \App\Models\Category::when($request->search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);
        
        \App\Models\Category::create($request->all());
        
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(\App\Models\Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);
        
        $category->update($request->all());
        
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(\App\Models\Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }


}
