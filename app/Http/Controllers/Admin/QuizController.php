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
        return view('admin.quizzes.questions', compact('quiz'));
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question_text' => 'required',
            'question_type' => 'required|in:multiple_choice,single_choice,true_false,fill_blank,matching,image_selection',
            'points' => 'integer|min:1',
            'options' => 'required_if:question_type,multiple_choice,single_choice,true_false|array',
            'options.*.text' => 'required_with:options|string',
            'options.*.is_correct' => 'sometimes|boolean',
            'fill_blanks' => 'required_if:question_type,fill_blank|array',
            'fill_blanks.*.answer' => 'required_with:fill_blanks|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $questionData = [
            'quiz_id' => $quiz->id,
            'question_text' => $validated['question_text'],
            'question_type' => $validated['question_type'],
            'points' => $validated['points'] ?? 1,
            'sort_order' => $quiz->questions()->count() + 1
        ];

        if ($request->hasFile('image')) {
            $questionData['image'] = $request->file('image')->store('questions', 'public');
        }

        $question = Question::create($questionData);

        // Handle options for multiple choice questions
        if (in_array($validated['question_type'], ['multiple_choice', 'single_choice', 'true_false'])) {
            foreach ($validated['options'] as $index => $optionData) {
                $question->options()->create([
                    'option_text' => $optionData['text'],
                    'is_correct' => isset($optionData['is_correct']),
                    'sort_order' => $index + 1
                ]);
            }
        }

        // Handle fill in the blanks
        if ($validated['question_type'] === 'fill_blank') {
            foreach ($validated['fill_blanks'] as $index => $blankData) {
                $question->fillBlanks()->create([
                    'correct_answer' => $blankData['answer'],
                    'sort_order' => $index + 1
                ]);
            }
        }

        $quiz->increment('total_questions');

        return redirect()->back()->with('success', 'Question added successfully');
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

        // Delete the question
        $question->delete();

        // Update quiz total questions count
        $quiz->decrement('total_questions');

        return redirect()->back()->with('success', 'Question deleted successfully');
    }
    public function editQuestion(Question $question)
    {
        $question->load(['options', 'fillBlanks']);

        if (request()->wantsJson()) {
            return response()->json($question);
        }

        return view('admin.quizzes.edit-question', compact('question'));
    }

    public function updateQuestion(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required',
            'question_type' => 'required|in:multiple_choice,single_choice,true_false,fill_blank,matching,image_selection',
            'points' => 'integer|min:1',
            'options' => 'required_if:question_type,multiple_choice,single_choice,true_false|array',
            'options.*.text' => 'required_with:options|string',
            'options.*.is_correct' => 'sometimes|boolean',
            'fill_blanks' => 'required_if:question_type,fill_blank|array',
            'fill_blanks.*.answer' => 'required_with:fill_blanks|string',
            'fill_blanks.*.case_sensitive' => 'sometimes|boolean',
            'image' => 'nullable|image|max:2048'
        ]);

        // Update question data
        $questionData = [
            'question_text' => $validated['question_text'],
            'question_type' => $validated['question_type'],
            'points' => $validated['points'] ?? 1,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }
            $questionData['image'] = $request->file('image')->store('questions', 'public');
        }

        $question->update($questionData);

        // Handle options for multiple choice questions
        if (in_array($validated['question_type'], ['multiple_choice', 'single_choice', 'true_false'])) {
            // Delete existing options
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

        // Handle fill in the blanks
        if ($validated['question_type'] === 'fill_blank') {
            // Delete existing fill blanks
            $question->fillBlanks()->delete();

            // Create new fill blanks
            foreach ($validated['fill_blanks'] as $index => $blankData) {
                $question->fillBlanks()->create([
                    'correct_answer' => $blankData['answer'],
                    'case_sensitive' => isset($blankData['case_sensitive']),
                    'sort_order' => $index + 1
                ]);
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Question updated successfully',
                'question' => $question->fresh(['options', 'fillBlanks'])
            ]);
        }

        return redirect()->route('admin.quizzes.questions', $question->quiz_id)
            ->with('success', 'Question updated successfully');
    }
}
