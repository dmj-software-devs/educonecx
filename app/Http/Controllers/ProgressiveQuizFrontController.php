<?php

namespace App\Http\Controllers;

use App\Models\ProgressiveQuiz;
use App\Models\ProgressiveQuizAttempt;
use App\Models\ProgressiveLevelAttempt;
use App\Models\ProgressiveAnswer;
use App\Models\ProgressiveLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProgressiveQuizFrontController extends Controller
{
    /**
     * Display a listing of progressive quizzes (public page).
     */
    public function index(Request $request)
    {
        $quizzes = ProgressiveQuiz::with(['levels'])
            ->where('status', 'published')
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(9);

        $totalQuizzes = ProgressiveQuiz::where('status', 'published')->count();
        $totalLevels = ProgressiveLevel::whereHas('quiz', function ($q) {
            $q->where('status', 'published');
        })->count();
        $totalAttempts = ProgressiveQuizAttempt::count();

        return view('progressive-quizzes.index', compact('quizzes', 'totalQuizzes', 'totalLevels', 'totalAttempts'));
    }

    /**
     * Display the specified progressive quiz details.
     */
    public function show($slug)
    {
        $quiz = ProgressiveQuiz::where('slug', $slug)
            ->with(['levels' => function ($q) {
                $q->orderBy('level_number');
            }])
            ->firstOrFail();

        if ($quiz->status !== 'published') {
            abort(404);
        }

        $user = Auth::user();
        $attempt = null;
        $completedLevelIds = [];
        $currentLevel = null;
        $canAttempt = true;
        $levelStatuses = [];
        $quizCompleted = false;
        $lastCompletedAttempt = null;
        $overallProgress = 0;

        if ($user) {
            // Get current in-progress attempt
            $attempt = ProgressiveQuizAttempt::where('progressive_quiz_id', $quiz->id)
                ->where('user_id', $user->id)
                ->where('status', 'in_progress')
                ->latest()
                ->first();

            // Get the most recent completed attempt (for showing results/progress after finish)
            $lastCompletedAttempt = ProgressiveQuizAttempt::where('progressive_quiz_id', $quiz->id)
                ->where('user_id', $user->id)
                ->where('status', 'completed')
                ->latest()
                ->first();

            $quizCompleted = !$attempt && $lastCompletedAttempt !== null;

            // Count completed attempts
            $completedAttempts = ProgressiveQuizAttempt::where('progressive_quiz_id', $quiz->id)
                ->where('user_id', $user->id)
                ->where('status', 'completed')
                ->count();

            // Check if user can attempt again
            if ($quiz->attempts_allowed > 0) {
                $canAttempt = $completedAttempts < $quiz->attempts_allowed;
            }

            // Get ALL completed levels from ALL attempts (both in-progress and completed quiz attempts)
            $completedLevelAttempts = ProgressiveLevelAttempt::whereHas('quizAttempt', function($q) use ($quiz, $user) {
                    $q->where('progressive_quiz_id', $quiz->id)
                      ->where('user_id', $user->id);
                })
                ->where('status', ProgressiveLevelAttempt::STATUS_COMPLETED)
                ->where('passed', true)
                ->get();

            // Extract level IDs that are completed
            $completedLevelIds = $completedLevelAttempts->pluck('progressive_level_id')->toArray();

            Log::info('Completed Level IDs: ' . json_encode($completedLevelIds));

            // Calculate overall progress — use in-progress attempt if available, else last completed
            $activeAttemptForProgress = $attempt ?? $lastCompletedAttempt;
            if ($activeAttemptForProgress) {
                $completedLevelsCount = $activeAttemptForProgress->levelAttempts()
                    ->where('status', ProgressiveLevelAttempt::STATUS_COMPLETED)
                    ->count();
                $overallProgress = $quiz->total_levels > 0
                    ? round(($completedLevelsCount / $quiz->total_levels) * 100)
                    : 0;
            }

            // Get current level from in-progress attempt
            if ($attempt) {
                $currentLevelAttempt = $attempt->getCurrentLevelAttempt();
                if ($currentLevelAttempt && $currentLevelAttempt->level) {
                    $currentLevel = $currentLevelAttempt->level;
                }
            }

            // Determine status for each level
            foreach ($quiz->levels as $level) {
                // Check if level is completed
                $isCompleted = in_array($level->id, $completedLevelIds);

                // Check if this is the current level
                $isCurrent = $currentLevel && $currentLevel->id == $level->id;

                // Determine if level is unlocked
                if ($level->level_number == 1) {
                    // Level 1 is always unlocked
                    $isUnlocked = true;
                } else {
                    // Check if previous level is completed
                    $previousLevel = $quiz->getLevelByNumber($level->level_number - 1);
                    $isUnlocked = $previousLevel && in_array($previousLevel->id, $completedLevelIds);
                }

                // Set status with priority: completed > in_progress > available > locked
                if ($isCompleted) {
                    $levelStatuses[$level->id] = 'completed';
                } elseif ($isCurrent) {
                    $levelStatuses[$level->id] = 'in_progress';
                } elseif ($isUnlocked) {
                    $levelStatuses[$level->id] = 'available';
                } else {
                    $levelStatuses[$level->id] = 'locked';
                }
            }
        }

        // Calculate total questions across all levels
        $totalQuestions = 0;
        foreach ($quiz->levels as $level) {
            $totalQuestions += $level->question_count;
        }

        return view('progressive-quizzes.show', compact(
            'quiz', 
            'attempt', 
            'completedLevelIds', 
            'currentLevel', 
            'canAttempt',
            'totalQuestions',
            'levelStatuses',
            'quizCompleted',
            'lastCompletedAttempt',
            'overallProgress'
        ));
    }

    /**
     * Start a new progressive quiz attempt.
     */
    public function start(Request $request, ProgressiveQuiz $progressiveQuiz)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user can attempt
        if (!$progressiveQuiz->canAttempt($user->id)) {
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                ->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }

        // Check for existing in-progress attempt
        $existingAttempt = $progressiveQuiz->getUserAttempt($user->id);
        if ($existingAttempt) {
            return redirect()->route('progressive-quizzes.continue', $progressiveQuiz)
                ->with('info', 'You have an ongoing attempt. Continue where you left off.');
        }

        // Check if starting a specific level (for retry)
        $startLevel = null;
        if ($request->has('level_id')) {
            $startLevel = ProgressiveLevel::find($request->level_id);
            
            // Verify the level belongs to this quiz
            if (!$startLevel || $startLevel->progressive_quiz_id != $progressiveQuiz->id) {
                return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                    ->with('error', 'Invalid level selected.');
            }
            
            // Check if level is unlocked
            if (!$this->isLevelUnlocked($progressiveQuiz, $user->id, $startLevel->level_number)) {
                return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                    ->with('error', 'This level is not unlocked yet.');
            }
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
                'current_level_number' => $startLevel ? $startLevel->level_number : 1,
                'status' => 'in_progress',
                'started_at' => now()
            ]);

            // Get target level
            $targetLevel = $startLevel ?? $progressiveQuiz->getFirstLevel();

            // Create level attempt
            $levelAttempt = ProgressiveLevelAttempt::create([
                'progressive_quiz_attempt_id' => $quizAttempt->id,
                'progressive_level_id' => $targetLevel->id,
                'level_number' => $targetLevel->level_number,
                'status' => ProgressiveLevelAttempt::STATUS_AVAILABLE,
            ]);

            // Update quiz attempt with current level
            $quizAttempt->update([
                'current_level_id' => $targetLevel->id
            ]);

            DB::commit();

            return redirect()->route('progressive-quizzes.take', [
                'progressiveQuiz' => $progressiveQuiz->id,
                'level' => $targetLevel->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to start progressive quiz: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to start quiz. Please try again.');
        }
    }

    /**
     * Restart a quiz — abandon current in-progress attempt and start fresh.
     */
    public function restart(Request $request, ProgressiveQuiz $progressiveQuiz)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Abandon ALL in-progress attempts for this quiz
        DB::table('progressive_quiz_attempts')
            ->where('progressive_quiz_id', $progressiveQuiz->id)
            ->where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->update(['status' => 'abandoned', 'updated_at' => now()]);

        Log::info('Restarting quiz ' . $progressiveQuiz->id . ' for user ' . $user->id . '. Abandoned in-progress attempts.');

        // Check if user can still attempt
        if (!$progressiveQuiz->canAttempt($user->id)) {
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                ->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }

        // Now start fresh
        DB::beginTransaction();
        try {
            $attemptNumber = $progressiveQuiz->attempts()
                ->where('user_id', $user->id)
                ->whereIn('status', ['completed', 'abandoned'])
                ->count() + 1;

            $quizAttempt = ProgressiveQuizAttempt::create([
                'progressive_quiz_id' => $progressiveQuiz->id,
                'user_id' => $user->id,
                'attempt_number' => $attemptNumber,
                'current_level_number' => 1,
                'status' => 'in_progress',
                'started_at' => now()
            ]);

            $targetLevel = $progressiveQuiz->getFirstLevel();

            ProgressiveLevelAttempt::create([
                'progressive_quiz_attempt_id' => $quizAttempt->id,
                'progressive_level_id' => $targetLevel->id,
                'level_number' => $targetLevel->level_number,
                'status' => ProgressiveLevelAttempt::STATUS_AVAILABLE,
            ]);

            $quizAttempt->update(['current_level_id' => $targetLevel->id]);

            DB::commit();

            return redirect()->route('progressive-quizzes.take', [
                'progressiveQuiz' => $progressiveQuiz->id,
                'level' => $targetLevel->id
            ])->with('info', 'Quiz restarted from Level 1.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to restart quiz: ' . $e->getMessage());
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                ->with('error', 'Failed to restart quiz. Please try again.');
        }
    }

    /**
     * Continue an existing attempt.
     */
    public function continue(ProgressiveQuiz $progressiveQuiz)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $attempt = $progressiveQuiz->getUserAttempt($user->id);

        if (!$attempt) {
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                ->with('error', 'No ongoing attempt found.');
        }

        $currentLevel = $attempt->getCurrentLevel();
        
        if (!$currentLevel) {
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                ->with('error', 'Unable to find current level.');
        }

        // Check if level is already completed in this attempt
        $levelAttempt = $attempt->levelAttempts()
            ->where('progressive_level_id', $currentLevel->id)
            ->first();

        if ($levelAttempt && $levelAttempt->isCompleted()) {
            // Find next available level
            $nextLevel = $attempt->getNextLevel();
            if ($nextLevel) {
                return redirect()->route('progressive-quizzes.take', [
                    'progressiveQuiz' => $progressiveQuiz->id,
                    'level' => $nextLevel->id
                ]);
            } else {
                // Complete the quiz
                return redirect()->route('progressive-quizzes.results', $progressiveQuiz)
                    ->with('success', 'Congratulations! You have completed all levels!');
            }
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
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $attempt = $progressiveQuiz->getUserAttempt($user->id);

        if (!$attempt) {
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                ->with('error', 'Please start the quiz first.');
        }

        // Check if level is unlocked
        if (!$this->isLevelUnlocked($progressiveQuiz, $user->id, $level->level_number)) {
            return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                ->with('error', 'This level is not unlocked yet. Complete the previous level first.');
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

        // If level is already completed — never allow re-taking via back button
        if ($levelAttempt->isCompleted()) {
            $nextLevel = $attempt->getNextLevel();
            if ($nextLevel) {
                return redirect()->route('progressive-quizzes.take', [
                    'progressiveQuiz' => $progressiveQuiz->id,
                    'level' => $nextLevel->id
                ]);
            }
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

            $questionsQuery = $level->questions();

            if ($level->shuffle_questions) {
                $questionsQuery->inRandomOrder();
            } else {
                $questionsQuery->orderBy('sort_order');
            }

            $questions = $questionsQuery->get();
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
        $progress = $totalQuestions > 0 ? ($answeredCount / $totalQuestions) * 100 : 0;

        // Per-question timer: 27 seconds per question (no level-wide time limit)
        $remainingTime = null;
        $questionTimeLimit = 27;

        $response = response()->view('progressive-quizzes.take', compact(
            'progressiveQuiz',
            'level',
            'levelAttempt',
            'questions',
            'totalQuestions',
            'answeredCount',
            'progress',
            'remainingTime',
            'questionTimeLimit'
        ));

        // Prevent browser caching — back button must re-request from server
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        return $response;
    }

    /**
     * Check if a level is unlocked for a user
     */
    private function isLevelUnlocked($quiz, $userId, $levelNumber)
    {
        if ($levelNumber == 1) {
            return true;
        }

        // Check if previous level is completed in ANY attempt
        $previousLevel = $quiz->getLevelByNumber($levelNumber - 1);
        if (!$previousLevel) {
            return false;
        }

        $previousLevelCompleted = ProgressiveLevelAttempt::whereHas('quizAttempt', function($q) use ($quiz, $userId) {
                $q->where('progressive_quiz_id', $quiz->id)
                  ->where('user_id', $userId);
            })
            ->where('progressive_level_id', $previousLevel->id)
            ->where('status', ProgressiveLevelAttempt::STATUS_COMPLETED)
            ->where('passed', true)
            ->exists();

        Log::info('Checking if level ' . $levelNumber . ' is unlocked. Previous level completed: ' . ($previousLevelCompleted ? 'yes' : 'no'));

        return $previousLevelCompleted;
    }

    /**
     * Submit answer for a question.
     */
    public function submitAnswer(Request $request, ProgressiveQuiz $progressiveQuiz, ProgressiveLevel $level)
    {
        // Log at the very beginning
        Log::info('========== SUBMIT ANSWER STARTED ==========');
        Log::info('Request data: ' . json_encode($request->all()));
        
        $user = Auth::user();

        if (!$user) {
            Log::error('User not authenticated');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $request->validate([
                'question_id' => 'required|exists:progressive_questions,id',
                'answer' => 'required'
            ]);
        } catch (\Exception $e) {
            Log::error('Validation error: ' . $e->getMessage());
            return response()->json(['error' => 'Validation failed: ' . $e->getMessage()], 422);
        }

        $attempt = $progressiveQuiz->getUserAttempt($user->id);

        if (!$attempt) {
            Log::error('No active attempt found for user ' . $user->id);
            return response()->json(['error' => 'No active attempt found'], 400);
        }

        $levelAttempt = $attempt->levelAttempts()
            ->where('progressive_level_id', $level->id)
            ->first();

        if (!$levelAttempt) {
            Log::error('Level attempt not found for level ' . $level->id);
            return response()->json(['error' => 'Level attempt not found'], 400);
        }

        if ($levelAttempt->isCompleted()) {
            Log::error('Level already completed');
            return response()->json(['error' => 'Level already completed'], 400);
        }

        $question = \App\Models\ProgressiveQuestion::with(['options', 'fillBlanks', 'matchingPairs'])
            ->findOrFail($request->question_id);

        // Check if already answered
        $existingAnswer = $levelAttempt->answers()
            ->where('progressive_question_id', $question->id)
            ->first();

        if ($existingAnswer) {
            Log::error('Question already answered');
            return response()->json(['error' => 'Question already answered'], 400);
        }

        // Start database transaction
        DB::beginTransaction();

        try {
            // Process and validate answer
            $processedAnswer = $this->processAnswerInput($request->answer, $question);
            $isCorrect = $this->validateAnswer($question, $processedAnswer);
            $pointsEarned = $isCorrect ? $question->points : 0;

            Log::info('Answer submitted for question ' . $question->id . '. Correct: ' . ($isCorrect ? 'yes' : 'no') . '. Points: ' . $pointsEarned);

            // Resolve selected option ID (for choice types)
            $selectedOptionId = null;
            if (in_array($question->question_type, ['single_choice', 'true_false'])) {
                $selectedOptionId = is_array($processedAnswer) ? ($processedAnswer[0] ?? null) : $processedAnswer;
            } elseif (in_array($question->question_type, ['multiple_choice', 'image_selection'])) {
                $selectedOptionId = is_array($processedAnswer) ? ($processedAnswer[0] ?? null) : null;
            }

            // Save answer — use answer_text (the actual fillable column on ProgressiveAnswer)
            $answer = ProgressiveAnswer::create([
                'progressive_level_attempt_id' => $levelAttempt->id,
                'progressive_question_id' => $question->id,
                'progressive_question_option_id' => $selectedOptionId,
                'answer_text' => is_array($processedAnswer) ? json_encode($processedAnswer) : (string) $processedAnswer,
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned,
                'time_spent' => $request->time_spent ?? 0
            ]);

            // Update level attempt score
            $levelAttempt->increment('score', $pointsEarned);

            Log::info('Updated score for level attempt ' . $levelAttempt->id . '. New score: ' . $levelAttempt->fresh()->score);

            // Check if level is complete
            $answeredCount = $levelAttempt->answers()->count();
            $totalQuestions = $level->questions()->count();

            Log::info('Answered count: ' . $answeredCount . ', Total questions: ' . $totalQuestions);

            if ($answeredCount >= $totalQuestions) {
                Log::info('Level complete! Calling completeLevel method');
                
                // Complete the level
                $result = $this->completeLevel($attempt, $levelAttempt, $level);
                
                // Commit the transaction
                DB::commit();
                
                Log::info('========== SUBMIT ANSWER COMPLETED (LEVEL COMPLETE) ==========');
                return $result;
            }

            // Commit the transaction
            DB::commit();

            // Get next question
            $nextQuestionQuery = $level->questions()
                ->whereNotIn('id', $levelAttempt->answers()->pluck('progressive_question_id'));
            
            if ($level->shuffle_questions) {
                $nextQuestionQuery->inRandomOrder();
            } else {
                $nextQuestionQuery->orderBy('sort_order');
            }
            
            $nextQuestion = $nextQuestionQuery->first();

            Log::info('Next question: ' . ($nextQuestion ? $nextQuestion->id : 'none'));
            Log::info('========== SUBMIT ANSWER COMPLETED ==========');

            return response()->json([
                'success' => true,
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned,
                'answered_count' => $answeredCount,
                'total_questions' => $totalQuestions,
                'next_question' => $nextQuestion ? [
                    'id' => $nextQuestion->id,
                    'question_text' => $nextQuestion->question_text,
                    'question_type' => $nextQuestion->question_type,
                    'points' => $nextQuestion->points,
                    'explanation' => $nextQuestion->explanation,
                    'image' => $nextQuestion->image_url,
                    'options' => $nextQuestion->options->map(function ($option) {
                        return [
                            'id' => $option->id,
                            'option_text' => $option->option_text,
                            'image' => $option->image_url
                        ];
                    })
                ] : null,
                'level_completed' => false
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in submitAnswer: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Complete a level.
     */
    private function completeLevel($attempt, $levelAttempt, $level)
    {
        Log::info('========== COMPLETE LEVEL DEBUG ==========');
        Log::info('Level ID: ' . $level->id);
        Log::info('Level Attempt ID: ' . $levelAttempt->id);

        // Refresh model — increment() only updates DB, not the in-memory object
        $levelAttempt = $levelAttempt->fresh();

        Log::info('Current score from database: ' . $levelAttempt->score);

        $totalPoints = $level->questions()->sum('points');
        $currentScore = $levelAttempt->score;

        Log::info('Total points possible: ' . $totalPoints);
        Log::info('Current score: ' . $currentScore);

        // Calculate percentage
        $percentage = $totalPoints > 0
            ? round(($currentScore / $totalPoints) * 100, 2)
            : 0;

        // Use getRawOriginal to avoid accessor issues; fall back to quiz pass_percentage
        $minPercentage = $level->getRawOriginal('min_percentage')
            ?? $attempt->quiz->pass_percentage
            ?? 0;
        $passed = $percentage >= $minPercentage;

        Log::info('Calculated percentage: ' . $percentage . '%');
        Log::info('Minimum required: ' . $minPercentage . '%');
        Log::info('Passed: ' . ($passed ? 'yes' : 'no'));

        // Update using direct DB update to ensure it works
        $updated = DB::table('progressive_level_attempts')
            ->where('id', $levelAttempt->id)
            ->update([
                'status' => ProgressiveLevelAttempt::STATUS_COMPLETED,
                'score' => $currentScore,
                'percentage' => $percentage,
                'passed' => $passed ? 1 : 0,
                'completed_at' => now(),
                'time_taken' => $levelAttempt->started_at ? now()->diffInSeconds($levelAttempt->started_at) : null,
                'updated_at' => now()
            ]);
        
        Log::info('Direct DB update result: ' . ($updated ? 'success' : 'failed'));

        // Verify with a fresh query
        $check = DB::table('progressive_level_attempts')
            ->where('id', $levelAttempt->id)
            ->first();
            
        Log::info('After update - ID: ' . $check->id);
        Log::info('After update - Status: ' . $check->status);
        Log::info('After update - Score: ' . $check->score);
        Log::info('After update - Percentage: ' . $check->percentage);
        Log::info('After update - Passed: ' . $check->passed);
        Log::info('After update - Completed_at: ' . $check->completed_at);

        // Check if all levels are completed in this attempt
        $completedLevelsCount = DB::table('progressive_level_attempts')
            ->where('progressive_quiz_attempt_id', $attempt->id)
            ->where('status', ProgressiveLevelAttempt::STATUS_COMPLETED)
            ->count();
        
        $totalLevels = DB::table('progressive_levels')
            ->where('progressive_quiz_id', $attempt->quiz->id)
            ->count();

        Log::info('Completed levels count: ' . $completedLevelsCount . '/' . $totalLevels);

        if ($completedLevelsCount >= $totalLevels) {
            // All levels completed - complete the quiz
            Log::info('All levels completed, completing quiz');
            return $this->completeQuiz($attempt);
        }

        // Get next level
        $nextLevel = DB::table('progressive_levels')
            ->where('progressive_quiz_id', $attempt->quiz->id)
            ->where('level_number', $level->level_number + 1)
            ->first();

        Log::info('Next level: ' . ($nextLevel ? $nextLevel->id : 'none'));

        // Update current level in quiz attempt
        if ($nextLevel) {
            $quizUpdated = DB::table('progressive_quiz_attempts')
                ->where('id', $attempt->id)
                ->update([
                    'current_level_id' => $nextLevel->id,
                    'current_level_number' => $nextLevel->level_number,
                    'updated_at' => now()
                ]);
            
            Log::info('Quiz attempt update result: ' . ($quizUpdated ? 'success' : 'failed'));
        }

        Log::info('========== END COMPLETE LEVEL DEBUG ==========');

        return response()->json([
            'success' => true,
            'level_completed' => true,
            'quiz_completed' => false,
            'passed' => $passed,
            'score' => $currentScore,
            'total_points' => $totalPoints,
            'percentage' => $percentage,
            'next_level' => $nextLevel ? [
                'id' => $nextLevel->id,
                'number' => $nextLevel->level_number,
                'title' => $nextLevel->title,
                'message' => $nextLevel->unlock_message ?? "Level {$nextLevel->level_number}: {$nextLevel->title}"
            ] : null,
            'level_results_url' => route('progressive-quizzes.level-results', [
                'progressiveQuiz' => $attempt->quiz->id,
                'level' => $level->id
            ])
        ]);
    }

    /**
     * Complete the entire quiz.
     */
    private function completeQuiz($attempt)
    {
        $totalScore = DB::table('progressive_level_attempts')
            ->where('progressive_quiz_attempt_id', $attempt->id)
            ->sum('score');
            
        $totalPossiblePoints = DB::table('progressive_questions')
            ->where('progressive_quiz_id', $attempt->quiz->id)
            ->sum('points');
            
        $overallPercentage = $totalPossiblePoints > 0 
            ? round(($totalScore / $totalPossiblePoints) * 100, 2) 
            : 0;

        $updated = DB::table('progressive_quiz_attempts')
            ->where('id', $attempt->id)
            ->update([
                'status' => 'completed',
                'completed_at' => now(),
                'overall_score' => $totalScore,
                'overall_percentage' => $overallPercentage,
                'passed' => $overallPercentage >= $attempt->quiz->pass_percentage ? 1 : 0,
                'time_taken' => $attempt->started_at ? now()->diffInSeconds($attempt->started_at) : null,
                'updated_at' => now()
            ]);

        Log::info('Quiz completed. Overall percentage: ' . $overallPercentage . '%. Update result: ' . ($updated ? 'success' : 'failed'));

        return response()->json([
            'success' => true,
            'level_completed' => true,
            'quiz_completed' => true,
            'passed' => $overallPercentage >= $attempt->quiz->pass_percentage,
            'score' => $totalScore,
            'total_points' => $totalPossiblePoints,
            'percentage' => $overallPercentage,
            'redirect' => route('progressive-quizzes.results', $attempt->quiz)
        ]);
    }

    /**
     * Process the answer input.
     */
    private function processAnswerInput($answer, $question)
    {
        if (!$answer) {
            return null;
        }

        switch ($question->question_type) {
            case 'single_choice':
            case 'true_false':
                return (int) $answer;

            case 'multiple_choice':
                if (is_array($answer)) {
                    return array_map('intval', $answer);
                }
                return [(int) $answer];

            case 'fill_blank':
                return trim($answer);

            case 'matching':
                return $answer;

            case 'image_selection':
                if (is_array($answer)) {
                    return array_map('intval', $answer);
                }
                return [(int) $answer];

            default:
                return $answer;
        }
    }

    /**
     * Validate answer based on question type.
     */
    private function validateAnswer($question, $answers)
    {
        if (!$answers) {
            return false;
        }

        switch ($question->question_type) {
            case 'multiple_choice':
                $correctOptions = $question->options()
                    ->where('is_correct', true)
                    ->pluck('id')
                    ->map(function ($id) {
                        return (int) $id;
                    })
                    ->sort()
                    ->values()
                    ->toArray();

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
                $correctOption = $question->options()
                    ->where('is_correct', true)
                    ->first();

                if (!$correctOption) {
                    return false;
                }

                return (int) $answers === (int) $correctOption->id;

            case 'fill_blank':
                $correctAnswers = $question->fillBlanks
                    ->pluck('correct_answer')
                    ->map(function ($item) {
                        return strtolower(trim($item));
                    })
                    ->toArray();

                $userAnswer = strtolower(trim($answers));

                return in_array($userAnswer, $correctAnswers);

            case 'matching':
                $correctPairs = 0;
                $totalPairs = $question->matchingPairs->count();

                foreach ($answers as $pairId => $value) {
                    $pair = $question->matchingPairs->find($pairId);
                    if ($pair && $pair->right_item === $value) {
                        $correctPairs++;
                    }
                }

                return $correctPairs === $totalPairs;

            case 'image_selection':
                $correctOptions = $question->options()
                    ->where('is_correct', true)
                    ->pluck('id')
                    ->map(function ($id) {
                        return (int) $id;
                    })
                    ->sort()
                    ->values()
                    ->toArray();

                $selectedOptions = collect($answers)
                    ->map(function ($value) {
                        return (int) $value;
                    })
                    ->sort()
                    ->values()
                    ->toArray();

                return $correctOptions == $selectedOptions;

            default:
                return false;
        }
    }

    /**
     * Show level results.
     */
    public function levelResults(ProgressiveQuiz $progressiveQuiz, ProgressiveLevel $level)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $attempt = $progressiveQuiz->getUserAttempt($user->id);

        if (!$attempt) {
            // If no active attempt, check if there's a completed attempt
            $attempt = $progressiveQuiz->attempts()
                ->where('user_id', $user->id)
                ->where('status', 'completed')
                ->latest()
                ->first();
                
            if (!$attempt) {
                return redirect()->route('progressive-quizzes.show', $progressiveQuiz->slug)
                    ->with('error', 'No attempt found.');
            }
        }

        $levelAttempt = $attempt->levelAttempts()
            ->where('progressive_level_id', $level->id)
            ->first();

        if (!$levelAttempt) {
            return redirect()->route('progressive-quizzes.take', [
                'progressiveQuiz' => $progressiveQuiz->id,
                'level' => $level->id
            ]);
        }

        $answers = $levelAttempt->answers()->with('question')->get();
        $totalQuestions = $level->questions()->count();
        $correctAnswers = $answers->where('is_correct', true)->count();
        $totalPoints = $level->questions()->sum('points');
        $earnedPoints = $levelAttempt->score;

        $nextLevel = $progressiveQuiz->levels()
            ->where('level_number', $level->level_number + 1)
            ->first();

        return view('progressive-quizzes.level-results', compact(
            'progressiveQuiz',
            'level',
            'levelAttempt',
            'answers',
            'totalQuestions',
            'correctAnswers',
            'totalPoints',
            'earnedPoints',
            'nextLevel'
        ));
    }

    /**
     * Show final quiz results.
     */
    public function results(ProgressiveQuiz $progressiveQuiz)
    {
        $user = Auth::user();

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
        $passed = $attempt->passed;

        // Can the user attempt again?
        $canAttempt = $progressiveQuiz->canAttempt($user->id);

        // Calculate stats per level
        $levelStats = [];
        foreach ($levelAttempts as $levelAttempt) {
            $levelQuestions = $levelAttempt->level->questions()->count();
            $levelStats[$levelAttempt->level_number] = [
                'level' => $levelAttempt->level,
                'attempt' => $levelAttempt,
                'questions' => $levelQuestions,
                'correct' => $levelAttempt->answers()->where('is_correct', true)->count(),
                'score' => $levelAttempt->score,
                'percentage' => $levelAttempt->percentage,
                'passed' => $levelAttempt->passed
            ];
        }

        return view('progressive-quizzes.results', compact(
            'progressiveQuiz',
            'attempt',
            'levelAttempts',
            'levelStats',
            'totalQuestions',
            'totalPoints',
            'passed',
            'canAttempt'
        ));
    }

    /**
     * Get user's quiz history.
     */
    public function history()
    {
        $user = Auth::user();

        $attempts = ProgressiveQuizAttempt::with('quiz')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('completed_at', 'desc')
            ->paginate(10);

        return view('progressive-quizzes.history', compact('attempts'));
    }

    /**
     * AJAX endpoint to get question data for editing.
     */
    public function getQuestion($questionId)
    {
        $question = \App\Models\ProgressiveQuestion::with(['options', 'fillBlanks', 'matchingPairs'])
            ->findOrFail($questionId);

        return response()->json([
            'id' => $question->id,
            'question_text' => $question->question_text,
            'question_type' => $question->question_type,
            'points' => $question->points,
            'explanation' => $question->explanation,
            'image' => $question->image,
            'options' => $question->options->map(function ($option) {
                return [
                    'id' => $option->id,
                    'option_text' => $option->option_text,
                    'image' => $option->image,
                    'is_correct' => $option->is_correct
                ];
            }),
            'fill_blanks' => $question->fillBlanks->map(function ($blank) {
                return [
                    'id' => $blank->id,
                    'correct_answer' => $blank->correct_answer,
                    'case_sensitive' => $blank->case_sensitive
                ];
            }),
            'matching_pairs' => $question->matchingPairs->map(function ($pair) {
                return [
                    'id' => $pair->id,
                    'left_item' => $pair->left_item,
                    'right_item' => $pair->right_item
                ];
            })
        ]);
    }
}