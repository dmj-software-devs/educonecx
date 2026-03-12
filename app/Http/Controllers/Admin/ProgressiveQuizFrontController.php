<?php

namespace App\Http\Controllers;

use App\Models\ProgressiveQuiz;
use App\Models\ProgressiveQuizAttempt;
use App\Models\ProgressiveLevelAttempt;
use App\Models\ProgressiveAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ProgressiveQuizFrontController extends Controller
{
    /**
     * Display the progressive quiz overview page.
     */
    public function show($slug)
    {
        $quiz = ProgressiveQuiz::where('slug', $slug)
            ->where('status', 'published')
            ->with(['levels' => function($query) {
                $query->orderBy('level_number');
            }])
            ->firstOrFail();

        $user = auth()->user();
        $attempt = null;
        $progress = null;

        if ($user) {
            $attempt = $quiz->getUserAttempt($user->id);
            $progress = $quiz->getProgressStats($user->id);
        }

        return view('progressive-quizzes.show', compact('quiz', 'attempt', 'progress'));
    }

    /**
     * Start a new quiz attempt.
     */
    public function start(ProgressiveQuiz $progressiveQuiz)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user can attempt
        if (!$progressiveQuiz->canAttempt($user->id)) {
            return redirect()->back()->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }

        // Check for existing in-progress attempt
        $existingAttempt = $progressiveQuiz->getUserAttempt($user->id);
        if ($existingAttempt) {
            return redirect()->route('progressive-quizzes.continue', $progressiveQuiz)
                ->with('info', 'You have an ongoing attempt. Continue where you left off.');
        }

        DB::beginTransaction();

        try {
            // Create new quiz attempt
            $attemptNumber = $progressiveQuiz->attempts()
                ->where('user_id', $user->id)
                ->where('status', 'completed')
                ->count() + 1;

            $quizAttempt = ProgressiveQuizAttempt::create([
                'progressive_quiz_id' => $progressiveQuiz->id,
                'user_id' => $user->id,
                'attempt_number' => $attemptNumber,
                'current_level_number' => 1,
                'status' => 'in_progress',
                'started_at' => now()
            ]);

            // Get first level
            $firstLevel = $progressiveQuiz->getFirstLevel();

            // Create level attempt
            $levelAttempt = ProgressiveLevelAttempt::create([
                'progressive_quiz_attempt_id' => $quizAttempt->id,
                'progressive_level_id' => $firstLevel->id,
                'level_number' => 1,
                'status' => ProgressiveLevelAttempt::STATUS_AVAILABLE,
            ]);

            // Update quiz attempt with current level
            $quizAttempt->update([
                'current_level_id' => $firstLevel->id
            ]);

            DB::commit();

            return redirect()->route('progressive-quizzes.take', [
                'progressiveQuiz' => $progressiveQuiz->id,
                'level' => $firstLevel->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to start quiz. Please try again.');
        }
    }

    /**
     * Continue an existing attempt.
     */
    public function continue(ProgressiveQuiz $progressiveQuiz)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $attempt = $progressiveQuiz->getUserAttempt($user->id);

        if (!$attempt) {
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                ->with('error', 'No ongoing attempt found.');
        }

        $currentLevel = $attempt->getCurrentLevel();
        $levelAttempt = $attempt->getCurrentLevelAttempt();

        // If level attempt doesn't exist or is locked, create/activate it
        if (!$levelAttempt || $levelAttempt->status === ProgressiveLevelAttempt::STATUS_LOCKED) {
            $levelAttempt = ProgressiveLevelAttempt::updateOrCreate(
                [
                    'progressive_quiz_attempt_id' => $attempt->id,
                    'progressive_level_id' => $currentLevel->id
                ],
                [
                    'level_number' => $currentLevel->level_number,
                    'status' => ProgressiveLevelAttempt::STATUS_AVAILABLE
                ]
            );
        }

        return redirect()->route('progressive-quizzes.take', [
            'progressiveQuiz' => $progressiveQuiz->id,
            'level' => $currentLevel->id
        ]);
    }

    /**
     * Take a specific level.
     */
    public function take(ProgressiveQuiz $progressiveQuiz, ProgressiveLevel $level)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $attempt = $progressiveQuiz->getUserAttempt($user->id);

        if (!$attempt) {
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                ->with('error', 'Please start the quiz first.');
        }

        // Check if level is unlocked
        if (!$level->isUnlocked($user->id)) {
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                ->with('error', 'This level is not unlocked yet.');
        }

        // Get or create level attempt
        $levelAttempt = $attempt->levelAttempts()
            ->where('progressive_level_id', $level->id)
            ->first();

        if (!$levelAttempt) {
            $levelAttempt = ProgressiveLevelAttempt::create([
                'progressive_quiz_attempt_id' => $attempt->id,
                'progressive_level_id' => $level->id,
                'level_number' => $level->level_number,
                'status' => ProgressiveLevelAttempt::STATUS_AVAILABLE
            ]);
        }

        // If level is already completed, redirect to results
        if ($levelAttempt->isCompleted()) {
            return redirect()->route('progressive-quizzes.level-results', [
                'progressiveQuiz' => $progressiveQuiz->id,
                'level' => $level->id
            ]);
        }

        // If level is in progress, get unanswered questions
        if ($levelAttempt->isInProgress()) {
            $questions = $levelAttempt->getUnansweredQuestions();
        } else {
            // Start the level
            $levelAttempt->start();
            $questions = $level->questions()->orderBy('sort_order')->get();
        }

        // Update current level in quiz attempt
        if ($attempt->current_level_id != $level->id) {
            $attempt->update([
                'current_level_id' => $level->id,
                'current_level_number' => $level->level_number
            ]);
        }

        $totalQuestions = $level->questions()->count();
        $answeredCount = $levelAttempt->answers()->count();

        return view('progressive-quizzes.take', compact(
            'progressiveQuiz',
            'level',
            'levelAttempt',
            'questions',
            'totalQuestions',
            'answeredCount'
        ));
    }

    /**
     * Submit answer for a question.
     */
    public function submitAnswer(Request $request, ProgressiveQuiz $progressiveQuiz, ProgressiveLevel $level)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'question_id' => 'required|exists:progressive_questions,id',
            'answer' => 'required'
        ]);

        $attempt = $progressiveQuiz->getUserAttempt($user->id);

        if (!$attempt || $attempt->current_level_id != $level->id) {
            return response()->json(['error' => 'Invalid attempt'], 400);
        }

        $levelAttempt = $attempt->getCurrentLevelAttempt();

        if (!$levelAttempt || $levelAttempt->isCompleted()) {
            return response()->json(['error' => 'Level already completed'], 400);
        }

        $question = ProgressiveQuestion::findOrFail($request->question_id);

        // Check if already answered
        $existingAnswer = $levelAttempt->answers()
            ->where('progressive_question_id', $question->id)
            ->first();

        if ($existingAnswer) {
            return response()->json(['error' => 'Question already answered'], 400);
        }

        // Validate answer
        $isCorrect = $question->validateAnswer($request->answer);
        $pointsEarned = $isCorrect ? $question->points : 0;

        // Save answer
        $answer = ProgressiveAnswer::create([
            'progressive_level_attempt_id' => $levelAttempt->id,
            'progressive_question_id' => $question->id,
            'answer_text' => is_array($request->answer) ? json_encode($request->answer) : $request->answer,
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned,
            'time_spent' => $request->time_spent ?? 0
        ]);

        // Update level attempt score
        $levelAttempt->increment('score', $pointsEarned);

        // Check if level is complete
        $answeredCount = $levelAttempt->answers()->count();
        $totalQuestions = $level->questions()->count();

        if ($answeredCount >= $totalQuestions) {
            return $this->completeLevel($attempt, $levelAttempt, $level);
        }

        return response()->json([
            'success' => true,
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned,
            'answered_count' => $answeredCount,
            'total_questions' => $totalQuestions,
            'explanation' => $question->explanation
        ]);
    }

    /**
     * Complete a level.
     */
    private function completeLevel($attempt, $levelAttempt, $level)
    {
        $totalPoints = $level->questions()->sum('points');
        $passed = $totalPoints > 0 
            ? ($levelAttempt->score / $totalPoints * 100) >= $level->min_percentage
            : false;

        $levelAttempt->complete($levelAttempt->score, $passed);

        // Check if all levels are completed
        $nextLevel = $attempt->getNextLevel();

        if (!$nextLevel) {
            // All levels completed
            $totalScore = $attempt->levelAttempts()->sum('score');
            $totalPossiblePoints = $attempt->quiz->questions()->sum('points');
            $overallPercentage = $totalPossiblePoints > 0 
                ? round(($totalScore / $totalPossiblePoints) * 100, 2) 
                : 0;

            $attempt->update([
                'status' => 'completed',
                'completed_at' => now(),
                'overall_score' => $totalScore,
                'overall_percentage' => $overallPercentage,
                'passed' => $overallPercentage >= $attempt->quiz->pass_percentage,
                'time_taken' => $attempt->started_at ? now()->diffInSeconds($attempt->started_at) : null
            ]);

            return response()->json([
                'success' => true,
                'level_completed' => true,
                'quiz_completed' => true,
                'passed' => $passed,
                'score' => $levelAttempt->score,
                'total_points' => $totalPoints,
                'percentage' => $levelAttempt->percentage,
                'next_level' => null,
                'redirect' => route('progressive-quizzes.results', $attempt->quiz)
            ]);
        }

        // Create next level attempt
        ProgressiveLevelAttempt::create([
            'progressive_quiz_attempt_id' => $attempt->id,
            'progressive_level_id' => $nextLevel->id,
            'level_number' => $nextLevel->level_number,
            'status' => ProgressiveLevelAttempt::STATUS_AVAILABLE
        ]);

        // Update current level in quiz attempt
        $attempt->update([
            'current_level_id' => $nextLevel->id,
            'current_level_number' => $nextLevel->level_number
        ]);

        return response()->json([
            'success' => true,
            'level_completed' => true,
            'quiz_completed' => false,
            'passed' => $passed,
            'score' => $levelAttempt->score,
            'total_points' => $totalPoints,
            'percentage' => $levelAttempt->percentage,
            'next_level' => [
                'id' => $nextLevel->id,
                'number' => $nextLevel->level_number,
                'title' => $nextLevel->title,
                'message' => $nextLevel->unlock_message ?? 'Level completed! Welcome to the next stage.'
            ]
        ]);
    }

    /**
     * Show level results.
     */
    public function levelResults(ProgressiveQuiz $progressiveQuiz, ProgressiveLevel $level)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $attempt = $progressiveQuiz->getUserAttempt($user->id);

        if (!$attempt) {
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug);
        }

        $levelAttempt = $attempt->levelAttempts()
            ->where('progressive_level_id', $level->id)
            ->first();

        if (!$levelAttempt || !$levelAttempt->isCompleted()) {
            return redirect()->route('progressive-quizzes.take', [
                'progressiveQuiz' => $progressiveQuiz->id,
                'level' => $level->id
            ]);
        }

        $answers = $levelAttempt->answers()->with('question')->get();
        $totalQuestions = $level->questions()->count();
        $correctAnswers = $answers->where('is_correct', true)->count();

        return view('progressive-quizzes.level-results', compact(
            'progressiveQuiz',
            'level',
            'levelAttempt',
            'answers',
            'totalQuestions',
            'correctAnswers'
        ));
    }

    /**
     * Show final quiz results.
     */
    public function results(ProgressiveQuiz $progressiveQuiz)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $attempt = $progressiveQuiz->attempts()
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->latest()
            ->first();

        if (!$attempt) {
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug);
        }

        $levelAttempts = $attempt->levelAttempts()->with('level')->get();
        $totalQuestions = $progressiveQuiz->questions()->count();
        $totalPoints = $progressiveQuiz->questions()->sum('points');

        return view('progressive-quizzes.results', compact(
            'progressiveQuiz',
            'attempt',
            'levelAttempts',
            'totalQuestions',
            'totalPoints'
        ));
    }
}