@extends('layouts.admin')

@section('title', 'Edit English Practice Course')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title mb-1">Edit English Practice Course</h1>
        <p class="text-muted mb-0">{{ $course->title }}</p>
    </div>
    <a href="{{ route('admin.english-practice-courses.lessons.create', $course) }}" class="btn btn-success"><i class="fas fa-video"></i> Add Lesson</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

<div class="form-card bg-white mb-4">
    <form action="{{ route('admin.english-practice-courses.update', $course) }}" method="POST" enctype="multipart/form-data">
        @include('admin.english-practice-courses._form')
    </form>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header fw-bold">Add Module / Section</div>
            <div class="card-body">
                <form action="{{ route('admin.english-practice-courses.modules.store', $course) }}" method="POST">
                    @csrf
                    <label class="form-label">Title</label>
                    <input name="title" class="form-control mb-3" required>
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control mb-3" rows="3"></textarea>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control mb-3" value="0" min="0">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select mb-3"><option value="published">Published</option><option value="draft">Draft</option></select>
                    <button class="btn btn-primary w-100">Add Module</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header fw-bold">Modules</div>
            <div class="card-body">
                @forelse($course->modules as $module)
                    <form action="{{ route('admin.english-practice-modules.update', $module) }}" method="POST" class="border rounded p-3 mb-3">
                        @csrf @method('PUT')
                        <input name="title" class="form-control mb-2" value="{{ $module->title }}" required>
                        <textarea name="description" class="form-control mb-2" rows="2">{{ $module->description }}</textarea>
                        <div class="row g-2 mb-2">
                            <div class="col"><input type="number" name="sort_order" class="form-control" value="{{ $module->sort_order }}" min="0"></div>
                            <div class="col"><select name="status" class="form-select"><option value="published" @selected($module->status === 'published')>Published</option><option value="draft" @selected($module->status === 'draft')>Draft</option></select></div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary">Save</button>
                    </form>
                    <form action="{{ route('admin.english-practice-modules.destroy', $module) }}" method="POST" onsubmit="return confirm('Delete this module?')" class="mb-3">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete Module</button>
                    </form>
                @empty
                    <p class="text-muted mb-0">No modules yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header fw-bold">Lessons</div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead><tr><th>Title</th><th>Module</th><th>Video</th><th>Status</th><th>Sort</th><th></th></tr></thead>
                    <tbody>
                        @forelse($course->lessons as $lesson)
                            <tr>
                                <td><strong>{{ $lesson->title }}</strong><br><small class="text-muted">{{ $lesson->slug }}</small></td>
                                <td>{{ $lesson->module?->title ?? 'No module' }}</td>
                                <td>{{ ucfirst($lesson->video_type) }}</td>
                                <td><span class="badge bg-{{ $lesson->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($lesson->status) }}</span></td>
                                <td>{{ $lesson->sort_order }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.english-practice-lessons.edit', $lesson) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('admin.english-practice-lessons.destroy', $lesson) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this lesson?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">No lessons yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
