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
    .module-card[draggable="true"], .lesson-row[draggable="true"] { cursor: grab; }
    .module-card.dragging, .lesson-row.dragging { opacity: .55; outline: 2px dashed #2563eb; }
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModuleModal"><i class="fas fa-layer-group"></i> Add Module</button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLessonModal"><i class="fas fa-plus-circle"></i> Add Lesson</button>
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
    <div class="card-header d-flex flex-wrap justify-content-between gap-2 align-items-center">
        <div>
            <h2 class="h5 section-title"><i class="fas fa-layer-group text-primary"></i> Course → Modules → Lessons</h2>
            <p class="section-subtitle">Use accordion modules, clean lesson tables, and drag handles to keep the course organized.</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModuleModal"><i class="fas fa-plus"></i> Add Module</button>
    </div>
    <div class="card-body">
        <div class="accordion d-flex flex-column gap-3" id="moduleAccordion" data-reorder-url="{{ route('admin.english-practice-courses.reorder-modules', $course) }}">
            @forelse($course->modules as $module)
                <article class="module-card" draggable="true" data-module-id="{{ $module->id }}">
                    <div class="accordion-item border-0">
                        <h3 class="accordion-header" id="moduleHeading{{ $module->id }}">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} module-summary" type="button" data-bs-toggle="collapse" data-bs-target="#modulePanel{{ $module->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="modulePanel{{ $module->id }}">
                                <span class="me-3 text-muted"><i class="fas fa-grip-vertical"></i></span>
                                <span class="flex-grow-1"><strong>{{ $module->title }}</strong><br><small class="text-muted">{{ $module->description ?: 'No description added.' }}</small></span>
                                <span class="badge bg-{{ $module->status === 'published' ? 'success' : 'secondary' }} me-2">{{ ucfirst($module->status) }}</span>
                                <span class="badge bg-light text-dark me-3">{{ $module->lessons_count ?? $module->lessons->count() }} lessons</span>
                            </button>
                        </h3>
                        <div id="modulePanel{{ $module->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="moduleHeading{{ $module->id }}" data-bs-parent="#moduleAccordion">
                            <div class="accordion-body">
                                <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#editModuleModal{{ $module->id }}"><i class="fas fa-edit"></i> Edit Module</button>
                                    <form action="{{ route('admin.english-practice-modules.destroy', $module) }}" method="POST" onsubmit="return confirm('Delete this module? Lessons inside it may become unassigned.')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Delete Module</button>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover align-middle mb-0">
                                        <thead class="table-light"><tr><th>Lesson</th><th>Status</th><th>Sort</th><th class="text-end">Actions</th></tr></thead>
                                        <tbody>
                                            @forelse($module->lessons as $lesson)
                                                <tr><td><strong>{{ $lesson->title }}</strong><br><small class="text-muted">{{ $lesson->video_type ?: 'video' }}</small></td><td><span class="badge bg-{{ $lesson->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($lesson->status) }}</span></td><td>{{ $lesson->sort_order }}</td><td class="text-end"><a href="{{ route('admin.english-practice-lessons.edit', $lesson) }}" class="btn btn-sm btn-outline-primary">Edit</a></td></tr>
                                            @empty
                                                <tr><td colspan="4" class="text-muted text-center py-3">No lessons in this module yet.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="text-center border rounded-3 p-5 bg-light"><i class="fas fa-layer-group fa-2x text-muted mb-3"></i><h3 class="h5">No modules yet</h3><p class="text-muted mb-0">Use Add Module to organize lessons.</p></div>
            @endforelse
        </div>
    </div>
</section>

