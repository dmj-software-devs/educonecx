@extends('layouts.admin')

@section('title', 'Create Progressive Quiz')
@section('page-title', 'Create Progressive Quiz')

@section('content')
<div class="form-card">
    <form action="{{ route('admin.progressive-quizzes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Time Limit (minutes)</label>
                        <input type="number" name="time_limit" class="form-control @error('time_limit') is-invalid @enderror" 
                               value="{{ old('time_limit') }}" min="1">
                        <small class="text-muted">Leave empty for no limit</small>
                        @error('time_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Attempts Allowed</label>
                        <input type="number" name="attempts_allowed" class="form-control @error('attempts_allowed') is-invalid @enderror" 
                               value="{{ old('attempts_allowed', 1) }}" min="0">
                        <small class="text-muted">0 = unlimited</small>
                        @error('attempts_allowed')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pass Percentage</label>
                        <div class="input-group">
                            <input type="number" name="pass_percentage" class="form-control @error('pass_percentage') is-invalid @enderror" 
                                   value="{{ old('pass_percentage', 70) }}" min="0" max="100">
                            <span class="input-group-text">%</span>
                        </div>
                        @error('pass_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Featured Image</h6>
                    </div>
                    <div class="card-body">
                        <div class="featured-image-upload text-center">
                            <div class="image-preview mb-3" id="imagePreview">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                <p class="mb-0 mt-2">Click to upload image</p>
                                <small class="text-muted">PNG, JPG, GIF up to 2MB</small>
                            </div>
                            <input type="file" name="featured_image" id="featuredImage" 
                                   class="d-none" accept="image/*">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('featuredImage').click()">
                                <i class="fas fa-upload"></i> Choose Image
                            </button>
                        </div>
                        @error('featured_image')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Quiz Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input type="checkbox" name="shuffle_questions" class="form-check-input" 
                                   value="1" {{ old('shuffle_questions') ? 'checked' : '' }} id="shuffleQuestions">
                            <label class="form-check-label" for="shuffleQuestions">
                                Shuffle Questions
                            </label>
                        </div>
                        
                        <div class="form-check mb-2">
                            <input type="checkbox" name="show_results" class="form-check-input" 
                                   value="1" {{ old('show_results', true) ? 'checked' : '' }} id="showResults">
                            <label class="form-check-label" for="showResults">
                                Show Results
                            </label>
                        </div>
                        
                        <div class="form-check mb-2">
                            <input type="checkbox" name="show_answers" class="form-check-input" 
                                   value="1" {{ old('show_answers') ? 'checked' : '' }} id="showAnswers">
                            <label class="form-check-label" for="showAnswers">
                                Show Correct Answers
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-actions mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Progressive Quiz
            </button>
            <a href="{{ route('admin.progressive-quizzes.index') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('featuredImage').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">`;
        }
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endpush