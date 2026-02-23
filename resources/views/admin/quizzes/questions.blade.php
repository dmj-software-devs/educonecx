@extends('layouts.admin')

@section('title', 'Quiz Questions')
@section('page-title', 'Quiz Questions: ' . $quiz->title)

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="form-card">
            <h5>Add Question</h5>
            <form action="{{ route('admin.quizzes.questions.store', $quiz) }}" method="POST" enctype="multipart/form-data" id="questionForm">
                @csrf
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <div class="mb-3">
                    <label for="questionType" class="form-label">Question Type</label>
                    <select name="question_type" class="form-control" id="questionType" required>
                        <option value="multiple_choice" {{ old('question_type') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                        <option value="single_choice" {{ old('question_type') == 'single_choice' ? 'selected' : '' }}>Single Choice</option>
                        <option value="true_false" {{ old('question_type') == 'true_false' ? 'selected' : '' }}>True/False</option>
                        <option value="fill_blank" {{ old('question_type') == 'fill_blank' ? 'selected' : '' }}>Fill in the Blank</option>
                        <option value="matching" {{ old('question_type') == 'matching' ? 'selected' : '' }}>Matching</option>
                        <option value="image_selection" {{ old('question_type') == 'image_selection' ? 'selected' : '' }}>Image Selection</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="questionText" class="form-label">Question Text</label>
                    <textarea name="question_text" id="questionText" class="form-control" rows="3" required>{{ old('question_text') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="points" class="form-label">Points</label>
                    <input type="number" name="points" id="points" class="form-control" value="{{ old('points', 1) }}" min="1">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image (Optional)</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <div id="optionsSection" class="mb-3">
                    <label class="form-label">Options</label>
                    <div id="optionsContainer">
                        @php
                            $oldOptions = old('options', [
                                ['text' => '', 'is_correct' => false],
                                ['text' => '', 'is_correct' => false]
                            ]);
                        @endphp
                        
                        @foreach($oldOptions as $index => $option)
                        <div class="input-group mb-2 option-row">
                            <input type="text" 
                                   name="options[{{ $index }}][text]" 
                                   id="option{{ $index }}" 
                                   class="form-control option-input" 
                                   placeholder="Option {{ $index + 1 }}"
                                   value="{{ $option['text'] ?? '' }}">
                            <div class="input-group-text">
                                <input type="checkbox" 
                                       name="options[{{ $index }}][is_correct]" 
                                       id="option{{ $index }}Correct" 
                                       value="1"
                                       {{ isset($option['is_correct']) && $option['is_correct'] ? 'checked' : '' }}>
                                <label for="option{{ $index }}Correct" class="ms-1 mb-0">Correct</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="addOption()">Add Option</button>
                </div>

                <div id="fillBlanksSection" style="display: none;">
                    <label class="form-label">Correct Answers</label>
                    <div id="fillBlanksContainer">
                        @php
                            $oldFillBlanks = old('fill_blanks', [
                                ['answer' => '', 'case_sensitive' => false]
                            ]);
                        @endphp
                        
                        @foreach($oldFillBlanks as $index => $blank)
                        <div class="input-group mb-2 fill-blank-row">
                            <input type="text" 
                                   name="fill_blanks[{{ $index }}][answer]" 
                                   id="fillBlank{{ $index }}" 
                                   class="form-control fill-blank-input" 
                                   placeholder="Answer"
                                   value="{{ $blank['answer'] ?? '' }}">
                            <div class="input-group-text">
                                <input type="checkbox" 
                                       name="fill_blanks[{{ $index }}][case_sensitive]" 
                                       id="fillBlank{{ $index }}Case" 
                                       value="1"
                                       {{ isset($blank['case_sensitive']) && $blank['case_sensitive'] ? 'checked' : '' }}>
                                <label for="fillBlank{{ $index }}Case" class="ms-1 mb-0">Case Sensitive</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="addFillBlank()">Add Answer</button>
                </div>

                <button type="submit" class="btn btn-primary">Add Question</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="table-container">
            <h5>Questions ({{ $quiz->questions->count() }})</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Type</th>
                        <th>Points</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quiz->questions as $question)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::limit($question->question_text, 50) }}</td>
                        <td>{{ str_replace('_', ' ', ucfirst($question->question_type)) }}</td>
                        <td>{{ $question->points }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteQuestion({{ $question->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No questions added yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    let optionCount = {{ count(old('options', [['text' => ''], ['text' => '']])) }};
    let fillBlankCount = {{ count(old('fill_blanks', [['answer' => '']])) }};

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the form based on default selection or old input
        const questionType = document.getElementById('questionType');
        toggleSections(questionType.value);
        
        // Add change event listener
        questionType.addEventListener('change', function() {
            toggleSections(this.value);
        });

        // Form submission handling
        const form = document.getElementById('questionForm');
        form.addEventListener('submit', function(e) {
            // Enable all inputs before submit to ensure they're submitted
            enableCurrentSectionInputs();
        });
    });

    function toggleSections(type) {
        const optionsSection = document.getElementById('optionsSection');
        const fillBlanksSection = document.getElementById('fillBlanksSection');
        
        // First, disable all inputs in both sections
        disableAllInputs();
        
        if (type === 'fill_blank') {
            optionsSection.style.display = 'none';
            fillBlanksSection.style.display = 'block';
            // Enable only fill blanks inputs
            enableFillBlanksInputs();
        } else {
            optionsSection.style.display = 'block';
            fillBlanksSection.style.display = 'none';
            // Enable only options inputs
            enableOptionsInputs();
        }
    }

    function disableAllInputs() {
        // Disable all option inputs and checkboxes
        document.querySelectorAll('.option-input, .option-row input[type="checkbox"]').forEach(input => {
            input.disabled = true;
        });
        
        // Disable all fill blank inputs and checkboxes
        document.querySelectorAll('.fill-blank-input, .fill-blank-row input[type="checkbox"]').forEach(input => {
            input.disabled = true;
        });
    }

    function enableOptionsInputs() {
        document.querySelectorAll('.option-input, .option-row input[type="checkbox"]').forEach(input => {
            input.disabled = false;
        });
    }

    function enableFillBlanksInputs() {
        document.querySelectorAll('.fill-blank-input, .fill-blank-row input[type="checkbox"]').forEach(input => {
            input.disabled = false;
        });
    }

    function enableCurrentSectionInputs() {
        const type = document.getElementById('questionType').value;
        if (type === 'fill_blank') {
            enableFillBlanksInputs();
        } else {
            enableOptionsInputs();
        }
    }

    function addOption() {
        const container = document.getElementById('optionsContainer');
        const optionId = `option${optionCount}`;
        const correctId = `option${optionCount}Correct`;
        
        const div = document.createElement('div');
        div.className = 'input-group mb-2 option-row';
        div.innerHTML = `
            <input type="text" 
                   name="options[${optionCount}][text]" 
                   id="${optionId}" 
                   class="form-control option-input" 
                   placeholder="Option ${optionCount + 1}">
            <div class="input-group-text">
                <input type="checkbox" 
                       name="options[${optionCount}][is_correct]" 
                       id="${correctId}" 
                       value="1">
                <label for="${correctId}" class="ms-1 mb-0">Correct</label>
            </div>
        `;
        container.appendChild(div);
        
        // If current section is not fill_blank, enable the new inputs
        if (document.getElementById('questionType').value !== 'fill_blank') {
            div.querySelectorAll('input').forEach(input => input.disabled = false);
        }
        
        optionCount++;
    }

    function addFillBlank() {
        const container = document.getElementById('fillBlanksContainer');
        const fillBlankId = `fillBlank${fillBlankCount}`;
        const caseId = `fillBlank${fillBlankCount}Case`;
        
        const div = document.createElement('div');
        div.className = 'input-group mb-2 fill-blank-row';
        div.innerHTML = `
            <input type="text" 
                   name="fill_blanks[${fillBlankCount}][answer]" 
                   id="${fillBlankId}" 
                   class="form-control fill-blank-input" 
                   placeholder="Answer">
            <div class="input-group-text">
                <input type="checkbox" 
                       name="fill_blanks[${fillBlankCount}][case_sensitive]" 
                       id="${caseId}" 
                       value="1">
                <label for="${caseId}" class="ms-1 mb-0">Case Sensitive</label>
            </div>
        `;
        container.appendChild(div);
        
        // If current section is fill_blank, enable the new inputs
        if (document.getElementById('questionType').value === 'fill_blank') {
            div.querySelectorAll('input').forEach(input => input.disabled = false);
        }
        
        fillBlankCount++;
    }

    function deleteQuestion(id) {
        if (confirm('Are you sure you want to delete this question?')) {
            const form = document.getElementById('deleteForm');
            form.action = '{{ url("admin/quizzes/questions") }}/' + id;
            form.submit();
        }
    }
</script>
@endsection