<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::with('parent')->withCount('courses')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show form for creating a new category.
     */
    public function create()
    {
        $categories = Category::parents()->orderBy('name')->get();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories',
            'slug' => 'nullable|max:255|unique:categories',
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'integer'
        ]);

        $data = $request->except('image');
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show form for editing category.
     */
    public function edit(Category $category)
    {
        $categories = Category::parents()
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();
        
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id,
            'icon' => 'nullable|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'integer'
        ]);

        $data = $request->except('image');
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('image')) {
            if ($category->image) {
                \Storage::delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        // Check if category has courses
        if ($category->courses()->count() > 0) {
            return back()->with('error', 'Cannot delete category with associated courses.');
        }

        // Check if category has children
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Cannot delete category with sub-categories.');
        }

        if ($category->image) {
            \Storage::delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}