<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['category', 'instructor'])->latest()->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.courses.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'description' => 'required',
            'status' => 'required|in:draft,published,archived'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('courses', 'public');
            $validated['thumbnail'] = $path;
        }

        $course = Course::create($validated);

        if ($request->has('tags')) {
            $course->tags()->sync($request->tags);
        }

        return redirect()->route('admin.courses.index')
                        ->with('success', 'Course created successfully');
    }

    public function edit(Course $course)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.courses.edit', compact('course', 'categories', 'tags'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'description' => 'required',
            'status' => 'required|in:draft,published,archived'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('courses', 'public');
            $validated['thumbnail'] = $path;
        }

        $course->update($validated);

        if ($request->has('tags')) {
            $course->tags()->sync($request->tags);
        }

        return redirect()->route('admin.courses.index')
                        ->with('success', 'Course updated successfully');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')
                        ->with('success', 'Course deleted successfully');
    }
}