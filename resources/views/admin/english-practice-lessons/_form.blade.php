@csrf
@if($lesson->exists) @method('PUT') @endif
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" value="{{ old('title', $lesson->title) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Module</label>
        <select name="english_practice_course_module_id" class="form-select">
            <option value="">No module</option>
            @foreach($course->modules as $module)
                <option value="{{ $module->id }}" @selected((int) old('english_practice_course_module_id', $lesson->english_practice_course_module_id) === $module->id)>{{ $module->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $lesson->description) }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label">Video Type</label>
        <select name="video_type" class="form-select" required>
            @foreach(['upload','url','youtube','vimeo'] as $type)
                <option value="{{ $type }}" @selected(old('video_type', $lesson->video_type ?: 'upload') === $type)>{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Video Upload</label>
        <input type="file" name="video_file" class="form-control" accept="video/mp4,video/webm,video/quicktime">
        @if($lesson->video_path)<small class="text-muted">Current: {{ $lesson->video_path }}</small>@endif
    </div>
    <div class="col-md-4">
        <label class="form-label">Video URL</label>
        <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $lesson->video_url) }}" placeholder="https://...">
    </div>
    <div class="col-md-4">
        <label class="form-label">Thumbnail</label>
        <input type="file" name="thumbnail" class="form-control" accept="image/*">
    </div>
    <div class="col-md-2">
        <label class="form-label">Duration Seconds</label>
        <input type="number" name="duration_seconds" class="form-control" value="{{ old('duration_seconds', $lesson->duration_seconds) }}" min="0">
    </div>
    <div class="col-md-2">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $lesson->sort_order ?? 0) }}" min="0">
    </div>
    <div class="col-md-2">
        <label class="form-label">Status</label>
        <select name="status" class="form-select"><option value="published" @selected(old('status', $lesson->status ?: 'published') === 'published')>Published</option><option value="draft" @selected(old('status', $lesson->status) === 'draft')>Draft</option></select>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <div class="form-check mb-2">
            <input type="hidden" name="is_free" value="0">
            <input type="checkbox" name="is_free" value="1" class="form-check-input" id="isFree" @checked(old('is_free', $lesson->is_free))>
            <label for="isFree" class="form-check-label">Free</label>
        </div>
    </div>
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary">Save Lesson</button>
    <a href="{{ route('admin.english-practice-courses.edit', $course) }}" class="btn btn-outline-secondary">Back to Course</a>
</div>
