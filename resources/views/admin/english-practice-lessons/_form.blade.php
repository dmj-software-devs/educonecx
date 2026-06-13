@csrf
@if($lesson->exists) @method('PUT') @endif
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0"><i class="fas fa-video text-primary"></i> Lesson Details</h2>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Lesson Title</label>
                        <input name="title" class="form-control" value="{{ old('title', $lesson->title) }}" required placeholder="Example: Greeting people clearly">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Module / Section</label>
                        <select name="english_practice_course_module_id" class="form-select">
                            <option value="">No module</option>
                            @foreach($course->modules as $module)
                                <option value="{{ $module->id }}" @selected((int) old('english_practice_course_module_id', $lesson->english_practice_course_module_id) === $module->id)>{{ $module->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Short instructions or lesson summary for the learner.">{{ old('description', $lesson->description) }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Duration seconds <span class="text-muted fw-normal">optional</span></label>
                        <input type="number" name="duration_seconds" class="form-control" value="{{ old('duration_seconds', $lesson->duration_seconds) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $lesson->sort_order ?? 0) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="published" @selected(old('status', $lesson->status ?: 'published') === 'published')>Published</option>
                            <option value="draft" @selected(old('status', $lesson->status) === 'draft')>Draft</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input type="hidden" name="is_free" value="0">
                            <input type="checkbox" name="is_free" value="1" class="form-check-input" id="isFree" @checked(old('is_free', $lesson->is_free))>
                            <label for="isFree" class="form-check-label fw-semibold">Is Free</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0"><i class="fas fa-play-circle text-primary"></i> Video Source</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Video Type</label>
                    <select name="video_type" id="videoType" class="form-select" required>
                        <option value="upload" @selected(old('video_type', $lesson->video_type ?: 'upload') === 'upload')>Upload Video</option>
                        <option value="url" @selected(old('video_type', $lesson->video_type) === 'url')>Video URL</option>
                        <option value="youtube" @selected(old('video_type', $lesson->video_type) === 'youtube')>YouTube</option>
                        <option value="vimeo" @selected(old('video_type', $lesson->video_type) === 'vimeo')>Vimeo</option>
                    </select>
                </div>
                <div class="mb-3" id="videoUploadGroup">
                    <label class="form-label fw-semibold">Video Upload</label>
                    <input type="file" name="video_file" class="form-control" accept="video/mp4,video/webm,video/quicktime">
                    <div class="form-text">Allowed: MP4, WebM, MOV. Max: 300MB.</div>
                    @if($lesson->video_path)<small class="text-muted d-block mt-1 text-break">Current: {{ $lesson->video_path }}</small>@endif
                </div>
                <div class="mb-3" id="videoUrlGroup">
                    <label class="form-label fw-semibold">Video URL</label>
                    <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $lesson->video_url) }}" placeholder="https://...">
                    <div class="form-text">Use this for direct video links, YouTube, or Vimeo.</div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0"><i class="fas fa-image text-primary"></i> Lesson Thumbnail</h2>
            </div>
            <div class="card-body">
                @if($lesson->thumbnail)
                    <img src="{{ $lesson->thumbnail_url }}" alt="Current lesson thumbnail" class="img-fluid rounded border mb-2" style="aspect-ratio: 16 / 9; object-fit: cover; width: 100%;">
                    <small class="text-muted d-block text-break mb-2">{{ $lesson->thumbnail }}</small>
                @endif
                <input type="file" name="thumbnail" class="form-control" accept="image/*">
            </div>
        </div>
    </div>
</div>
<div class="mt-4 d-flex flex-wrap gap-2">
    <button class="btn btn-primary"><i class="fas fa-save"></i> Save Lesson</button>
    <a href="{{ route('admin.english-practice-courses.edit', $course) }}" class="btn btn-outline-secondary">Cancel</a>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const videoType = document.getElementById('videoType');
        const uploadGroup = document.getElementById('videoUploadGroup');
        const urlGroup = document.getElementById('videoUrlGroup');
        const toggleVideoFields = () => {
            const isUpload = videoType.value === 'upload';
            uploadGroup.classList.toggle('d-none', !isUpload);
            urlGroup.classList.toggle('d-none', isUpload);
        };
        videoType.addEventListener('change', toggleVideoFields);
        toggleVideoFields();
    });
</script>
@endpush
