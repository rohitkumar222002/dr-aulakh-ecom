<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index()
    {
        
        $categories = Category::where('is_active', 1)->get();
        $subcategories = Subcategory::with('category')->latest()->get();
        return view('admin.subcategories.subcategories', compact('subcategories','categories'));
    }

   
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'image' => 'nullable',
        ]);

        $data['slug'] = Str::slug($data['name']);

        Subcategory::create($data);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory added');
    }

    

    public function update(Request $request, Subcategory $subcategory)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'image' => 'nullable',
        ]);

        if ($subcategory->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']);
        }

        $subcategory->update($data);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory updated');
    }

    public function destroy($id)
    {

        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Subcategory deleted successfully'
        ], 200);
    }
}
