<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with(['course', 'creator'])->latest()->paginate(15);
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $courses = Course::where('status', 'published')->get();
        return view('admin.quizzes.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'course_id' => 'nullable|exists:courses,id',
            'type' => 'required|in:standalone,course,lesson',
            'time_limit' => 'nullable|integer|min:1',
            'attempts_allowed' => 'integer|min:0',
            'pass_percentage' => 'integer|between:0,100',
            'status' => 'required|in:draft,published'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = auth()->id();

        $quiz = Quiz::create($validated);

        return redirect()->route('admin.quizzes.questions', $quiz)
            ->with('success', 'Quiz created successfully. Now add questions.');
    }

    public function edit(Quiz $quiz)
    {
        $courses = Course::where('status', 'published')->get();
        return view('admin.quizzes.edit', compact('quiz', 'courses'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'course_id' => 'nullable|exists:courses,id',
            'type' => 'required|in:standalone,course,lesson',
            'time_limit' => 'nullable|integer|min:1',
            'attempts_allowed' => 'integer|min:0',
            'pass_percentage' => 'integer|between:0,100',
            'status' => 'required|in:draft,published'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz updated successfully');
    }

    public function questions(Quiz $quiz)
    {
        $quiz->load('questions.options', 'questions.fillBlanks', 'questions.matchingPairs');
        return view('admin.quizzes.questions', compact('quiz'));
    }

    public function storeQuestion(Request $request, Quiz $quiz)
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
            $rules['options.*.is_correct'] = 'sometimes|boolean';
        }

        // Fix for image_selection - properly handle validation
        if ($request->question_type === 'image_selection') {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*.image'] = 'required_without:options.*.existing_image|image|max:2048';
            $rules['options.*.existing_image'] = 'sometimes|string';
            $rules['options.*.text'] = 'nullable|string'; // Make text optional for image selection
            $rules['options.*.is_correct'] = 'sometimes|boolean';
        }

        if ($request->question_type === 'fill_blank') {
            $rules['fill_blanks'] = 'required|array|min:1';
            $rules['fill_blanks.*.answer'] = 'required|string';
            $rules['fill_blanks.*.case_sensitive'] = 'sometimes|boolean';
        }

        if ($request->question_type === 'matching') {
            $rules['matching_pairs'] = 'required|array|min:2';
            $rules['matching_pairs.*.left'] = 'required|string';
            $rules['matching_pairs.*.right'] = 'required|string';
        }

        $validated = $request->validate($rules);

        $questionData = [
            'quiz_id' => $quiz->id,
            'question_text' => $validated['question_text'],
            'question_type' => $validated['question_type'],
            'points' => $validated['points'] ?? 1,
            'explanation' => $validated['explanation'] ?? null,
            'sort_order' => $quiz->questions()->count() + 1
        ];

        if ($request->hasFile('image')) {
            $questionData['image'] = $request->file('image')->store('questions', 'public');
        }

        $question = Question::create($questionData);

        // Handle options for multiple choice, single choice, true/false
        if (in_array($validated['question_type'], ['multiple_choice', 'single_choice', 'true_false'])) {
            foreach ($validated['options'] as $index => $optionData) {
                $question->options()->create([
                    'option_text' => $optionData['text'],
                    'is_correct' => isset($optionData['is_correct']),
                    'sort_order' => $index + 1
                ]);
            }
        }

        // Handle image selection options separately
        if ($validated['question_type'] === 'image_selection') {
            foreach ($validated['options'] as $index => $optionData) {
                $option = [
                    'option_text' => $optionData['text'] ?? 'Image ' . ($index + 1), // Default text if not provided
                    'is_correct' => isset($optionData['is_correct']),
                    'sort_order' => $index + 1
                ];

                // Handle option image
                if (isset($optionData['image']) && $optionData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $option['image'] = $optionData['image']->store('question-options', 'public');
                } elseif (isset($optionData['existing_image'])) {
                    $option['image'] = $optionData['existing_image'];
                }

                $question->options()->create($option);
            }
        }

        // Handle fill in the blanks
        if ($validated['question_type'] === 'fill_blank') {
            foreach ($validated['fill_blanks'] as $index => $blankData) {
                $question->fillBlanks()->create([
                    'correct_answer' => $blankData['answer'],
                    'case_sensitive' => isset($blankData['case_sensitive']),
                    'sort_order' => $index + 1
                ]);
            }
        }

        // Handle matching pairs
        if ($validated['question_type'] === 'matching') {
            foreach ($validated['matching_pairs'] as $index => $pairData) {
                $question->matchingPairs()->create([
                    'left_item' => $pairData['left'],
                    'right_item' => $pairData['right'],
                    'sort_order' => $index + 1
                ]);
            }
        }

        $quiz->increment('total_questions');

        return redirect()->back()->with('success', 'Question added successfully');
    }

    public function updateQuestion(Request $request, Question $question)
    {
        // Base validation rules
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
            $rules['options.*.is_correct'] = 'sometimes|boolean';
        }

        // Fix for image_selection
        if ($request->question_type === 'image_selection') {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*.image'] = 'nullable'; // Can be existing or new
            $rules['options.*.existing_image'] = 'sometimes|string';
            $rules['options.*.text'] = 'nullable|string'; // Make text optional
            $rules['options.*.is_correct'] = 'sometimes|boolean';
        }

        if ($request->question_type === 'fill_blank') {
            $rules['fill_blanks'] = 'required|array|min:1';
            $rules['fill_blanks.*.answer'] = 'required|string';
            $rules['fill_blanks.*.case_sensitive'] = 'sometimes|boolean';
        }

        if ($request->question_type === 'matching') {
            $rules['matching_pairs'] = 'required|array|min:2';
            $rules['matching_pairs.*.left'] = 'required|string';
            $rules['matching_pairs.*.right'] = 'required|string';
        }

        $validated = $request->validate($rules);

        // Update question data
        $questionData = [
            'question_text' => $validated['question_text'],
            'question_type' => $validated['question_type'],
            'points' => $validated['points'] ?? 1,
            'explanation' => $validated['explanation'] ?? null,
        ];

        // Handle main question image
        if ($request->hasFile('image')) {
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }
            $questionData['image'] = $request->file('image')->store('questions', 'public');
        }

        $question->update($questionData);

        // Handle options for multiple choice, single choice, true/false
        if (in_array($validated['question_type'], ['multiple_choice', 'single_choice', 'true_false'])) {
            // Delete existing options
            foreach ($question->options as $option) {
                if ($option->image) {
                    Storage::disk('public')->delete($option->image);
                }
            }
            $question->options()->delete();

            // Create new options
            foreach ($validated['options'] as $index => $optionData) {
                $question->options()->create([
                    'option_text' => $optionData['text'],
                    'is_correct' => isset($optionData['is_correct']),
                    'sort_order' => $index + 1
                ]);
            }
        }

        // Handle image selection options
        if ($validated['question_type'] === 'image_selection') {
            // Delete existing options and their images
            foreach ($question->options as $option) {
                if ($option->image) {
                    Storage::disk('public')->delete($option->image);
                }
            }
            $question->options()->delete();

            // Create new options
            foreach ($validated['options'] as $index => $optionData) {
                $option = [
                    'option_text' => $optionData['text'] ?? 'Image ' . ($index + 1), // Default text if not provided
                    'is_correct' => isset($optionData['is_correct']),
                    'sort_order' => $index + 1
                ];

                // Handle option image
                if (isset($optionData['image']) && $optionData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $option['image'] = $optionData['image']->store('question-options', 'public');
                } elseif (isset($optionData['existing_image'])) {
                    $option['image'] = $optionData['existing_image'];
                }

                $question->options()->create($option);
            }
        }

        // Handle fill in the blanks
        if ($validated['question_type'] === 'fill_blank') {
            $question->fillBlanks()->delete();

            foreach ($validated['fill_blanks'] as $index => $blankData) {
                $question->fillBlanks()->create([
                    'correct_answer' => $blankData['answer'],
                    'case_sensitive' => isset($blankData['case_sensitive']),
                    'sort_order' => $index + 1
                ]);
            }
        }

        // Handle matching pairs
        if ($validated['question_type'] === 'matching') {
            $question->matchingPairs()->delete();

            foreach ($validated['matching_pairs'] as $index => $pairData) {
                $question->matchingPairs()->create([
                    'left_item' => $pairData['left'],
                    'right_item' => $pairData['right'],
                    'sort_order' => $index + 1
                ]);
            }
        }

        // Clear any other relation data based on question type
        if (!in_array($validated['question_type'], ['multiple_choice', 'single_choice', 'true_false', 'image_selection'])) {
            foreach ($question->options as $option) {
                if ($option->image) {
                    Storage::disk('public')->delete($option->image);
                }
            }
            $question->options()->delete();
        }

        if ($validated['question_type'] !== 'fill_blank') {
            $question->fillBlanks()->delete();
        }

        if ($validated['question_type'] !== 'matching') {
            $question->matchingPairs()->delete();
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Question updated successfully',
                'question' => $question->fresh(['options', 'fillBlanks', 'matchingPairs'])
            ]);
        }

        return redirect()->route('admin.quizzes.questions', $question->quiz_id)
            ->with('success', 'Question updated successfully');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz deleted successfully');
    }

    public function destroyQuestion($id)
    {
        $question = Question::findOrFail($id);
        $quiz = $question->quiz;

        // Delete associated files
        if ($question->image) {
            Storage::disk('public')->delete($question->image);
        }

        // Delete options images for image selection
        if ($question->question_type === 'image_selection') {
            foreach ($question->options as $option) {
                if ($option->image) {
                    Storage::disk('public')->delete($option->image);
                }
            }
        }

        $question->delete();
        $quiz->decrement('total_questions');

        return redirect()->back()->with('success', 'Question deleted successfully');
    }

    public function editQuestion(Question $question)
    {
        $question->load(['options', 'fillBlanks', 'matchingPairs']);

        if (request()->wantsJson()) {
            // Transform the data to ensure proper structure
            $data = [
                'id' => $question->id,
                'quiz_id' => $question->quiz_id,
                'question_text' => $question->question_text,
                'question_type' => $question->question_type,
                'points' => $question->points,
                'explanation' => $question->explanation,
                'image' => $question->image,
                'sort_order' => $question->sort_order,
                'options' => $question->options->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'option_text' => $option->option_text,
                        'is_correct' => $option->is_correct,
                        'image' => $option->image,
                        'sort_order' => $option->sort_order
                    ];
                }),
                'fill_blanks' => $question->fillBlanks->map(function ($blank) {
                    return [
                        'id' => $blank->id,
                        'correct_answer' => $blank->correct_answer,
                        'case_sensitive' => $blank->case_sensitive,
                        'sort_order' => $blank->sort_order
                    ];
                }),
                'matching_pairs' => $question->matchingPairs->map(function ($pair) {
                    return [
                        'id' => $pair->id,
                        'left_item' => $pair->left_item,
                        'right_item' => $pair->right_item,
                        'sort_order' => $pair->sort_order
                    ];
                })
            ];

            return response()->json($data);
        }

        return view('admin.quizzes.edit-question', compact('question'));
    }


    public function reorderQuestions(Request $request)
    {
        $request->validate([
            'questions' => 'required|array',
            'questions.*.id' => 'required|exists:questions,id',
            'questions.*.sort_order' => 'required|integer|min:1'
        ]);

        foreach ($request->questions as $item) {
            Question::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}
