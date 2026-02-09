<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.categories', compact('categories'));
    }

   

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'image' => 'nullable',
        ]);

        $data['slug'] = Str::slug($data['name']);

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category added');
    }

   

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'image' => 'nullable',
        ]);

        if ($category->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated');
    }

    public function destroy( $id)
    {
$category = Category::findOrFail($id);
    $category->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Category deleted successfully'
    ], 200);
    }
}