<section class="card section-card mb-4">
    <div class="card-header d-flex flex-wrap justify-content-between gap-2 align-items-center">
        <div>
            <h2 class="h5 section-title"><i class="fas fa-video text-primary"></i> Lessons</h2>
            <p class="section-subtitle">Add video lessons and choose the order learners will watch them.</p>
        </div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLessonModal"><i class="fas fa-plus-circle"></i> Add Lesson</button>
    </div>
    <div class="card-body">
        @if($course->lessons->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Lesson</th><th>Module</th><th>Video</th><th>Status</th><th>Sort</th><th class="text-end">Actions</th></tr></thead>
                    <tbody id="lessonsSortable" data-reorder-url="{{ route('admin.english-practice-courses.reorder-lessons', $course) }}">
                        @foreach($course->lessons as $lesson)
                            <tr class="lesson-row" draggable="true" data-lesson-id="{{ $lesson->id }}">
                                <td class="lesson-title-cell"><i class="fas fa-grip-vertical text-muted me-2"></i><strong>{{ $lesson->title }}</strong><br><small class="text-muted">{{ $lesson->slug }}</small></td>
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

<div class="modal fade" id="addModuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content"><form action="{{ route('admin.english-practice-courses.modules.store', $course) }}" method="POST">@csrf
        <div class="modal-header"><h5 class="modal-title">Add Module</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body"><div class="mb-3"><label class="form-label fw-semibold">Title</label><input name="title" class="form-control" required></div><div class="mb-3"><label class="form-label fw-semibold">Description</label><textarea name="description" class="form-control" rows="3"></textarea></div><div class="row g-2"><div class="col-6"><label class="form-label fw-semibold">Sort</label><input type="number" name="sort_order" class="form-control" value="0" min="0"></div><div class="col-6"><label class="form-label fw-semibold">Status</label><select name="status" class="form-select"><option value="published">Published</option><option value="draft">Draft</option></select></div></div></div>
        <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary">Save Module</button></div>
    </form></div></div>
</div>
<div class="modal fade" id="addLessonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Add Lesson</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><p class="text-muted mb-0">The full lesson editor opens on the next page so video uploads, module assignment, and lesson content stay uncluttered.</p></div><div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><a href="{{ route('admin.english-practice-courses.lessons.create', $course) }}" class="btn btn-success">Open Lesson Editor</a></div></div></div>
</div>
@foreach($course->modules as $module)
<div class="modal fade" id="editModuleModal{{ $module->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content"><form action="{{ route('admin.english-practice-modules.update', $module) }}" method="POST">@csrf @method('PUT')
        <div class="modal-header"><h5 class="modal-title">Edit Module</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body"><div class="mb-3"><label class="form-label fw-semibold">Title</label><input name="title" class="form-control" value="{{ $module->title }}" required></div><div class="mb-3"><label class="form-label fw-semibold">Description</label><textarea name="description" class="form-control" rows="3">{{ $module->description }}</textarea></div><div class="row g-2"><div class="col-6"><label class="form-label fw-semibold">Sort</label><input type="number" name="sort_order" class="form-control" value="{{ $module->sort_order }}" min="0"></div><div class="col-6"><label class="form-label fw-semibold">Status</label><select name="status" class="form-select"><option value="published" @selected($module->status === 'published')>Published</option><option value="draft" @selected($module->status === 'draft')>Draft</option></select></div></div></div>
        <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary">Save Changes</button></div>
    </form></div></div>
</div>
@endforeach
<script>
(function(){
 const csrf=document.querySelector('meta[name="csrf-token"]')?.content;
 function sortable(container, itemSelector, idAttr, key){
   if(!container) return; let dragged=null;
   container.querySelectorAll(itemSelector).forEach(item=>{
     item.addEventListener('dragstart',()=>{dragged=item; item.classList.add('dragging');});
     item.addEventListener('dragend',async()=>{item.classList.remove('dragging'); const ids=[...container.querySelectorAll(itemSelector)].map(el=>el.dataset[idAttr]); const url=container.dataset.reorderUrl; if(url){await fetch(url,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json'},body:JSON.stringify({[key]:ids})}).catch(()=>{});} });
     item.addEventListener('dragover',e=>{e.preventDefault(); const target=e.currentTarget; if(dragged&&dragged!==target){const rect=target.getBoundingClientRect(); target.parentNode.insertBefore(dragged, e.clientY-rect.top>rect.height/2 ? target.nextSibling : target);}});
   });
 }
 sortable(document.getElementById('moduleAccordion'), '.module-card', 'moduleId', 'modules');
 sortable(document.getElementById('lessonsSortable'), '.lesson-row', 'lessonId', 'lessons');
})();
</script>

@endsection
