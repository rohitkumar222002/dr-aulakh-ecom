<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // LIST
    public function index()
    {
        $categories=Category::where('is_active',1)->get();
        $subcategories=Subcategory::where('is_active',1)->get();
        $products = Product::latest()->paginate(20);
        return view('admin.products.index', compact('products', 'categories', 'subcategories'));
    }

    // CREATE FORM
    public function create()
    {
        $categories=Category::where('is_active',1)->get();
        $subcategories=Subcategory::where('is_active',1)->get();
        return view('admin.products.create', compact('categories', 'subcategories'));
    }

    // STORE
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric',
            'mrp' => 'nullable|numeric',
            'discount_price' => 'nullable|numeric',
            'stock_qty' => 'required|integer',
            'badge' => 'nullable|in:NEW,BESTSELLER,PREMIUM,IMMUNITY',
            'primary_image' => 'nullable',
            'images' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product added');
    }

    // EDIT FORM
    public function edit(Product $product)
    {
        $categories=Category::where('is_active',1)->get();
        $subcategories=Subcategory::where('is_active',1)->get();
        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }

    // UPDATE
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric',
            'mrp' => 'nullable|numeric',
            'discount_price' => 'nullable|numeric',
            'stock_qty' => 'required|integer',
            'badge' => 'nullable|in:NEW,BESTSELLER,PREMIUM,IMMUNITY',
            'primary_image' => 'nullable|string',
            'images' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($product->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated');
    }

    // DELETE
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted');
    }
}
