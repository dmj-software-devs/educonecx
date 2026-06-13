@extends('layouts.admin')

@section('title', 'Edit English Practice Course')

@push('styles')
<style>
    .admin-page-header {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    .admin-page-actions { display: flex; flex-wrap: wrap; gap: .5rem; justify-content: flex-end; }
    .section-card { border: 0; box-shadow: 0 8px 24px rgba(15, 23, 42, .07); }
    .section-card .card-header { background: #fff; border-bottom: 1px solid #e5e7eb; padding: 1rem 1.25rem; }
    .section-title { margin: 0; font-weight: 800; color: #1f2937; }
    .section-subtitle { margin: .25rem 0 0; color: #6b7280; font-size: .9rem; }
    .module-card { border: 1px solid #e5e7eb; border-radius: 1rem; overflow: hidden; }
    .module-summary { background: #f8fafc; padding: 1rem; }
    .module-edit { padding: 1rem; border-top: 1px solid #e5e7eb; }
    .lesson-title-cell { min-width: 220px; }
    .lesson-actions { white-space: nowrap; }
    @media (max-width: 767.98px) {
        .admin-page-header { flex-direction: column; }
        .admin-page-actions { justify-content: flex-start; width: 100%; }
    }
</style>
@endpush

@section('content')
<div class="admin-page-header">
    <div>
        <h1 class="page-title mb-1">Edit English Practice Course</h1>
        <p class="text-muted mb-0">{{ $course->title }} · Manage course details, modules, and video lessons.</p>
    </div>
    <div class="admin-page-actions">
        @if(Route::has('practice-room.courses.show'))
            <a href="{{ route('practice-room.courses.show', $course) }}" target="_blank" class="btn btn-outline-info">
                <i class="fas fa-external-link-alt"></i> View Course on Site
            </a>
        @endif
        <a href="{{ route('admin.english-practice-courses.lessons.create', $course) }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Add Lesson
        </a>
        <a href="{{ route('admin.english-practice-courses.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Courses
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<section class="card section-card mb-4">
    <div class="card-header">
        <h2 class="h5 section-title"><i class="fas fa-info-circle text-primary"></i> Course Information</h2>
        <p class="section-subtitle">This information appears on the Practice Room course card.</p>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.english-practice-courses.update', $course) }}" method="POST" enctype="multipart/form-data">
            @include('admin.english-practice-courses._form')
        </form>
    </div>
</section>

<section class="card section-card mb-4">
    <div class="card-header">
        <h2 class="h5 section-title"><i class="fas fa-layer-group text-primary"></i> Modules / Sections</h2>
        <p class="section-subtitle">Group lessons into simple sections for learners.</p>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-primary h-100">
                    <div class="card-header bg-primary text-white fw-bold">Add New Module</div>
                    <div class="card-body">
                        <form action="{{ route('admin.english-practice-courses.modules.store', $course) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Title</label>
                                <input name="title" class="form-control" placeholder="Example: Pronunciation Basics" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Optional short module summary"></textarea>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-semibold">Sort</label>
                                    <input type="number" name="sort_order" class="form-control" value="0" min="0">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select name="status" class="form-select"><option value="published">Published</option><option value="draft">Draft</option></select>
                                </div>
                            </div>
                            <button class="btn btn-primary w-100"><i class="fas fa-plus"></i> Add Module</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="d-flex flex-column gap-3">
                    @forelse($course->modules as $module)
                        <article class="module-card">
                            <div class="module-summary">
                                <div class="d-flex flex-wrap justify-content-between gap-2 align-items-start">
                                    <div>
                                        <h3 class="h6 mb-1">{{ $module->title }}</h3>
                                        <p class="text-muted mb-2">{{ $module->description ?: 'No description added.' }}</p>
                                        <span class="badge bg-{{ $module->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($module->status) }}</span>
                                        <span class="badge bg-light text-dark">Sort {{ $module->sort_order }}</span>
                                        <span class="badge bg-light text-dark">{{ $module->lessons_count ?? $module->lessons->count() }} lessons</span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#moduleEdit{{ $module->id }}" aria-expanded="false" aria-controls="moduleEdit{{ $module->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.english-practice-modules.destroy', $module) }}" method="POST" onsubmit="return confirm('Are you sure? Lessons inside this module may become unassigned.')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse module-edit" id="moduleEdit{{ $module->id }}">
                                <form action="{{ route('admin.english-practice-modules.update', $module) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Title</label>
                                            <input name="title" class="form-control" value="{{ $module->title }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Sort Order</label>
                                            <input type="number" name="sort_order" class="form-control" value="{{ $module->sort_order }}" min="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Status</label>
                                            <select name="status" class="form-select"><option value="published" @selected($module->status === 'published')>Published</option><option value="draft" @selected($module->status === 'draft')>Draft</option></select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Description</label>
                                            <textarea name="description" class="form-control" rows="3">{{ $module->description }}</textarea>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary mt-3"><i class="fas fa-save"></i> Save Module Changes</button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="text-center border rounded-3 p-5 bg-light">
                            <i class="fas fa-layer-group fa-2x text-muted mb-3"></i>
                            <h3 class="h5">No modules yet</h3>
                            <p class="text-muted mb-0">Add a module on the left to organize lessons.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<section class="card section-card mb-4">
    <div class="card-header d-flex flex-wrap justify-content-between gap-2 align-items-center">
        <div>
            <h2 class="h5 section-title"><i class="fas fa-video text-primary"></i> Lessons</h2>
            <p class="section-subtitle">Add video lessons and choose the order learners will watch them.</p>
        </div>
        <a href="{{ route('admin.english-practice-courses.lessons.create', $course) }}" class="btn btn-success"><i class="fas fa-plus-circle"></i> Add Lesson</a>
    </div>
    <div class="card-body">
        @if($course->lessons->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Lesson</th><th>Module</th><th>Video</th><th>Status</th><th>Sort</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @foreach($course->lessons as $lesson)
                            <tr>
                                <td class="lesson-title-cell"><strong>{{ $lesson->title }}</strong><br><small class="text-muted">{{ $lesson->slug }}</small></td>
                                <td>{{ $lesson->module?->title ?? 'Unassigned' }}</td>
                                <td>
                                    @if($lesson->video_path || $lesson->video_url)
                                        <span class="badge bg-success">Video Added</span>
                                        <small class="d-block text-muted">{{ ucfirst($lesson->video_type) }}</small>
                                    @else
                                        <span class="badge bg-secondary">No Video</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-{{ $lesson->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($lesson->status) }}</span></td>
                                <td>{{ $lesson->sort_order }}</td>
                                <td class="text-end lesson-actions">
                                    <a href="{{ route('admin.english-practice-lessons.edit', $lesson) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    @if(Route::has('practice-room.courses.show'))
                                        <a href="{{ route('practice-room.courses.show', [$course, 'lesson' => $lesson->id]) }}" target="_blank" class="btn btn-sm btn-outline-info">Preview</a>
                                    @endif
                                    <form action="{{ route('admin.english-practice-lessons.destroy', $lesson) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this lesson?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center border rounded-3 p-5 bg-light">
                <i class="fas fa-video fa-2x text-muted mb-3"></i>
                <h3 class="h5">No lessons added yet.</h3>
                <p class="text-muted">Create the first video lesson for this English practice course.</p>
                <a href="{{ route('admin.english-practice-courses.lessons.create', $course) }}" class="btn btn-success"><i class="fas fa-plus-circle"></i> Add First Lesson</a>
            </div>
        @endif
    </div>
</section>
@endsection
