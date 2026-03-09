<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Display a listing of quizzes (public page).
     */
    public function index(Request $request)
    {
        $quizzes = Quiz::withCount('questions')
            ->where('status', 'published')
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(9);

        $totalQuizzes = Quiz::where('status', 'published')->count();
        $totalQuestions = \App\Models\Question::whereHas('quiz', function ($q) {
            $q->where('status', 'published');
        })->count();
        $totalAttempts = QuizAttempt::count();

        return view('quiz', compact('quizzes', 'totalQuizzes', 'totalQuestions', 'totalAttempts'));
    }

    /**
     * Display the specified quiz details.
     */
    public function show($slug)
    {
        $quiz = Quiz::where('slug', $slug)
            ->with(['questions' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->firstOrFail();

        if ($quiz->status !== 'published') {
            abort(404);
        }

        $user = Auth::user();
        $attempts = collect();
        $bestScore = 0;
        $canAttempt = true;

        if ($user) {
            $attempts = QuizAttempt::where('quiz_id', $quiz->id)
                ->where('user_id', $user->id)
                ->orderBy('attempt_number', 'desc')
                ->get();

            $bestScore = $attempts->max('score') ?? 0;

            // Check if user can attempt again
            if ($quiz->attempts_allowed > 0) {
                $attemptsCount = QuizAttempt::where('quiz_id', $quiz->id)
                    ->where('user_id', $user->id)
                    ->count();
                $canAttempt = $attemptsCount < $quiz->attempts_allowed;
            }
        }

        return view('quizzes.show', compact('quiz', 'attempts', 'bestScore', 'canAttempt'));
    }

    /**
     * Start a new quiz attempt.
     */
    public function start(Request $request, $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $user = Auth::user();

        // Check if user can start a new attempt
        if ($quiz->attempts_allowed > 0) {
            $attemptsCount = QuizAttempt::where('quiz_id', $quiz->id)
                ->where('user_id', $user->id)
                ->count();

            if ($attemptsCount >= $quiz->attempts_allowed) {
                return redirect()->route('quizzes.show', $quiz->slug)
                    ->with('error', 'You have reached the maximum number of attempts for this quiz.');
            }
        }

        // Check for incomplete attempt
        $incompleteAttempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->whereNull('completed_at')
            ->first();

        if ($incompleteAttempt) {
            return redirect()->route('quizzes.take', ['quiz' => $quiz->id, 'attempt' => $incompleteAttempt->id]);
        }

        // Create new attempt
        $attemptNumber = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->max('attempt_number') + 1;

        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'attempt_number' => $attemptNumber,
            'started_at' => now(),
            'status' => 'in_progress'
        ]);

        return redirect()->route('quizzes.take', ['quiz' => $quiz->id, 'attempt' => $attempt->id]);
    }

    /**
     * Take a quiz attempt.
     */
    public function take($quizId, $attemptId)
    {
        $quiz = Quiz::with(['questions' => function ($q) {
            $q->orderBy('sort_order');
        }])->findOrFail($quizId);

        $attempt = QuizAttempt::with('answers')
            ->where('id', $attemptId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if attempt is already completed
        if ($attempt->completed_at) {
            return redirect()->route('quizzes.results', ['quiz' => $quiz->id, 'attempt' => $attempt->id]);
        }

        $questions = $quiz->questions;

        // Shuffle questions if enabled
        if ($quiz->shuffle_questions) {
            $questions = $questions->shuffle();
        }

        // Shuffle options if enabled
        if ($quiz->randomize_options) {
            foreach ($questions as $question) {
                if ($question->options) {
                    $question->options = $question->options->shuffle();
                }
            }
        }

        // Calculate remaining time
        $remainingTime = null;
        if ($quiz->time_limit) {
            $elapsed = now()->diffInSeconds($attempt->started_at);
            $remainingTime = max(0, ($quiz->time_limit * 60) - $elapsed);

            // Auto-submit if time's up
            if ($remainingTime <= 0) {
                return $this->autoSubmitTimeout($quiz, $attempt);
            }
        }

        return view('quizzes.take', compact('quiz', 'attempt', 'questions', 'remainingTime'));
    }

    /**
     * Auto-submit quiz when time runs out.
     */
    private function autoSubmitTimeout($quiz, $attempt)
    {
        $questions = $quiz->questions;
        $totalPoints = $questions->sum('points');
        $earnedPoints = 0;

        // Get any answers that were saved
        $answers = QuizAnswer::where('attempt_id', $attempt->id)->get();

        foreach ($answers as $answer) {
            $question = $questions->find($answer->question_id);
            if ($question && $answer->is_correct) {
                $earnedPoints += $question->points;
            }
        }

        $percentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;
        $passed = $percentage >= $quiz->pass_percentage;

        $attempt->update([
            'score' => $earnedPoints,
            'percentage' => $percentage,
            'passed' => $passed,
            'completed_at' => now(),
            'status' => 'completed'
        ]);

        return redirect()->route('quizzes.results', ['quiz' => $quiz->id, 'attempt' => $attempt->id])
            ->with('info', 'Time expired. Your quiz has been auto-submitted.');
    }

    /**
     * Submit a quiz answer or complete the quiz.
     */
    public function submit(Request $request, $quizId, $attemptId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $attempt = QuizAttempt::where('id', $attemptId)
            ->where('user_id', Auth::id())
            ->whereNull('completed_at')
            ->firstOrFail();

        $action = $request->input('action', 'next');
        $answers = $request->input('answers', []);
        
        // Check if this is an auto-skip request (timer expired)
        $isAutoSkip = $request->has('auto_skip') && $request->input('auto_skip') == '1';
        $noAnswer = $request->has('no_answer') && $request->input('no_answer') == '1';

        // Get current question index
        $questions = $quiz->questions()->orderBy('sort_order')->get();
        $currentIndex = $attempt->answers()->count();

        // Save current answer if provided OR handle auto-skip
        if (isset($questions[$currentIndex])) {
            $currentQuestion = $questions[$currentIndex];

            if ($isAutoSkip && $noAnswer) {
                // Auto-skip: Save as null/not answered
                QuizAnswer::updateOrCreate(
                    [
                        'attempt_id' => $attempt->id,
                        'question_id' => $currentQuestion->id,
                    ],
                    [
                        'answer_data' => json_encode(['skipped' => true, 'auto_skipped' => true]),
                        'is_correct' => false,
                        'points_earned' => 0,
                        'answered_at' => now(),
                    ]
                );
                
                // Log for debugging
                \Log::info('Question auto-skipped due to timer expiration', [
                    'question_id' => $currentQuestion->id,
                    'attempt_id' => $attempt->id
                ]);
            } elseif (!empty($answers) && isset($answers[$currentQuestion->id])) {
                // Extract the actual answer values from the nested structure
                $processedAnswers = $this->processAnswerInput($answers, $currentQuestion);

                // Check if answer is correct
                $isCorrect = $this->validateAnswer($currentQuestion, $processedAnswers);
                $pointsEarned = $isCorrect ? $currentQuestion->points : 0;

                QuizAnswer::updateOrCreate(
                    [
                        'attempt_id' => $attempt->id,
                        'question_id' => $currentQuestion->id,
                    ],
                    [
                        'answer_data' => json_encode($processedAnswers),
                        'is_correct' => $isCorrect,
                        'points_earned' => $pointsEarned,
                        'answered_at' => now(),
                    ]
                );
            }
        }

        // Handle different actions
        if ($action === 'previous') {
            return redirect()->back();
        }

        if ($action === 'next') {
            if ($attempt->answers()->count() >= $quiz->questions->count()) {
                // All questions answered, calculate final score
                return $this->completeQuiz($quiz, $attempt);
            }
            return redirect()->back();
        }

        if ($action === 'complete' || $action === 'timeout') {
            return $this->completeQuiz($quiz, $attempt);
        }

        return redirect()->back();
    }

    /**
     * Process the answer input to extract actual values.
     */
    private function processAnswerInput($answers, $question)
    {
        // Get the answer for this specific question
        $questionAnswer = $answers[$question->id] ?? null;

        if (!$questionAnswer) {
            return null;
        }

        switch ($question->question_type) {
            case 'single_choice':
            case 'true_false':
                // For radio inputs, value is directly the option ID
                return $questionAnswer;

            case 'multiple_choice':
                // For checkbox inputs, value might be an array of IDs
                return $questionAnswer;

            case 'fill_blank':
                // For text input
                return trim($questionAnswer);

            case 'matching':
                // For matching pairs, we need to collect all pair values
                $matchingAnswers = [];
                foreach ($questionAnswer as $pairId => $value) {
                    $matchingAnswers[$pairId] = $value;
                }
                return $matchingAnswers;

            default:
                return $questionAnswer;
        }
    }

    /**
     * Complete the quiz and calculate final score.
     */
    private function completeQuiz($quiz, $attempt)
    {
        $questions = $quiz->questions;
        $answers = QuizAnswer::where('attempt_id', $attempt->id)->get();

        $totalPoints = $questions->sum('points');
        $earnedPoints = $answers->sum('points_earned');
        $percentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;
        $passed = $percentage >= $quiz->pass_percentage;

        // Count skipped questions for logging
        $skippedCount = 0;
        foreach ($answers as $answer) {
            $answerData = json_decode($answer->answer_data, true);
            if (isset($answerData['skipped']) && $answerData['skipped'] === true) {
                $skippedCount++;
            }
        }

        $attempt->update([
            'score' => $earnedPoints,
            'percentage' => $percentage,
            'passed' => $passed,
            'completed_at' => now(),
            'status' => 'completed'
        ]);

        // Log skipped questions count
        \Log::info('Quiz completed with skipped questions', [
            'quiz_id' => $quiz->id,
            'attempt_id' => $attempt->id,
            'skipped_count' => $skippedCount,
            'total_questions' => $questions->count()
        ]);

        // Create notification
        if (Auth::check()) {
            Auth::user()->notifications()->create([
                'type' => 'quiz_completed',
                'title' => 'Quiz Completed',
                'message' => "You have completed the quiz '{$quiz->title}' with a score of {$percentage}%. " . 
                            ($skippedCount > 0 ? "{$skippedCount} questions were auto-skipped." : ""),
                'data' => json_encode([
                    'quiz_id' => $quiz->id,
                    'score' => $percentage,
                    'passed' => $passed,
                    'skipped_count' => $skippedCount
                ])
            ]);
        }

        return redirect()->route('quizzes.results', ['quiz' => $quiz->id, 'attempt' => $attempt->id])
            ->with('success', 'Quiz completed successfully!' . 
                    ($skippedCount > 0 ? " {$skippedCount} questions were auto-skipped due to time limits." : ""));
    }

    /**
     * Validate answer based on question type.
     */
    private function validateAnswer($question, $answers)
    {
        // Handle skipped questions
        if (is_array($answers) && isset($answers['skipped']) && $answers['skipped'] === true) {
            return false;
        }
        
        // Handle if answers is a string (for fill_in_blank or single choice)
        if (is_string($answers)) {
            $answers = trim($answers);
        }

        switch ($question->question_type) {
            case 'multiple_choice':
                // Multiple choice expects array of answers
                if (!is_array($answers)) {
                    return false;
                }

                // Get correct option IDs
                $correctOptions = $question->options()
                    ->where('is_correct', true)
                    ->pluck('id')
                    ->map(function ($id) {
                        return (int) $id; // Convert to integer for comparison
                    })
                    ->sort()
                    ->values()
                    ->toArray();

                // Convert answer values to integers for comparison
                $answerValues = collect($answers)
                    ->map(function ($value) {
                        return (int) $value;
                    })
                    ->sort()
                    ->values()
                    ->toArray();

                return $correctOptions == $answerValues;

            case 'single_choice':
            case 'true_false':
                // Get correct option ID
                $correctOption = $question->options()
                    ->where('is_correct', true)
                    ->first();

                if (!$correctOption) {
                    return false;
                }

                return (int) $answers === (int) $correctOption->id;

            case 'fill_blank':
                // Get correct answers
                $correctAnswers = $question->fillBlanks
                    ->pluck('answer')
                    ->map(function ($item) {
                        return strtolower(trim($item));
                    })
                    ->toArray();

                $userAnswer = strtolower(trim($answers));

                return in_array($userAnswer, $correctAnswers);

            case 'matching':
                // Matching expects array of pairs
                if (!is_array($answers)) {
                    return false;
                }

                // Implement matching validation logic
                $correctPairs = 0;
                $totalPairs = $question->matchingPairs->count();

                foreach ($answers as $key => $value) {
                    if (strpos($key, 'pair_') === 0) {
                        $pairId = str_replace('pair_', '', $key);
                        $pair = $question->matchingPairs->find($pairId);

                        if ($pair && $pair->right_item === $value) {
                            $correctPairs++;
                        }
                    }
                }

                return $correctPairs === $totalPairs;

            default:
                return false;
        }
    }

    /**
     * Show quiz results - FIXED VERSION
     * This method can accept either:
     * 1. Two parameters: ($quizId, $attemptId) - for route parameters
     * 2. One parameter with the attempt ID as query string - for backward compatibility
     */
    /**
     * Show quiz results - FIXED VERSION
     */
    public function results($quizId, $attemptId = null)
    {
        // If only one parameter is passed and it's a Request object (for API)
        if ($quizId instanceof Request) {
            return $this->resultsWithRequest($quizId);
        }

        // If attemptId is null, try to get it from the request
        if ($attemptId === null) {
            $attemptId = request()->get('attempt');

            if (!$attemptId) {
                abort(404, 'Attempt ID not provided.');
            }
        }

        // Load quiz with questions and ALL their relationships
        $quiz = Quiz::with(['questions' => function ($q) {
            $q->orderBy('sort_order')->with([
                'options',
                'fillBlanks',
                'matchingPairs'
            ]);
        }])->findOrFail($quizId);

        // Load attempt with answers and their question relationships
        $attempt = QuizAttempt::with(['answers' => function ($q) {
            $q->with([
                'question.options',
                'question.fillBlanks',
                'question.matchingPairs'
            ]);
        }])->where('id', $attemptId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // If attempt is not completed, redirect to take page
        if (!$attempt->completed_at) {
            return redirect()->route('quizzes.take', ['quiz' => $quiz->id, 'attempt' => $attempt->id]);
        }

        $totalPoints = $quiz->questions->sum('points');
        $earnedPoints = $attempt->score ?? 0;
        $percentage = $attempt->percentage ?? 0;
        $passed = $attempt->passed ?? false;

        // Debug: Check if fillBlanks are loaded
        foreach ($quiz->questions as $question) {
            if ($question->question_type === 'fill_blank') {
                \Log::info('Fill Blank Question ID: ' . $question->id);
                \Log::info('Fill Blanks count: ' . $question->fillBlanks->count());
                \Log::info('Fill Blanks data: ' . $question->fillBlanks->toJson());
            }
        }

        // Prepare answers for display with decoded data
        $answers = [];
        foreach ($attempt->answers as $answer) {
            $answerData = json_decode($answer->answer_data, true);
            $answer->decoded_data = $answerData;
            $answers[$answer->question_id] = $answer;
        }

        return view('quizzes.results', compact('quiz', 'attempt', 'earnedPoints', 'totalPoints', 'percentage', 'passed', 'answers'));
    }
    /**
     * Handle results with Request object (for API consistency)
     */
    private function resultsWithRequest(Request $request)
    {
        $quizId = $request->route('quiz');
        $attemptId = $request->get('attempt');

        if (!$attemptId) {
            abort(404, 'Attempt ID not provided.');
        }

        return $this->results($quizId, $attemptId);
    }

    /**
     * Get user's quiz history.
     */
    public function history()
    {
        $user = Auth::user();

        $attempts = QuizAttempt::with('quiz')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('completed_at', 'desc')
            ->paginate(10);

        return view('quizzes.history', compact('attempts'));
    }
}