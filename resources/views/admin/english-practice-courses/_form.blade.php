@csrf
@if($course->exists) @method('PUT') @endif
<div class="row g-4">
    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-semibold">Title</label>
                <input name="title" class="form-control" value="{{ old('title', $course->title) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Level</label>
                <select name="level" class="form-select">
                    <option value="">Choose level</option>
                    @foreach(['beginner','intermediate','advanced'] as $level)
                        <option value="{{ $level }}" @selected(old('level', $course->level) === $level)>{{ ucfirst($level) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="5" placeholder="Short description shown to learners on the Practice Room page.">{{ old('description', $course->description) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select" required>
                    @foreach(['draft','published'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $course->status ?: 'draft') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $course->sort_order ?? 0) }}" min="0">
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <label class="form-label fw-semibold">Thumbnail</label>
        <div class="border rounded-3 p-3 bg-light">
            <p class="text-muted small mb-2">Recommended thumbnail size: 1280 x 720 pixels. Use a clear course image, not screenshots or charts.</p>
            @if($course->thumbnail)
                <div class="mb-3">
                    <div class="fw-semibold small mb-2">Current Thumbnail</div>
                    <img src="{{ $course->thumbnail_url }}" alt="Current thumbnail for {{ $course->title }}" class="img-fluid rounded border" style="aspect-ratio: 16 / 9; object-fit: cover; width: 100%; max-width: 280px;">
                    <div class="small text-muted mt-2 text-break">{{ $course->thumbnail }}</div>
                </div>
            @else
                <div class="d-flex align-items-center justify-content-center rounded border mb-3" style="aspect-ratio: 16 / 9; background: #eef2f7;">
                    <div class="text-center text-muted">
                        <i class="fas fa-image fa-2x mb-2"></i><br>
                        No thumbnail uploaded
                    </div>
                </div>
            @endif
            <input type="file" name="thumbnail" class="form-control" accept="image/*">
        </div>
    </div>
</div>

<div class="mt-4 d-flex flex-wrap gap-2">
    <button class="btn btn-primary"><i class="fas fa-save"></i> Save Course</button>
</div>
