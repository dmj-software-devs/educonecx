<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of tags.
     */
    public function index()
    {
        $tags = Tag::withCount('courses')->latest()->paginate(15);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show form for creating a new tag.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created tag.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:tags',
            'slug' => 'nullable|max:255|unique:tags',
        ]);

        $data = $request->all();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->name);
        }

        Tag::create($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Show form for editing tag.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|max:255|unique:tags,name,' . $tag->id,
            'slug' => 'nullable|max:255|unique:tags,slug,' . $tag->id,
        ]);

        $data = $request->all();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->name);
        }

        $tag->update($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified tag.
     */
    public function destroy(Tag $tag)
    {
        // Detach from all courses
        $tag->courses()->detach();
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully.');
    }
}