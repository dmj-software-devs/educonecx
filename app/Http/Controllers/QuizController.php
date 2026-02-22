<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QuizController extends Controller
{
    /**
     * Display a listing of standalone quizzes.
     */
    public function index()
    {
        $quizzes = Quiz::with('creator')
            ->where('type', 'standalone')
            ->where('status', 'published')
            ->latest()
            ->paginate(12);
        
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Display the specified quiz.
     */
    public function show(Quiz $quiz)
    {
        if ($quiz->status !== 'published') {
            abort(404);
        }

        $user = Auth::user();
        $attempts = null;
        $bestScore = null;
        $canAttempt = true;

        if ($user) {
            $attempts = $quiz->attempts()
                ->where('user_id', $user->id)
                ->latest()
                ->get();
            
            $bestScore = $quiz->attempts()
                ->where('user_id', $user->id)
                ->where('status', 'completed')
                ->max('score') ?? 0;
            
            $canAttempt = $quiz->can_attempt;
        }

        return view('quizzes.show', compact('quiz', 'attempts', 'bestScore', 'canAttempt'));
    }

    /**
     * Start a quiz attempt.
     */
    public function start(Request $request, Quiz $quiz)
    {
        $user = Auth::user();

        if (!$quiz->can_attempt) {
            return redirect()->route('quizzes.show', $quiz)
                ->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }

        // Check for incomplete attempt
        $inProgressAttempt = $quiz->attempts()
            ->where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->first();

        if ($inProgressAttempt) {
            return redirect()->route('quizzes.take', ['quiz' => $quiz, 'attempt' => $inProgressAttempt]);
        }

        // Create new attempt
        $attemptNumber = $quiz->attempts()
            ->where('user_id', $user->id)
            ->count() + 1;

        $attempt = QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'attempt_number' => $attemptNumber,
            'started_at' => now(),
            'status' => 'in_progress'
        ]);

        return redirect()->route('quizzes.take', ['quiz' => $quiz, 'attempt' => $attempt]);
    }

    /**
     * Take a quiz attempt.
     */
    public function take(Quiz $quiz, QuizAttempt $attempt)
    {
        $user = Auth::user();

        // Verify ownership
        if ($attempt->user_id !== $user->id) {
            abort(403);
        }

        // Check if attempt is still in progress
        if ($attempt->status !== 'in_progress') {
            return redirect()->route('quizzes.results', ['quiz' => $quiz, 'attempt' => $attempt]);
        }

        // Check time limit
        if ($quiz->time_limit) {
            $timeElapsed = now()->diffInMinutes($attempt->started_at);
            if ($timeElapsed > $quiz->time_limit) {
                $attempt->update([
                    'status' => 'completed',
                    'completed_at' => now()
                ]);
                return redirect()->route('quizzes.results', $quiz)
                    ->with('error', 'Time limit exceeded.');
            }
        }

        $questions = $quiz->questions()
            ->when($quiz->shuffle_questions, function ($query) {
                return $query->inRandomOrder();
            }, function ($query) {
                return $query->orderBy('sort_order');
            })
            ->get();

        // Shuffle options if enabled
        if ($quiz->randomize_options) {
            foreach ($questions as $question) {
                $question->options = $question->options->shuffle();
            }
        }

        $remainingTime = $quiz->time_limit ? 
            ($quiz->time_limit * 60) - now()->diffInSeconds($attempt->started_at) : null;

        return view('quizzes.take', compact('quiz', 'attempt', 'questions', 'remainingTime'));
    }

    /**
     * Submit a quiz attempt.
     */
    public function submit(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        $user = Auth::user();

        // Verify ownership
        if ($attempt->user_id !== $user->id) {
            abort(403);
        }

        // Check if already completed
        if ($attempt->status === 'completed') {
            return redirect()->route('quizzes.results', ['quiz' => $quiz, 'attempt' => $attempt]);
        }

        $questions = $quiz->questions()->with(['options', 'fillBlanks', 'matchingPairs'])->get();
        $totalPoints = $questions->sum('points');
        $earnedPoints = 0;

        foreach ($questions as $question) {
            $answer = $request->input('question_' . $question->id);
            $isCorrect = false;
            $pointsEarned = 0;

            if ($answer) {
                $isCorrect = $question->validateAnswer($answer);
                if ($isCorrect) {
                    $pointsEarned = $question->points;
                    $earnedPoints += $pointsEarned;
                }
            }

            // Save answer
            QuizAnswer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'option_id' => is_numeric($answer) ? $answer : null,
                'answer_text' => is_array($answer) ? json_encode($answer) : $answer,
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned
            ]);
        }

        $percentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100, 2) : 0;
        $passed = $percentage >= $quiz->pass_percentage;

        // Update attempt
        $attempt->update([
            'score' => $earnedPoints,
            'percentage' => $percentage,
            'passed' => $passed,
            'time_taken' => now()->diffInSeconds($attempt->started_at),
            'completed_at' => now(),
            'status' => 'completed'
        ]);

        // Create notification
        $user->notifications()->create([
            'type' => 'quiz_completed',
            'title' => 'Quiz Completed',
            'message' => "You have completed the quiz '{$quiz->title}' with a score of {$percentage}%.",
            'data' => json_encode([
                'quiz_id' => $quiz->id,
                'score' => $percentage,
                'passed' => $passed
            ])
        ]);

        return redirect()->route('quizzes.results', ['quiz' => $quiz, 'attempt' => $attempt])
            ->with('success', 'Quiz submitted successfully!');
    }

    /**
     * Show quiz results.
     */
    public function results(Quiz $quiz, QuizAttempt $attempt)
    {
        $user = Auth::user();

        // Verify ownership
        if ($attempt->user_id !== $user->id) {
            abort(403);
        }

        $attempt->load('answers.question', 'answers.option');

        return view('quizzes.results', compact('quiz', 'attempt'));
    }
}