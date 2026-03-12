<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgressiveQuiz;
use App\Models\ProgressiveLevel;
use App\Models\ProgressiveQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProgressiveQuizController extends Controller
{
    /**
     * Display a listing of progressive quizzes.
     */
    public function index()
    {
        $quizzes = ProgressiveQuiz::with(['creator', 'levels'])
            ->latest()
            ->paginate(15);
            
        return view('admin.progressive-quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new progressive quiz.
     */
    public function create()
    {
        return view('admin.progressive-quizzes.create');
    }

    /**
     * Store a newly created progressive quiz in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'featured_image' => 'nullable|image|max:2048',
            'time_limit' => 'nullable|integer|min:1',
            'attempts_allowed' => 'integer|min:0',
            'pass_percentage' => 'integer|between:0,100',
            'shuffle_questions' => 'nullable|boolean',
            'show_results' => 'nullable|boolean',
            'show_answers' => 'nullable|boolean',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Set default values for checkboxes
        $validated['shuffle_questions'] = $request->has('shuffle_questions') ? 1 : 0;
        $validated['show_results'] = $request->has('show_results') ? 1 : 0;
        $validated['show_answers'] = $request->has('show_answers') ? 1 : 0;

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = auth()->id();

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('progressive-quizzes', 'public');
        }

        $quiz = ProgressiveQuiz::create($validated);

        // Create default first level
        ProgressiveLevel::create([
            'progressive_quiz_id' => $quiz->id,
            'level_number' => 1,
            'title' => 'Level 1',
            'description' => 'Begin your journey',
            'question_count' => 0,
            'pass_required' => true,
            'min_percentage' => $quiz->pass_percentage,
            'sort_order' => 0
        ]);

        $quiz->updateCounts();

        return redirect()->route('admin.progressive-quizzes.levels', $quiz)
            ->with('success', 'Progressive quiz created successfully. Now configure your levels.');
    }

    /**
     * Show the form for editing the specified progressive quiz.
     */
    public function edit(ProgressiveQuiz $progressiveQuiz)
    {
        return view('admin.progressive-quizzes.edit', compact('progressiveQuiz'));
    }

    /**
     * Update the specified progressive quiz in storage.
     */
    public function update(Request $request, ProgressiveQuiz $progressiveQuiz)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'featured_image' => 'nullable|image|max:2048',
            'time_limit' => 'nullable|integer|min:1',
            'attempts_allowed' => 'integer|min:0',
            'pass_percentage' => 'integer|between:0,100',
            'shuffle_questions' => 'nullable|boolean',
            'show_results' => 'nullable|boolean',
            'show_answers' => 'nullable|boolean',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Set default values for checkboxes
        $validated['shuffle_questions'] = $request->has('shuffle_questions') ? 1 : 0;
        $validated['show_results'] = $request->has('show_results') ? 1 : 0;
        $validated['show_answers'] = $request->has('show_answers') ? 1 : 0;

        $validated['slug'] = Str::slug($validated['title']);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($progressiveQuiz->featured_image) {
                Storage::disk('public')->delete($progressiveQuiz->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('progressive-quizzes', 'public');
        }

        $progressiveQuiz->update($validated);

        return redirect()->route('admin.progressive-quizzes.index')
            ->with('success', 'Progressive quiz updated successfully');
    }

    /**
     * Remove the specified progressive quiz from storage.
     */
    public function destroy(ProgressiveQuiz $progressiveQuiz)
    {
        // Delete featured image
        if ($progressiveQuiz->featured_image) {
            Storage::disk('public')->delete($progressiveQuiz->featured_image);
        }

        $progressiveQuiz->delete();

        return redirect()->route('admin.progressive-quizzes.index')
            ->with('success', 'Progressive quiz deleted successfully');
    }

    /**
     * Manage levels for a progressive quiz.
     */
    public function levels(ProgressiveQuiz $progressiveQuiz)
    {
        $progressiveQuiz->load('levels');
        return view('admin.progressive-quizzes.levels', compact('progressiveQuiz'));
    }

    /**
     * Store a new level.
     */
    public function storeLevel(Request $request, ProgressiveQuiz $progressiveQuiz)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'min_percentage' => 'nullable|integer|between:0,100',
            'time_limit' => 'nullable|integer|min:1',
            'pass_required' => 'nullable|boolean',
            'unlock_message' => 'nullable|max:255',
            'badge_icon' => 'nullable|image|max:2048',
        ]);

        $nextLevelNumber = $progressiveQuiz->levels()->max('level_number') + 1;

        $levelData = [
            'progressive_quiz_id' => $progressiveQuiz->id,
            'level_number' => $nextLevelNumber,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'min_percentage' => $validated['min_percentage'] ?? $progressiveQuiz->pass_percentage,
            'time_limit' => $validated['time_limit'] ?? null,
            'pass_required' => $request->has('pass_required'),
            'unlock_message' => $validated['unlock_message'] ?? null,
            'sort_order' => $nextLevelNumber - 1,
        ];

        // Handle badge icon
        if ($request->hasFile('badge_icon')) {
            $levelData['badge_icon'] = $request->file('badge_icon')
                ->store('progressive-levels', 'public');
        }

        ProgressiveLevel::create($levelData);
        $progressiveQuiz->updateCounts();

        return redirect()->back()->with('success', 'Level added successfully');
    }

    /**
     * Update a level.
     */
    public function updateLevel(Request $request, ProgressiveLevel $progressiveLevel)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'min_percentage' => 'nullable|integer|between:0,100',
            'time_limit' => 'nullable|integer|min:1',
            'pass_required' => 'nullable|boolean',
            'unlock_message' => 'nullable|max:255',
            'badge_icon' => 'nullable|image|max:2048',
        ]);

        $levelData = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'min_percentage' => $validated['min_percentage'] ?? $progressiveLevel->quiz->pass_percentage,
            'time_limit' => $validated['time_limit'] ?? null,
            'pass_required' => $request->has('pass_required'),
            'unlock_message' => $validated['unlock_message'] ?? null,
        ];

        // Handle badge icon
        if ($request->hasFile('badge_icon')) {
            // Delete old icon
            if ($progressiveLevel->badge_icon) {
                Storage::disk('public')->delete($progressiveLevel->badge_icon);
            }
            $levelData['badge_icon'] = $request->file('badge_icon')
                ->store('progressive-levels', 'public');
        }

        $progressiveLevel->update($levelData);

        return redirect()->back()->with('success', 'Level updated successfully');
    }

    /**
     * Delete a level.
     */
    public function destroyLevel(ProgressiveLevel $progressiveLevel)
    {
        // Don't allow deleting the last level
        if ($progressiveLevel->quiz->levels()->count() <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the last level');
        }

        // Delete badge icon
        if ($progressiveLevel->badge_icon) {
            Storage::disk('public')->delete($progressiveLevel->badge_icon);
        }

        $progressiveLevel->delete();
        $progressiveLevel->quiz->updateCounts();

        // Renumber remaining levels
        $levels = $progressiveLevel->quiz->levels()->orderBy('level_number')->get();
        foreach ($levels as $index => $level) {
            $level->update(['level_number' => $index + 1]);
        }

        return redirect()->back()->with('success', 'Level deleted successfully');
    }

    /**
     * Manage questions for a level.
     */
    public function questions($progressiveQuizId, $progressiveLevelId)
    {
        $progressiveLevel = ProgressiveLevel::with([
            'questions' => function($query) {
                $query->orderBy('sort_order');
            },
            'questions.options' => function($query) {
                $query->orderBy('sort_order');
            },
            'questions.fillBlanks' => function($query) {
                $query->orderBy('sort_order');
            },
            'questions.matchingPairs' => function($query) {
                $query->orderBy('sort_order');
            }
        ])->findOrFail($progressiveLevelId);
        
        // Verify that the level belongs to the quiz
        if ($progressiveLevel->progressive_quiz_id != $progressiveQuizId) {
            abort(404, 'Level does not belong to this quiz');
        }
        
        return view('admin.progressive-quizzes.questions', compact('progressiveLevel'));
    }

    /**
     * Get question data for editing.
     */
    public function editQuestion(ProgressiveQuestion $progressiveQuestion)
    {
        $question = $progressiveQuestion->load(['options', 'fillBlanks', 'matchingPairs']);
        
        return response()->json($question);
    }

    /**
     * Store a new question.
     */
    public function storeQuestion(Request $request, $progressiveQuizId, $progressiveLevelId)
    {
        $progressiveLevel = ProgressiveLevel::findOrFail($progressiveLevelId);
        
        // Verify that the level belongs to the quiz
        if ($progressiveLevel->progressive_quiz_id != $progressiveQuizId) {
            abort(404, 'Level does not belong to this quiz');
        }
        
        // Log the incoming request for debugging
        \Log::info('Store Question Request:', [
            'quiz_id' => $progressiveQuizId,
            'level_id' => $progressiveLevelId,
            'question_type' => $request->question_type,
            'options' => $request->input('options'),
            'all_data' => $request->all()
        ]);

        $rules = [
            'question_text' => 'required',
            'question_type' => 'required|in:multiple_choice,single_choice,true_false,fill_blank,matching,image_selection',
            'points' => 'nullable|integer|min:1',
            'explanation' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ];

        // Add conditional validation based on question type
        if (in_array($request->question_type, ['multiple_choice', 'single_choice', 'true_false'])) {
            $rules['options'] = 'required|array';
            $rules['options.*.text'] = 'required|string';
            $rules['options.*.is_correct'] = 'nullable|boolean';
        }

        if ($request->question_type === 'image_selection') {
            $rules['options'] = 'required|array|min:2';
            
            // Dynamically add image validation for each option that doesn't have an existing image
            foreach ($request->input('options', []) as $key => $option) {
                if (!isset($option['existing_image']) || empty($option['existing_image'])) {
                    $rules["options.{$key}.image"] = 'required|image|max:2048';
                }
            }
            
            $rules['options.*.existing_image'] = 'sometimes|string';
            $rules['options.*.text'] = 'nullable|string';
            $rules['options.*.is_correct'] = 'nullable|boolean';
        }

        if ($request->question_type === 'fill_blank') {
            $rules['fill_blanks'] = 'required|array|min:1';
            $rules['fill_blanks.*.answer'] = 'required|string';
            $rules['fill_blanks.*.case_sensitive'] = 'nullable|boolean';
        }

        if ($request->question_type === 'matching') {
            $rules['matching_pairs'] = 'required|array|min:2';
            $rules['matching_pairs.*.left'] = 'required|string';
            $rules['matching_pairs.*.right'] = 'required|string';
        }

        try {
            $validated = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                    'message' => 'Validation failed'
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validation failed');
        }

        $questionData = [
            'progressive_quiz_id' => $progressiveLevel->progressive_quiz_id,
            'progressive_level_id' => $progressiveLevel->id,
            'question_text' => $validated['question_text'],
            'question_type' => $validated['question_type'],
            'points' => $validated['points'] ?? 1,
            'explanation' => $validated['explanation'] ?? null,
            'sort_order' => $progressiveLevel->questions()->count() + 1
        ];

        if ($request->hasFile('image')) {
            $questionData['image'] = $request->file('image')->store('progressive-questions', 'public');
        }

        $question = ProgressiveQuestion::create($questionData);

        // Handle options based on question type
        $this->saveQuestionOptions($question, $validated);

        $progressiveLevel->increment('question_count');
        $progressiveLevel->quiz->increment('total_questions');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Question added successfully',
                'question' => $question->load(['options', 'fillBlanks', 'matchingPairs'])
            ]);
        }

        return redirect()->back()->with('success', 'Question added successfully');
    }

    /**
     * Update a question.
     */
    public function updateQuestion(Request $request, ProgressiveQuestion $progressiveQuestion)
    {
        $rules = [
            'question_text' => 'required',
            'question_type' => 'required|in:multiple_choice,single_choice,true_false,fill_blank,matching,image_selection',
            'points' => 'integer|min:1',
            'explanation' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ];

        // Add conditional validation based on question type
        if (in_array($request->question_type, ['multiple_choice', 'single_choice', 'true_false'])) {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*.text'] = 'required|string';
            $rules['options.*.is_correct'] = 'nullable|boolean';
        }

        if ($request->question_type === 'image_selection') {
            $rules['options'] = 'required|array|min:2';
            
            // Dynamically add image validation for new uploads
            foreach ($request->input('options', []) as $key => $option) {
                if (isset($option['image']) && $option['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $rules["options.{$key}.image"] = 'image|max:2048';
                }
            }
            
            $rules['options.*.existing_image'] = 'sometimes|string';
            $rules['options.*.text'] = 'nullable|string';
            $rules['options.*.is_correct'] = 'nullable|boolean';
        }

        if ($request->question_type === 'fill_blank') {
            $rules['fill_blanks'] = 'required|array|min:1';
            $rules['fill_blanks.*.answer'] = 'required|string';
            $rules['fill_blanks.*.case_sensitive'] = 'nullable|boolean';
        }

        if ($request->question_type === 'matching') {
            $rules['matching_pairs'] = 'required|array|min:2';
            $rules['matching_pairs.*.left'] = 'required|string';
            $rules['matching_pairs.*.right'] = 'required|string';
        }

        try {
            $validated = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validation failed');
        }

        $questionData = [
            'question_text' => $validated['question_text'],
            'question_type' => $validated['question_type'],
            'points' => $validated['points'] ?? 1,
            'explanation' => $validated['explanation'] ?? null,
        ];

        // Handle image
        if ($request->hasFile('image')) {
            if ($progressiveQuestion->image) {
                Storage::disk('public')->delete($progressiveQuestion->image);
            }
            $questionData['image'] = $request->file('image')->store('progressive-questions', 'public');
        }

        $progressiveQuestion->update($questionData);

        // Delete existing related data
        $this->deleteQuestionRelations($progressiveQuestion);

        // Save new options based on question type
        $this->saveQuestionOptions($progressiveQuestion, $validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Question updated successfully',
                'question' => $progressiveQuestion->fresh(['options', 'fillBlanks', 'matchingPairs'])
            ]);
        }

        return redirect()->route('admin.progressive-quizzes.questions', [
            'progressiveQuiz' => $progressiveQuestion->level->quiz->id,
            'progressiveLevel' => $progressiveQuestion->level->id
        ])->with('success', 'Question updated successfully');
    }

    /**
     * Delete a question.
     */
    public function destroyQuestion(ProgressiveQuestion $progressiveQuestion)
    {
        $level = $progressiveQuestion->level;
        $quiz = $progressiveQuestion->quiz;

        // Delete associated files
        if ($progressiveQuestion->image) {
            Storage::disk('public')->delete($progressiveQuestion->image);
        }

        // Delete related data
        $this->deleteQuestionRelations($progressiveQuestion);

        $progressiveQuestion->delete();

        $level->decrement('question_count');
        $quiz->decrement('total_questions');

        return redirect()->back()->with('success', 'Question deleted successfully');
    }

    /**
     * Reorder questions within a level.
     */
    public function reorderQuestions(Request $request)
    {
        $request->validate([
            'questions' => 'required|array',
            'questions.*.id' => 'required|exists:progressive_questions,id',
            'questions.*.sort_order' => 'required|integer|min:1'
        ]);

        foreach ($request->questions as $item) {
            ProgressiveQuestion::where('id', $item['id'])
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Reorder levels.
     */
    public function reorderLevels(Request $request)
    {
        $request->validate([
            'levels' => 'required|array',
            'levels.*.id' => 'required|exists:progressive_levels,id',
            'levels.*.level_number' => 'required|integer|min:1'
        ]);

        foreach ($request->levels as $item) {
            ProgressiveLevel::where('id', $item['id'])
                ->update(['level_number' => $item['level_number']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Helper method to save question options based on type.
     */
    private function saveQuestionOptions($question, $validated)
    {
        if (in_array($validated['question_type'], ['multiple_choice', 'single_choice', 'true_false'])) {
            foreach ($validated['options'] as $index => $optionData) {
                $question->options()->create([
                    'option_text' => $optionData['text'],
                    'is_correct' => isset($optionData['is_correct']) && $optionData['is_correct'] == '1',
                    'sort_order' => $index + 1
                ]);
            }
        }

        if ($validated['question_type'] === 'image_selection') {
            foreach ($validated['options'] as $index => $optionData) {
                $option = [
                    'option_text' => $optionData['text'] ?? 'Image ' . ($index + 1),
                    'is_correct' => isset($optionData['is_correct']) && $optionData['is_correct'] == '1',
                    'sort_order' => $index + 1
                ];

                // Handle image upload
                if (isset($optionData['image']) && $optionData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $option['image'] = $optionData['image']->store('progressive-options', 'public');
                } elseif (isset($optionData['existing_image']) && !empty($optionData['existing_image'])) {
                    // If it's an existing image, just keep the path
                    $option['image'] = $optionData['existing_image'];
                }

                $question->options()->create($option);
            }
        }

        if ($validated['question_type'] === 'fill_blank') {
            foreach ($validated['fill_blanks'] as $index => $blankData) {
                $question->fillBlanks()->create([
                    'correct_answer' => $blankData['answer'],
                    'case_sensitive' => isset($blankData['case_sensitive']) && $blankData['case_sensitive'] == '1',
                    'sort_order' => $index + 1
                ]);
            }
        }

        if ($validated['question_type'] === 'matching') {
            foreach ($validated['matching_pairs'] as $index => $pairData) {
                $question->matchingPairs()->create([
                    'left_item' => $pairData['left'],
                    'right_item' => $pairData['right'],
                    'sort_order' => $index + 1
                ]);
            }
        }
    }

    /**
     * Helper method to delete question relations.
     */
    private function deleteQuestionRelations($question)
    {
        // Delete options and their images
        foreach ($question->options as $option) {
            if ($option->image) {
                Storage::disk('public')->delete($option->image);
            }
        }
        $question->options()->delete();

        // Delete fill blanks
        $question->fillBlanks()->delete();

        // Delete matching pairs
        $question->matchingPairs()->delete();
    }
}