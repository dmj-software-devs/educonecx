@extends('layouts.admin')

@section('title', 'Quiz Questions')
@section('page-title', 'Quiz Questions: ' . $quiz->title)

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="form-card">
            <h5>Add Question</h5>
            <form action="{{ route('admin.quizzes.questions.store', $quiz) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Question Type</label>
                    <select name="question_type" class="form-control" id="questionType" required>
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="single_choice">Single Choice</option>
                        <option value="true_false">True/False</option>
                        <option value="fill_blank">Fill in the Blank</option>
                        <option value="matching">Matching</option>
                        <option value="image_selection">Image Selection</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Question Text</label>
                    <textarea name="question_text" class="form-control" rows="3" required></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Points</label>
                    <input type="number" name="points" class="form-control" value="1" min="1">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Image (Optional)</label>
                    <input type="file" name="image" class="form-control">
                </div>
                
                <div id="optionsSection" class="mb-3">
                    <label class="form-label">Options</label>
                    <div id="optionsContainer">
                        <div class="input-group mb-2">
                            <input type="text" name="options[0][text]" class="form-control" placeholder="Option 1">
                            <div class="input-group-text">
                                <input type="checkbox" name="options[0][is_correct]" value="1"> Correct
                            </div>
                        </div>
                        <div class="input-group mb-2">
                            <input type="text" name="options[1][text]" class="form-control" placeholder="Option 2">
                            <div class="input-group-text">
                                <input type="checkbox" name="options[1][is_correct]" value="1"> Correct
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="addOption()">Add Option</button>
                </div>
                
                <div id="fillBlanksSection" style="display: none;">
                    <label class="form-label">Correct Answers</label>
                    <div id="fillBlanksContainer">
                        <div class="input-group mb-2">
                            <input type="text" name="fill_blanks[0][answer]" class="form-control" placeholder="Answer">
                            <div class="input-group-text">
                                <input type="checkbox" name="fill_blanks[0][case_sensitive]" value="1"> Case Sensitive
                            </div>
                        </div>
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
                    @foreach($quiz->questions as $question)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::limit($question->question_text, 50) }}</td>
                        <td>{{ str_replace('_', ' ', ucfirst($question->question_type)) }}</td>
                        <td>{{ $question->points }}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="deleteQuestion({{ $question->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
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
    let optionCount = 2;
    let fillBlankCount = 1;
    
    document.getElementById('questionType').addEventListener('change', function() {
        const type = this.value;
        
        if (type === 'fill_blank') {
            document.getElementById('optionsSection').style.display = 'none';
            document.getElementById('fillBlanksSection').style.display = 'block';
        } else {
            document.getElementById('optionsSection').style.display = 'block';
            document.getElementById('fillBlanksSection').style.display = 'none';
        }
    });
    
    function addOption() {
        const container = document.getElementById('optionsContainer');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" name="options[${optionCount}][text]" class="form-control" placeholder="Option ${optionCount + 1}">
            <div class="input-group-text">
                <input type="checkbox" name="options[${optionCount}][is_correct]" value="1"> Correct
            </div>
        `;
        container.appendChild(div);
        optionCount++;
    }
    
    function addFillBlank() {
        const container = document.getElementById('fillBlanksContainer');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" name="fill_blanks[${fillBlankCount}][answer]" class="form-control" placeholder="Answer">
            <div class="input-group-text">
                <input type="checkbox" name="fill_blanks[${fillBlankCount}][case_sensitive]" value="1"> Case Sensitive
            </div>
        `;
        container.appendChild(div);
        fillBlankCount++;
    }
    
    function deleteQuestion(id) {
        if (confirm('Are you sure?')) {
            const form = document.getElementById('deleteForm');
            form.action = '{{ url("admin/quizzes/questions") }}/' + id;
            form.submit();
        }
    }
</script>
@endsection