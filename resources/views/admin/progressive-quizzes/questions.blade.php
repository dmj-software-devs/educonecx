@extends('layouts.admin')

@section('title', 'Manage Questions - Level ' . $progressiveLevel->level_number)
@section('page-title', 'Level ' . $progressiveLevel->level_number . ': ' . $progressiveLevel->title)

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
            <i class="fas fa-question-circle fa-2x text-primary"></i>
        </div>
        <div>
            <h2 class="mb-1">{{ $progressiveLevel->title }}</h2>
            <p class="text-muted mb-0"><i class="fas fa-list me-2"></i>Manage questions for this level</p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.progressive-quizzes.levels', $progressiveLevel->quiz) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Levels
        </a>
        <a href="{{ route('admin.progressive-quizzes.edit', $progressiveLevel->quiz) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i> Edit Quiz
        </a>
    </div>
</div>

<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3"><i class="fas fa-layer-group fa-2x"></i></div>
                <div><span class="text-muted text-uppercase small fw-bold">Level</span><h3 class="mb-0 fw-bold">{{ $progressiveLevel->level_number }}</h3></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 p-3 me-3"><i class="fas fa-question-circle fa-2x"></i></div>
                <div><span class="text-muted text-uppercase small fw-bold">Questions</span><h3 class="mb-0 fw-bold">{{ $progressiveLevel->questions->count() }}</h3></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3"><i class="fas fa-star fa-2x"></i></div>
                <div><span class="text-muted text-uppercase small fw-bold">Total Points</span><h3 class="mb-0 fw-bold">{{ $progressiveLevel->questions->sum('points') }}</h3></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3 p-3 me-3"><i class="fas fa-percent fa-2x"></i></div>
                <div><span class="text-muted text-uppercase small fw-bold">Pass Required</span><h3 class="mb-0 fw-bold">{{ $progressiveLevel->min_percentage }}%</h3></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Add Question Form -->
    <div class="col-lg-5 mb-4">
        <div class="card sticky-top" style="top:20px;z-index:100;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Add New Question</h5>
                <span class="badge bg-primary rounded-pill px-3 py-2">{{ $progressiveLevel->questions->count() + 1 }}</span>
            </div>
            <div class="card-body" style="max-height:800px;overflow-y:auto;">
                <form action="{{ route('admin.progressive-quizzes.questions.store', ['progressiveQuiz' => $progressiveLevel->quiz->id, 'progressiveLevel' => $progressiveLevel->id]) }}"
                      method="POST" enctype="multipart/form-data" id="questionForm">
                    @csrf

                    <div id="errorContainer" class="alert alert-danger alert-dismissible fade show" style="display:none;">
                        <strong><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following:</strong>
                        <ul id="errorList" class="mb-0 mt-2"></ul>
                        <button type="button" class="btn-close" onclick="this.closest('.alert').style.display='none'"></button>
                    </div>

                    <!-- Question Type -->
                    <div class="mb-3">
                        <label class="form-label fw-medium"><i class="fas fa-tag me-2"></i>Question Type <span class="text-danger">*</span></label>
                        <select name="question_type" id="questionType" class="form-select" required onchange="handleTypeChange(this.value)">
                            <option value="multiple_choice">Multiple Choice (select all that apply)</option>
                            <option value="single_choice">Single Choice (select one)</option>
                            <option value="true_false">True / False</option>
                            <option value="fill_blank">Fill in the Blank</option>
                            <option value="matching">Matching</option>
                            <option value="image_selection">Image Selection</option>
                        </select>
                    </div>

                    <!-- Question Text -->
                    <div class="mb-3">
                        <label class="form-label fw-medium"><i class="fas fa-paragraph me-2"></i>Question Text <span class="text-danger">*</span></label>
                        <textarea name="question_text" class="form-control" rows="3" placeholder="Enter your question here..." required>{{ old('question_text') }}</textarea>
                    </div>

                    <!-- Explanation -->
                    <div class="mb-3">
                        <label class="form-label fw-medium"><i class="fas fa-info-circle me-2"></i>Explanation (Optional)</label>
                        <textarea name="explanation" class="form-control" rows="2" placeholder="Explain why the answer is correct...">{{ old('explanation') }}</textarea>
                    </div>

                    <!-- Points & Image -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium"><i class="fas fa-coins me-2"></i>Points</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-star text-warning"></i></span>
                                <input type="number" name="points" class="form-control" value="{{ old('points', 1) }}" min="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium"><i class="fas fa-image me-2"></i>Question Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <!-- MCQ / Single / True-False Options -->
                    <div id="optionsSection" class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-medium mb-0"><i class="fas fa-list-ul me-2"></i>Answer Options</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark" id="optionsCount">2 options</span>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addOptionBtn" onclick="addOption()"><i class="fas fa-plus me-1"></i>Add Option</button>
                            </div>
                        </div>
                        <small class="text-muted d-block mb-2" id="optionsHint">Check the box(es) next to the correct answer(s).</small>
                        <div id="optionsContainer"></div>
                    </div>

                    <!-- Image Selection -->
                    <div id="imageSelectionSection" class="mb-3" style="display:none;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-medium mb-0"><i class="fas fa-images me-2"></i>Image Options</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark" id="imageOptionsCount">2 images</span>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addImageOption()"><i class="fas fa-plus me-1"></i>Add Image</button>
                            </div>
                        </div>
                        <div id="imageOptionsContainer"></div>
                    </div>

                    <!-- Fill Blank -->
                    <div id="fillBlanksSection" class="mb-3" style="display:none;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-medium mb-0"><i class="fas fa-pencil-alt me-2"></i>Accepted Answers</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark" id="blanksCount">1 answer</span>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addFillBlank()"><i class="fas fa-plus me-1"></i>Add Answer</button>
                            </div>
                        </div>
                        <div class="alert alert-info py-2 small"><i class="fas fa-info-circle me-1"></i>Add all accepted variations of the correct answer.</div>
                        <div id="fillBlanksContainer"></div>
                    </div>

                    <!-- Matching -->
                    <div id="matchingSection" class="mb-3" style="display:none;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-medium mb-0"><i class="fas fa-link me-2"></i>Matching Pairs</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark" id="matchingCount">2 pairs</span>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addMatchingPair()"><i class="fas fa-plus me-1"></i>Add Pair</button>
                            </div>
                        </div>
                        <div class="alert alert-info py-2 small"><i class="fas fa-info-circle me-1"></i>Each left item will be matched to its right item.</div>
                        <div id="matchingPairsContainer"></div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-2" id="submitBtn">
                        <i class="fas fa-plus-circle me-2"></i>Add Question
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Questions List -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-list text-primary"></i>
                    <div>
                        <h5 class="mb-0">Questions List</h5>
                        <small class="text-muted">{{ $progressiveLevel->questions->count() }} total questions</small>
                    </div>
                </div>
                <div class="bg-light rounded-3 px-3 py-2">
                    <span class="text-muted small">Total Points:</span>
                    <span class="fw-bold ms-1">{{ $progressiveLevel->questions->sum('points') }}</span>
                </div>
            </div>
            <div class="questions-list p-3" id="questionsList" style="max-height:800px;overflow-y:auto;">
                @forelse($progressiveLevel->questions as $question)
                <div class="question-card card mb-3 border-0 shadow-sm" id="question-{{ $question->id }}" data-id="{{ $question->id }}" data-order="{{ $question->sort_order }}">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3">
                            <div class="question-drag-handle text-muted" style="cursor:move;margin-top:8px;"><i class="fas fa-grip-vertical fa-lg"></i></div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge bg-primary rounded-pill px-3 py-2">Q{{ $loop->iteration }}</span>
                                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">{{ str_replace('_',' ',ucfirst($question->question_type)) }}</span>
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">{{ $question->points }} pts</span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-primary" onclick="editQuestion({{ $question->id }})" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteQuestion({{ $question->id }})" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                <p class="mb-2 fw-medium">{{ $question->question_text }}</p>
                                @if($question->explanation)
                                <div class="bg-info bg-opacity-10 text-info p-2 rounded-3 small mb-2"><i class="fas fa-info-circle me-1"></i>{{ $question->explanation }}</div>
                                @endif
                                @if($question->image)
                                <div class="mb-2"><img src="{{ Storage::url($question->image) }}" class="rounded-3" style="max-width:200px;max-height:150px;"></div>
                                @endif
                                <div class="answers-preview">
                                    @if(in_array($question->question_type,['multiple_choice','single_choice','true_false']))
                                        @foreach($question->options as $option)
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="fw-medium text-muted" style="min-width:25px;">{{ chr(65+$loop->index) }}</span>
                                            <span class="flex-grow-1">{{ $option->option_text }}</span>
                                            @if($option->is_correct)<i class="fas fa-check-circle text-success"></i>@endif
                                        </div>
                                        @endforeach
                                    @elseif($question->question_type=='image_selection')
                                        <div class="row g-2">
                                            @foreach($question->options as $option)
                                            <div class="col-md-6">
                                                <div class="border rounded-3 p-2 {{ $option->is_correct?'border-success':'' }}">
                                                    @if($option->image)<img src="{{ Storage::url($option->image) }}" class="img-fluid rounded-2 mb-1" style="max-height:60px;">@endif
                                                    <small>{{ $option->option_text }}</small>
                                                    @if($option->is_correct)<span class="badge bg-success ms-1">Correct</span>@endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @elseif($question->question_type=='fill_blank')
                                        @foreach($question->fillBlanks as $blank)
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="fas fa-pencil-alt text-muted"></i>
                                            <span>"{{ $blank->correct_answer }}"</span>
                                            @if($blank->case_sensitive)<span class="badge bg-secondary">Case Sensitive</span>@endif
                                        </div>
                                        @endforeach
                                    @elseif($question->question_type=='matching')
                                        <table class="table table-sm mb-0">
                                            @foreach($question->matchingPairs as $pair)
                                            <tr>
                                                <td class="border-0">{{ $pair->left_item }}</td>
                                                <td class="border-0 text-muted"><i class="fas fa-arrow-right"></i></td>
                                                <td class="border-0">{{ $pair->right_item }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <div class="bg-light rounded-circle d-inline-flex p-4 mb-3"><i class="fas fa-question-circle fa-3x text-muted"></i></div>
                    <h5>No Questions Yet</h5>
                    <p class="text-muted mb-3">Start by adding your first question using the form</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<!-- Edit Question Modal -->
<div class="modal fade" id="editQuestionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2 text-primary"></i>Edit Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="editQuestionContent">
                <div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.stat-icon{transition:transform .2s}
.stat-card:hover .stat-icon{transform:scale(1.1)}
.question-card{transition:all .3s ease;border-left:4px solid transparent}
.question-card:hover{border-left-color:var(--bs-primary);transform:translateX(4px);box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important}
.question-drag-handle{opacity:.5;transition:opacity .2s}
.question-card:hover .question-drag-handle{opacity:1}
.sortable-ghost{opacity:.4;background-color:var(--bs-primary);border:2px dashed var(--bs-primary)}

/* Option rows */
.opt-row{display:flex;align-items:center;gap:10px;background:#f8f9fa;padding:10px 12px;border-radius:8px;margin-bottom:8px}
.opt-row input[type=text],.opt-row input.form-control-text{flex:1;padding:8px 12px;border:1px solid #dee2e6;border-radius:6px;font-size:.9rem}
.opt-letter{min-width:24px;font-weight:700;color:#6c757d;text-align:center}
.correct-lbl{display:inline-flex;align-items:center;gap:5px;font-size:13px;cursor:pointer;white-space:nowrap;flex-shrink:0;color:#495057}
.remove-btn{width:32px;height:32px;border:none;background:#fee2e2;color:#dc2626;border-radius:6px;cursor:pointer;flex-shrink:0;display:inline-flex;align-items:center;justify-content:center}
.remove-btn:hover{background:#dc2626;color:#fff}

/* Image option */
.img-opt-row{background:#f8f9fa;padding:12px;border-radius:8px;margin-bottom:10px}
.img-preview-box{width:90px;height:90px;border:2px dashed #dee2e6;border-radius:8px;display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;overflow:hidden;flex-shrink:0;transition:border-color .2s}
.img-preview-box:hover{border-color:var(--bs-primary)}
.img-preview-box img{width:100%;height:100%;object-fit:cover}
.img-preview-box i{font-size:22px;color:#adb5bd}
.img-preview-box span{font-size:10px;color:#6c757d;text-align:center;margin-top:4px}

/* Blank / Matching rows */
.blank-row,.match-row{display:flex;align-items:center;gap:10px;background:#f8f9fa;padding:10px 12px;border-radius:8px;margin-bottom:8px}
.blank-row input[type=text],.match-row input[type=text]{flex:1;padding:8px 12px;border:1px solid #dee2e6;border-radius:6px;font-size:.9rem}
.match-arrow{color:#adb5bd;font-size:18px;flex-shrink:0}

@media(max-width:992px){.sticky-top{position:relative!important;top:0!important}}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
/* ───────────────────────────────────────────────────────────
   GLOBALS
─────────────────────────────────────────────────────────── */
const levelId = {{ $progressiveLevel->id }};
const quizId  = {{ $progressiveLevel->quiz->id }};
let currentEditId = null;
let editModalInstance = null;

function csrfToken(){ return document.querySelector('meta[name="csrf-token"]').content; }
function escH(s){ if(!s)return''; return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;'); }
function letter(i){ return String.fromCharCode(65+i); }

/* ───────────────────────────────────────────────────────────
   SECTION TOGGLE — smart per type
─────────────────────────────────────────────────────────── */
function handleTypeChange(type){
    const sections = ['optionsSection','imageSelectionSection','fillBlanksSection','matchingSection'];
    sections.forEach(id => {
        const el = document.getElementById(id);
        el.style.display = 'none';
        el.querySelectorAll('input,select,textarea').forEach(i => i.disabled = true);
    });

    let showId;
    if(type==='fill_blank')      showId='fillBlanksSection';
    else if(type==='matching')   showId='matchingSection';
    else if(type==='image_selection') showId='imageSelectionSection';
    else                         showId='optionsSection';

    const active = document.getElementById(showId);
    active.style.display = 'block';
    active.querySelectorAll('input,select,textarea').forEach(i => i.disabled = false);

    if(['multiple_choice','single_choice','true_false'].includes(type)){
        rebuildOptionsForType(type);
    }
}

/* ───────────────────────────────────────────────────────────
   MCQ / SINGLE / TRUE-FALSE OPTIONS
─────────────────────────────────────────────────────────── */
function rebuildOptionsForType(type){
    const container  = document.getElementById('optionsContainer');
    const hint       = document.getElementById('optionsHint');
    const addBtn     = document.getElementById('addOptionBtn');

    if(type === 'true_false'){
        hint.textContent = 'Select the correct answer.';
        addBtn.style.display = 'none';
        container.innerHTML = '';
        _buildOptRow(container, 0, 'True',  'radio', false);
        _buildOptRow(container, 1, 'False', 'radio', false);
    } else if(type === 'single_choice'){
        hint.textContent = 'Select the one correct answer (radio).';
        addBtn.style.display = '';
        // preserve existing unless they were TF
        if(!container.children.length || container.querySelector('[data-tf]')){
            container.innerHTML='';
            _buildOptRow(container,0,'','radio',true);
            _buildOptRow(container,1,'','radio',true);
        } else {
            _refreshInputType(container,'radio');
        }
    } else { // multiple_choice
        hint.textContent = 'Check all correct answers.';
        addBtn.style.display = '';
        if(!container.children.length || container.querySelector('[data-tf]')){
            container.innerHTML='';
            _buildOptRow(container,0,'','checkbox',true);
            _buildOptRow(container,1,'','checkbox',true);
        } else {
            _refreshInputType(container,'checkbox');
        }
    }
    _updateOptCount();
}

function _buildOptRow(container, index, defaultVal, inputType, removable){
    const row = document.createElement('div');
    row.className = 'opt-row';
    row.dataset.index = index;
    if(!removable) row.dataset.tf = '1';

    const correctName  = inputType==='radio' ? 'correct_option' : `options[${index}][is_correct]`;
    const correctValue = inputType==='radio' ? index : '1';

    row.innerHTML = `
        <span class="opt-letter">${letter(index)}</span>
        <input type="text" name="options[${index}][text]" value="${escH(defaultVal)}"
               placeholder="Option ${index+1}" ${removable?'required':''} ${removable?'':'readonly'}>
        <label class="correct-lbl">
            <input type="${inputType}" name="${correctName}" value="${correctValue}"> Correct
        </label>
        ${removable?`<button type="button" class="remove-btn" onclick="removeOption(this)"><i class="fas fa-times"></i></button>`:''}`;
    container.appendChild(row);
}

function _refreshInputType(container, inputType){
    container.querySelectorAll('.opt-row').forEach((row,i)=>{
        const chk = row.querySelector('input[type=radio],input[type=checkbox]');
        if(!chk) return;
        chk.type  = inputType;
        chk.name  = inputType==='radio' ? 'correct_option' : `options[${i}][is_correct]`;
        chk.value = inputType==='radio' ? i : '1';
    });
}

function addOption(){
    const container = document.getElementById('optionsContainer');
    const type      = document.getElementById('questionType').value;
    if(type==='true_false') return;
    const index = container.children.length;
    _buildOptRow(container, index, '', type==='multiple_choice'?'checkbox':'radio', true);
    _reindexOptions();
    _updateOptCount();
}

function removeOption(btn){
    const container = document.getElementById('optionsContainer');
    if(container.children.length<=1){alert('Need at least one option');return;}
    btn.closest('.opt-row').remove();
    _reindexOptions();
    _updateOptCount();
}

function _reindexOptions(){
    const type = document.getElementById('questionType').value;
    document.querySelectorAll('#optionsContainer .opt-row').forEach((row,i)=>{
        row.dataset.index = i;
        const l = row.querySelector('.opt-letter');
        if(l) l.textContent = letter(i);
        const txt = row.querySelector('input[type=text]');
        if(txt){txt.name=`options[${i}][text]`;txt.placeholder=`Option ${i+1}`;}
        const chk = row.querySelector('input[type=radio],input[type=checkbox]');
        if(chk){
            if(type==='multiple_choice'){chk.type='checkbox';chk.name=`options[${i}][is_correct]`;chk.value='1';}
            else{chk.type='radio';chk.name='correct_option';chk.value=i;}
        }
    });
}

function _updateOptCount(){
    const n = document.getElementById('optionsContainer').children.length;
    const el = document.getElementById('optionsCount');
    if(el) el.textContent = n+(n===1?' option':' options');
}

/* ───────────────────────────────────────────────────────────
   IMAGE OPTIONS
─────────────────────────────────────────────────────────── */
function addImageOption(){
    const container = document.getElementById('imageOptionsContainer');
    const index = container.children.length;
    const div = document.createElement('div');
    div.className='img-opt-row'; div.dataset.index=index;
    div.innerHTML=`
        <div class="d-flex align-items-start gap-3">
            <div>
                <input type="file" name="options[${index}][image]" id="imgFile${index}" accept="image/*" style="display:none;" onchange="previewImg(this,'imgPrev${index}')">
                <div class="img-preview-box" id="imgPrev${index}" onclick="document.getElementById('imgFile${index}').click()">
                    <i class="fas fa-cloud-upload-alt"></i><span>Click to upload</span>
                </div>
            </div>
            <div class="flex-grow-1">
                <input type="text" name="options[${index}][text]" class="form-control mb-2" placeholder="Label / Alt text">
                <label class="correct-lbl"><input type="checkbox" name="options[${index}][is_correct]" value="1"> Correct Answer</label>
            </div>
            <button type="button" class="remove-btn" onclick="removeImageOption(this)"><i class="fas fa-times"></i></button>
        </div>`;
    container.appendChild(div);
    _updateImgCount();
}

function removeImageOption(btn){
    const c=document.getElementById('imageOptionsContainer');
    if(c.children.length<=1){alert('Need at least one image option');return;}
    btn.closest('.img-opt-row').remove();
    _reindexImgOptions();
    _updateImgCount();
}

function _reindexImgOptions(){
    document.querySelectorAll('#imageOptionsContainer .img-opt-row').forEach((row,i)=>{
        row.dataset.index=i;
        const file=row.querySelector('input[type=file]');
        if(file){file.name=`options[${i}][image]`;file.id=`imgFile${i}`;file.setAttribute('onchange',`previewImg(this,'imgPrev${i}')`);}
        const box=row.querySelector('.img-preview-box');
        if(box){box.id=`imgPrev${i}`;box.setAttribute('onclick',`document.getElementById('imgFile${i}').click()`);}
        const txt=row.querySelector('input[type=text]');
        if(txt)txt.name=`options[${i}][text]`;
        const chk=row.querySelector('input[type=checkbox]');
        if(chk)chk.name=`options[${i}][is_correct]`;
    });
}

function _updateImgCount(){
    const n=document.getElementById('imageOptionsContainer').children.length;
    const el=document.getElementById('imageOptionsCount');
    if(el)el.textContent=n+(n===1?' image':' images');
}

function previewImg(input, previewId){
    if(!input.files||!input.files[0])return;
    const reader=new FileReader();
    reader.onload=e=>{
        const box=document.getElementById(previewId);
        if(box)box.innerHTML=`<img src="${e.target.result}">`;
    };
    reader.readAsDataURL(input.files[0]);
}

/* ───────────────────────────────────────────────────────────
   FILL BLANK
─────────────────────────────────────────────────────────── */
function addFillBlank(){
    const container=document.getElementById('fillBlanksContainer');
    const i=container.children.length;
    const row=document.createElement('div');
    row.className='blank-row';row.dataset.index=i;
    row.innerHTML=`
        <i class="fas fa-pencil-alt text-muted"></i>
        <input type="text" name="fill_blanks[${i}][answer]" placeholder="Correct answer" required>
        <label class="correct-lbl"><input type="checkbox" name="fill_blanks[${i}][case_sensitive]" value="1"> Case Sensitive</label>
        <button type="button" class="remove-btn" onclick="removeBlank(this)"><i class="fas fa-times"></i></button>`;
    container.appendChild(row);
    _updateBlankCount();
}

function removeBlank(btn){
    const c=document.getElementById('fillBlanksContainer');
    if(c.children.length<=1){alert('Need at least one answer');return;}
    btn.closest('.blank-row').remove();
    _reindexBlanks();
    _updateBlankCount();
}

function _reindexBlanks(){
    document.querySelectorAll('#fillBlanksContainer .blank-row').forEach((row,i)=>{
        row.dataset.index=i;
        const txt=row.querySelector('input[type=text]');if(txt)txt.name=`fill_blanks[${i}][answer]`;
        const chk=row.querySelector('input[type=checkbox]');if(chk)chk.name=`fill_blanks[${i}][case_sensitive]`;
    });
}

function _updateBlankCount(){
    const n=document.getElementById('fillBlanksContainer').children.length;
    const el=document.getElementById('blanksCount');
    if(el)el.textContent=n+(n===1?' answer':' answers');
}

/* ───────────────────────────────────────────────────────────
   MATCHING
─────────────────────────────────────────────────────────── */
function addMatchingPair(){
    const container=document.getElementById('matchingPairsContainer');
    const i=container.children.length;
    const row=document.createElement('div');
    row.className='match-row';row.dataset.index=i;
    row.innerHTML=`
        <i class="fas fa-grip-vertical text-muted"></i>
        <input type="text" name="matching_pairs[${i}][left]" placeholder="Left item" required>
        <i class="fas fa-long-arrow-alt-right match-arrow"></i>
        <input type="text" name="matching_pairs[${i}][right]" placeholder="Right item" required>
        <button type="button" class="remove-btn" onclick="removeMatchingPair(this)"><i class="fas fa-times"></i></button>`;
    container.appendChild(row);
    _updateMatchCount();
}

function removeMatchingPair(btn){
    const c=document.getElementById('matchingPairsContainer');
    if(c.children.length<=1){alert('Need at least one pair');return;}
    btn.closest('.match-row').remove();
    _reindexMatching();
    _updateMatchCount();
}

function _reindexMatching(){
    document.querySelectorAll('#matchingPairsContainer .match-row').forEach((row,i)=>{
        row.dataset.index=i;
        const inputs=row.querySelectorAll('input[type=text]');
        if(inputs[0])inputs[0].name=`matching_pairs[${i}][left]`;
        if(inputs[1])inputs[1].name=`matching_pairs[${i}][right]`;
    });
}

function _updateMatchCount(){
    const n=document.getElementById('matchingPairsContainer').children.length;
    const el=document.getElementById('matchingCount');
    if(el)el.textContent=n+(n===1?' pair':' pairs');
}

/* ───────────────────────────────────────────────────────────
   ADD FORM AJAX SUBMIT
─────────────────────────────────────────────────────────── */
function setupAjaxForm(){
    document.getElementById('questionForm').addEventListener('submit',function(e){
        e.preventDefault();
        const type = document.getElementById('questionType').value;
        const formData = new FormData(this);

        // Convert radio "correct_option" → per-option is_correct flags
        if(type==='single_choice'||type==='true_false'){
            const correct = parseInt(formData.get('correct_option')??'-1');
            formData.delete('correct_option');
            document.querySelectorAll('#optionsContainer .opt-row').forEach((_,i)=>{
                formData.set(`options[${i}][is_correct]`, i===correct?'1':'0');
            });
        }

        const btn=document.getElementById('submitBtn');
        btn.disabled=true; btn.innerHTML='<i class="fas fa-spinner fa-spin me-2"></i>Saving...';

        fetch(this.action,{
            method:'POST', body:formData,
            headers:{'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':csrfToken()}
        })
        .then(r=>r.json())
        .then(data=>{
            if(data.success){
                showNotification('Question added successfully!','success');
                this.reset();
                document.getElementById('optionsContainer').innerHTML='';
                document.getElementById('questionType').value='multiple_choice';
                handleTypeChange('multiple_choice');
                setTimeout(()=>location.reload(),1000);
            } else {
                const errList=document.getElementById('errorList');
                errList.innerHTML='';
                const errs=data.errors||{};
                Object.values(errs).flat().forEach(msg=>{
                    const li=document.createElement('li');li.textContent=msg;errList.appendChild(li);
                });
                if(!Object.keys(errs).length){
                    const li=document.createElement('li');li.textContent=data.message||'An error occurred';errList.appendChild(li);
                }
                const ec=document.getElementById('errorContainer');
                ec.style.display='block';ec.scrollIntoView({behavior:'smooth'});
            }
        })
        .catch(()=>showNotification('An error occurred. Please try again.','danger'))
        .finally(()=>{btn.disabled=false;btn.innerHTML='<i class="fas fa-plus-circle me-2"></i>Add Question';});
    });
}

/* ───────────────────────────────────────────────────────────
   DELETE QUESTION
─────────────────────────────────────────────────────────── */
function deleteQuestion(id){
    if(!confirm('Delete this question? This cannot be undone.'))return;
    const form=document.getElementById('deleteForm');
    form.action='/admin/progressive-questions/'+id;
    form.submit();
}

/* ───────────────────────────────────────────────────────────
   REORDER QUESTIONS
─────────────────────────────────────────────────────────── */
function updateQuestionsOrder(){
    const items=document.querySelectorAll('#questionsList .question-card');
    const data=[];
    items.forEach((el,i)=>data.push({id:el.dataset.id,sort_order:i+1}));
    fetch('/admin/progressive-questions/reorder',{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken()},
        body:JSON.stringify({questions:data})
    }).then(r=>r.json()).then(d=>{if(d.success)showNotification('Reordered','success');});
}

/* ───────────────────────────────────────────────────────────
   EDIT QUESTION MODAL
─────────────────────────────────────────────────────────── */
function editQuestion(id){
    currentEditId=id;
    editModalInstance=new bootstrap.Modal(document.getElementById('editQuestionModal'));
    document.getElementById('editQuestionContent').innerHTML=
        '<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>';
    editModalInstance.show();

    fetch('/admin/progressive-questions/'+id+'/edit',{
        headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}
    })
    .then(r=>r.json())
    .then(q=>_buildEditForm(q))
    .catch(()=>{
        document.getElementById('editQuestionContent').innerHTML=
            '<div class="alert alert-danger">Error loading question data.</div>';
    });
}

function _buildEditForm(q){
    const types=[['multiple_choice','Multiple Choice'],['single_choice','Single Choice'],
                 ['true_false','True / False'],['fill_blank','Fill in the Blank'],
                 ['matching','Matching'],['image_selection','Image Selection']];
    const typeOpts=types.map(([v,l])=>
        `<option value="${v}" ${q.question_type===v?'selected':''}>${l}</option>`).join('');

    const currentImgHtml = q.image
        ? `<div class="mt-2 border rounded p-2 d-inline-block">
               <img src="/storage/${escH(q.image)}" class="img-thumbnail" style="max-height:80px;">
               <div class="small text-muted mt-1">Current image — upload new to replace</div>
           </div>`
        : '<div class="text-muted small mt-1">No image</div>';

    document.getElementById('editQuestionContent').innerHTML=`
    <form id="editQForm" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="${csrfToken()}">
        <input type="hidden" name="_method" value="PUT">

        <div class="mb-3">
            <label class="form-label fw-medium">Question Type</label>
            <select name="question_type" class="form-select" id="editQType"
                    onchange="rebuildEditAnswers(this.value)">
                ${typeOpts}
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">Question Text</label>
            <textarea name="question_text" class="form-control" rows="3" required>${escH(q.question_text)}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">Explanation</label>
            <textarea name="explanation" class="form-control" rows="2">${escH(q.explanation||'')}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-medium">Points</label>
                <input type="number" name="points" class="form-control" value="${q.points||1}" min="1">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">Question Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                ${currentImgHtml}
            </div>
        </div>

        <div id="editAnswerZone"></div>

        <div class="text-end mt-3">
            <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="editSaveBtn">Update Question</button>
        </div>
    </form>`;

    // Store question data on the modal so type-change can rebuild
    document.getElementById('editQuestionModal').dataset.q = JSON.stringify(q);

    // Build initial answer section
    rebuildEditAnswers(q.question_type);

    // Submit handler
    document.getElementById('editQForm').addEventListener('submit',function(e){
        e.preventDefault();
        const type=document.getElementById('editQType').value;
        let formData=new FormData(this);

        // Convert radio → per-option flags for edit modal
        if(type==='single_choice'||type==='true_false'){
            const correct=parseInt(formData.get('edit_correct_option')??'-1');
            formData.delete('edit_correct_option');
            document.querySelectorAll('#editOptContainer .edit-opt-row').forEach((_,i)=>{
                formData.set(`options[${i}][is_correct]`, i===correct?'1':'0');
            });
        }

        const btn=document.getElementById('editSaveBtn');
        btn.disabled=true;btn.innerHTML='<i class="fas fa-spinner fa-spin me-1"></i>Updating...';

        fetch('/admin/progressive-questions/'+currentEditId,{
            method:'POST',body:formData,
            headers:{'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':csrfToken()}
        })
        .then(r=>r.json())
        .then(data=>{
            if(data.success){
                editModalInstance.hide();
                showNotification('Question updated successfully','success');
                setTimeout(()=>location.reload(),1200);
            } else {
                showNotification('Error updating question','danger');
                btn.disabled=false;btn.innerHTML='Update Question';
            }
        })
        .catch(()=>{
            showNotification('Error updating question','danger');
            btn.disabled=false;btn.innerHTML='Update Question';
        });
    });
}

/* Rebuild edit answer section when type changes */
function rebuildEditAnswers(type){
    // Get stored question data
    const qRaw = document.getElementById('editQuestionModal').dataset.q;
    const q = qRaw ? JSON.parse(qRaw) : {};
    const zone = document.getElementById('editAnswerZone');
    zone.innerHTML = '';

    if(type==='fill_blank'){
        zone.innerHTML = _editBlanksHtml(q.fill_blanks||[]);
    } else if(type==='matching'){
        zone.innerHTML = _editMatchingHtml(q.matching_pairs||[]);
    } else if(type==='image_selection'){
        zone.innerHTML = _editImgOptsHtml(q.options||[]);
    } else {
        zone.innerHTML = _editOptsHtml(type, q.options||[]);
    }
}

/* ── Edit: standard options ── */
function _editOptsHtml(type, options){
    const isTF = type==='true_false';
    const isMC = type==='multiple_choice';

    let opts = options;
    if(isTF) opts=[
        {option_text:'True',  is_correct:options[0]?.is_correct||false},
        {option_text:'False', is_correct:options[1]?.is_correct||false}
    ];

    let correctIdx = -1;
    if(!isMC && !isTF) opts.forEach((o,i)=>{ if(o.is_correct) correctIdx=i; });

    const rows = opts.map((opt,i)=>{
        const correctCtrl = isMC
            ? `<label class="correct-lbl"><input type="checkbox" name="options[${i}][is_correct]" value="1" class="e-chk" ${opt.is_correct?'checked':''}> Correct</label>`
            : `<label class="correct-lbl"><input type="radio" name="edit_correct_option" value="${i}" class="e-chk" ${(isTF?opt.is_correct:correctIdx===i)?'checked':''}> Correct</label>`;
        const hint=isTF?'Select the correct answer.':(isMC?'Check all correct answers.':'Select the one correct answer.');
        const readonly=isTF?'readonly':'';
        const req=isTF?'':'required';
        const removable=!isTF;
        return `<div class="opt-row edit-opt-row" data-index="${i}">
            <span class="opt-letter">${letter(i)}</span>
            <input type="text" name="options[${i}][text]" value="${escH(opt.option_text)}" placeholder="Option ${i+1}" ${readonly} ${req}>
            ${correctCtrl}
            ${removable?`<button type="button" class="remove-btn" onclick="removeEditOpt(this)"><i class="fas fa-times"></i></button>`:''}
        </div>`;
    }).join('');

    const hint=isTF?'Select the correct answer.':(isMC?'Check all correct answers.':'Select the one correct answer.');
    const addBtn=isTF?'':
        `<button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addEditOpt('${type}')">
            <i class="fas fa-plus me-1"></i>Add Option
        </button>`;

    return `<div class="mb-3">
        <label class="form-label fw-medium"><i class="fas fa-list-ul me-2"></i>Answer Options</label>
        <small class="text-muted d-block mb-2">${hint}</small>
        <div id="editOptContainer">${rows}</div>
        ${addBtn}
    </div>`;
}

function addEditOpt(type){
    const c=document.getElementById('editOptContainer');
    const i=c.querySelectorAll('.edit-opt-row').length;
    const isMC=type==='multiple_choice';
    const ctrl=isMC
        ?`<label class="correct-lbl"><input type="checkbox" name="options[${i}][is_correct]" value="1" class="e-chk"> Correct</label>`
        :`<label class="correct-lbl"><input type="radio" name="edit_correct_option" value="${i}" class="e-chk"> Correct</label>`;
    const row=document.createElement('div');
    row.className='opt-row edit-opt-row';row.dataset.index=i;
    row.innerHTML=`
        <span class="opt-letter">${letter(i)}</span>
        <input type="text" name="options[${i}][text]" placeholder="Option ${i+1}" required>
        ${ctrl}
        <button type="button" class="remove-btn" onclick="removeEditOpt(this)"><i class="fas fa-times"></i></button>`;
    c.appendChild(row);
    _reindexEditOpts(type);
}

function removeEditOpt(btn){
    const c=document.getElementById('editOptContainer');
    if(c.querySelectorAll('.edit-opt-row').length<=1){alert('Need at least one option');return;}
    btn.closest('.edit-opt-row').remove();
    _reindexEditOpts(document.getElementById('editQType').value);
}

function _reindexEditOpts(type){
    const isMC=type==='multiple_choice';
    document.querySelectorAll('#editOptContainer .edit-opt-row').forEach((row,i)=>{
        row.dataset.index=i;
        const l=row.querySelector('.opt-letter');if(l)l.textContent=letter(i);
        const txt=row.querySelector('input[type=text]');
        if(txt){txt.name=`options[${i}][text]`;txt.placeholder=`Option ${i+1}`;}
        const chk=row.querySelector('.e-chk');
        if(chk){
            if(isMC){chk.type='checkbox';chk.name=`options[${i}][is_correct]`;chk.value='1';}
            else{chk.type='radio';chk.name='edit_correct_option';chk.value=i;}
        }
    });
}

/* ── Edit: image options — KEY FIX: existing_image hidden field preserved ── */
function _editImgOptsHtml(options){
    const rows=options.map((opt,i)=>{
        const preview = opt.image
            ? `<img src="/storage/${escH(opt.image)}">`
            : `<i class="fas fa-cloud-upload-alt"></i><span>Click to upload</span>`;
        return `<div class="img-opt-row e-img-row" data-index="${i}">
            <div class="d-flex align-items-start gap-3">
                <div>
                    <input type="file" name="options[${i}][image]" id="eImgFile${i}" accept="image/*"
                           style="display:none;" onchange="previewEditImg(this,'eImgPrev${i}')">
                    <input type="hidden" name="options[${i}][existing_image]" value="${escH(opt.image||'')}">
                    <div class="img-preview-box" id="eImgPrev${i}"
                         onclick="document.getElementById('eImgFile${i}').click()">${preview}</div>
                </div>
                <div class="flex-grow-1">
                    <input type="text" name="options[${i}][text]" class="form-control mb-2"
                           placeholder="Label / Alt text" value="${escH(opt.option_text||'')}">
                    <label class="correct-lbl">
                        <input type="checkbox" name="options[${i}][is_correct]" value="1" ${opt.is_correct?'checked':''}> Correct
                    </label>
                </div>
                <button type="button" class="remove-btn" onclick="removeEditImgOpt(this)"><i class="fas fa-times"></i></button>
            </div>
        </div>`;
    }).join('');

    return `<div class="mb-3">
        <label class="form-label fw-medium"><i class="fas fa-images me-2"></i>Image Options</label>
        <div id="editImgOptContainer">${rows}</div>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addEditImgOpt()">
            <i class="fas fa-plus me-1"></i>Add Image
        </button>
    </div>`;
}

function previewEditImg(input, previewId){
    if(!input.files||!input.files[0])return;
    const reader=new FileReader();
    reader.onload=e=>{
        const box=document.getElementById(previewId);
        if(box)box.innerHTML=`<img src="${e.target.result}">`;
    };
    reader.readAsDataURL(input.files[0]);
}

function addEditImgOpt(){
    const c=document.getElementById('editImgOptContainer');
    const i=c.querySelectorAll('.e-img-row').length;
    const div=document.createElement('div');
    div.className='img-opt-row e-img-row';div.dataset.index=i;
    div.innerHTML=`<div class="d-flex align-items-start gap-3">
        <div>
            <input type="file" name="options[${i}][image]" id="eImgFile${i}" accept="image/*"
                   style="display:none;" onchange="previewEditImg(this,'eImgPrev${i}')">
            <input type="hidden" name="options[${i}][existing_image]" value="">
            <div class="img-preview-box" id="eImgPrev${i}" onclick="document.getElementById('eImgFile${i}').click()">
                <i class="fas fa-cloud-upload-alt"></i><span>Click to upload</span>
            </div>
        </div>
        <div class="flex-grow-1">
            <input type="text" name="options[${i}][text]" class="form-control mb-2" placeholder="Label / Alt text">
            <label class="correct-lbl"><input type="checkbox" name="options[${i}][is_correct]" value="1"> Correct</label>
        </div>
        <button type="button" class="remove-btn" onclick="removeEditImgOpt(this)"><i class="fas fa-times"></i></button>
    </div>`;
    c.appendChild(div);_reindexEditImgOpts();
}

function removeEditImgOpt(btn){
    const c=document.getElementById('editImgOptContainer');
    if(c.querySelectorAll('.e-img-row').length<=1){alert('Need at least one image option');return;}
    btn.closest('.e-img-row').remove();_reindexEditImgOpts();
}

function _reindexEditImgOpts(){
    document.querySelectorAll('#editImgOptContainer .e-img-row').forEach((row,i)=>{
        row.dataset.index=i;
        const file=row.querySelector('input[type=file]');
        if(file){file.name=`options[${i}][image]`;file.id=`eImgFile${i}`;file.setAttribute('onchange',`previewEditImg(this,'eImgPrev${i}')`);}
        const hidden=row.querySelector('input[type=hidden]');
        if(hidden)hidden.name=`options[${i}][existing_image]`;
        const box=row.querySelector('.img-preview-box');
        if(box){box.id=`eImgPrev${i}`;box.setAttribute('onclick',`document.getElementById('eImgFile${i}').click()`);}
        const txt=row.querySelector('input[type=text]');if(txt)txt.name=`options[${i}][text]`;
        const chk=row.querySelector('input[type=checkbox]');if(chk)chk.name=`options[${i}][is_correct]`;
    });
}

/* ── Edit: fill blanks ── */
function _editBlanksHtml(blanks){
    if(!blanks.length) blanks=[{correct_answer:'',case_sensitive:false}];
    const rows=blanks.map((b,i)=>`
        <div class="blank-row e-blank-row" data-index="${i}">
            <i class="fas fa-pencil-alt text-muted"></i>
            <input type="text" name="fill_blanks[${i}][answer]" class="form-control"
                   value="${escH(b.correct_answer||b.answer||'')}" placeholder="Correct answer" required>
            <label class="correct-lbl">
                <input type="checkbox" name="fill_blanks[${i}][case_sensitive]" value="1" ${b.case_sensitive?'checked':''}> Case Sensitive
            </label>
            <button type="button" class="remove-btn" onclick="removeEditBlank(this)"><i class="fas fa-times"></i></button>
        </div>`).join('');
    return `<div class="mb-3">
        <label class="form-label fw-medium"><i class="fas fa-pencil-alt me-2"></i>Accepted Answers</label>
        <div id="editBlanksContainer">${rows}</div>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addEditBlank()"><i class="fas fa-plus me-1"></i>Add Answer</button>
    </div>`;
}

function addEditBlank(){
    const c=document.getElementById('editBlanksContainer');
    const i=c.querySelectorAll('.e-blank-row').length;
    const row=document.createElement('div');
    row.className='blank-row e-blank-row';row.dataset.index=i;
    row.innerHTML=`
        <i class="fas fa-pencil-alt text-muted"></i>
        <input type="text" name="fill_blanks[${i}][answer]" placeholder="Correct answer" required>
        <label class="correct-lbl"><input type="checkbox" name="fill_blanks[${i}][case_sensitive]" value="1"> Case Sensitive</label>
        <button type="button" class="remove-btn" onclick="removeEditBlank(this)"><i class="fas fa-times"></i></button>`;
    c.appendChild(row);
}

function removeEditBlank(btn){
    const c=document.getElementById('editBlanksContainer');
    if(c.querySelectorAll('.e-blank-row').length<=1){alert('Need at least one answer');return;}
    btn.closest('.e-blank-row').remove();_reindexEditBlanks();
}

function _reindexEditBlanks(){
    document.querySelectorAll('#editBlanksContainer .e-blank-row').forEach((row,i)=>{
        row.dataset.index=i;
        const txt=row.querySelector('input[type=text]');if(txt)txt.name=`fill_blanks[${i}][answer]`;
        const chk=row.querySelector('input[type=checkbox]');if(chk)chk.name=`fill_blanks[${i}][case_sensitive]`;
    });
}

/* ── Edit: matching ── */
function _editMatchingHtml(pairs){
    if(!pairs.length) pairs=[{left_item:'',right_item:''},{left_item:'',right_item:''}];
    const rows=pairs.map((p,i)=>`
        <div class="match-row e-match-row" data-index="${i}">
            <i class="fas fa-grip-vertical text-muted"></i>
            <input type="text" name="matching_pairs[${i}][left]" class="form-control"
                   value="${escH(p.left_item||p.left||'')}" placeholder="Left item" required>
            <i class="fas fa-long-arrow-alt-right match-arrow"></i>
            <input type="text" name="matching_pairs[${i}][right]" class="form-control"
                   value="${escH(p.right_item||p.right||'')}" placeholder="Right item" required>
            <button type="button" class="remove-btn" onclick="removeEditPair(this)"><i class="fas fa-times"></i></button>
        </div>`).join('');
    return `<div class="mb-3">
        <label class="form-label fw-medium"><i class="fas fa-link me-2"></i>Matching Pairs</label>
        <div id="editMatchContainer">${rows}</div>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addEditPair()"><i class="fas fa-plus me-1"></i>Add Pair</button>
    </div>`;
}

function addEditPair(){
    const c=document.getElementById('editMatchContainer');
    const i=c.querySelectorAll('.e-match-row').length;
    const row=document.createElement('div');
    row.className='match-row e-match-row';row.dataset.index=i;
    row.innerHTML=`
        <i class="fas fa-grip-vertical text-muted"></i>
        <input type="text" name="matching_pairs[${i}][left]" class="form-control" placeholder="Left item" required>
        <i class="fas fa-long-arrow-alt-right match-arrow"></i>
        <input type="text" name="matching_pairs[${i}][right]" class="form-control" placeholder="Right item" required>
        <button type="button" class="remove-btn" onclick="removeEditPair(this)"><i class="fas fa-times"></i></button>`;
    c.appendChild(row);
}

function removeEditPair(btn){
    const c=document.getElementById('editMatchContainer');
    if(c.querySelectorAll('.e-match-row').length<=1){alert('Need at least one pair');return;}
    btn.closest('.e-match-row').remove();_reindexEditMatching();
}

function _reindexEditMatching(){
    document.querySelectorAll('#editMatchContainer .e-match-row').forEach((row,i)=>{
        row.dataset.index=i;
        const inputs=row.querySelectorAll('input[type=text]');
        if(inputs[0])inputs[0].name=`matching_pairs[${i}][left]`;
        if(inputs[1])inputs[1].name=`matching_pairs[${i}][right]`;
    });
}

/* ───────────────────────────────────────────────────────────
   NOTIFICATION
─────────────────────────────────────────────────────────── */
function showNotification(message, type='success'){
    const n=document.createElement('div');
    n.className=`alert alert-${type} alert-dismissible fade show position-fixed`;
    n.style.cssText='top:20px;right:20px;z-index:9999;min-width:300px;';
    n.innerHTML=`<div class="d-flex align-items-center">
        <i class="fas ${type==='success'?'fa-check-circle':'fa-exclamation-circle'} me-2"></i>
        <span>${message}</span></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.body.appendChild(n);
    setTimeout(()=>{n.classList.remove('show');setTimeout(()=>n.remove(),300);},3000);
}

/* ───────────────────────────────────────────────────────────
   INIT
─────────────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded',function(){
    // Build initial add-form state
    handleTypeChange('multiple_choice');
    // Pre-fill image selection with 2 slots
    addImageOption(); addImageOption();
    // Pre-fill blanks / matching
    addFillBlank();
    addMatchingPair(); addMatchingPair();

    setupAjaxForm();

    // Sortable questions
    const ql=document.getElementById('questionsList');
    if(ql) new Sortable(ql,{handle:'.question-drag-handle',animation:150,
        ghostClass:'sortable-ghost',onEnd:updateQuestionsOrder});

    // Auto-hide page alerts
    setTimeout(()=>{
        document.querySelectorAll('.alert:not(.position-fixed)').forEach(a=>{
            try{new bootstrap.Alert(a).close();}catch(e){}
        });
    },5000);
});
</script>
@endpush