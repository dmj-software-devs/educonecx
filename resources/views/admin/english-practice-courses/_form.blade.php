@csrf
@if($course->exists) @method('PUT') @endif
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" value="{{ old('title', $course->title) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Level</label>
        <select name="level" class="form-select">
            <option value="">Choose level</option>
            @foreach(['beginner','intermediate','advanced'] as $level)
                <option value="{{ $level }}" @selected(old('level', $course->level) === $level)>{{ ucfirst($level) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $course->description) }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label">Thumbnail</label>
        <input type="file" name="thumbnail" class="form-control" accept="image/*">
        @if($course->thumbnail)<small class="text-muted">Current: {{ $course->thumbnail }}</small>@endif
    </div>
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            @foreach(['draft','published'] as $status)
                <option value="{{ $status }}" @selected(old('status', $course->status ?: 'draft') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $course->sort_order ?? 0) }}" min="0">
    </div>
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary">Save Course</button>
    <a href="{{ route('admin.english-practice-courses.index') }}" class="btn btn-outline-secondary">Back</a>
</div>
