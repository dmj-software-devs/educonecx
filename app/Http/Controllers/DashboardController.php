<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\AcademySession;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show student dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Calculate all statistics
        $enrolledCourses = Enrollment::where('user_id', $user->id)->count();
        $completedCourses = Enrollment::where('user_id', $user->id)
            ->where('progress', '>=', 100)
            ->count();
        $quizzesTaken = QuizAttempt::where('user_id', $user->id)->count();
        $certificatesEarned = Certificate::where('user_id', $user->id)->count();

        $stats = [
            'enrolled_courses' => $enrolledCourses,
            'completed_courses' => $completedCourses,
            'quizzes_taken' => $quizzesTaken,
            'certificates_earned' => $certificatesEarned,
        ];

        // Calculate quiz statistics for dashboard
        $quizAttempts = QuizAttempt::where('user_id', $user->id)->get();
        $averageQuizScore = $quizAttempts->avg('score') ?? 0;
        $averageQuizScore = number_format($averageQuizScore, 2); // 2 decimal places
        $passedQuizzes = $quizAttempts->where('passed', true)->count();

        // Calculate learning streak (consecutive days with activity)
        $streak = $this->calculateStreak($user->id);

        $recentCourses = Enrollment::with('course')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentQuizzes = QuizAttempt::with('quiz')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recommendedCourses = Course::with('category')
            ->where('status', 'published')
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select('course_id')
                    ->from('enrollments')
                    ->where('user_id', $user->id);
            })
            ->inRandomOrder()
            ->take(3)
            ->get();

        $academySessions = AcademySession::with(['category', 'scenario'])
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'user',
            'stats',
            'recentCourses',
            'recentQuizzes',
            'recommendedCourses',
            'averageQuizScore',
            'passedQuizzes',
            'streak',
            'academySessions'
        ));
    }

    /**
     * Show user's courses
     */
    public function courses()
    {
        $user = Auth::user();

        $enrollments = Enrollment::with('course')
            ->where('user_id', $user->id)
            ->paginate(12);

        // Calculate additional stats for courses page
        $completedCount = Enrollment::where('user_id', $user->id)
            ->where('progress', '>=', 100)
            ->count();

        $inProgressCount = Enrollment::where('user_id', $user->id)
            ->where('progress', '>', 0)
            ->where('progress', '<', 100)
            ->count();

        $averageProgress = Enrollment::where('user_id', $user->id)
            ->avg('progress') ?? 0;

        $totalHours = Enrollment::where('user_id', $user->id)
            ->with('course')
            ->get()
            ->sum(function ($enrollment) {
                return $enrollment->course->duration_in_hours ?? 0;
            });

        return view('dashboard.courses', compact(
            'enrollments',
            'completedCount',
            'inProgressCount',
            'averageProgress',
            'totalHours'
        ));
    }

    /**
     * Show user's quizzes - FIXED: Removed map() to keep as objects
     */
    public function quizzes()
    {
        $user = Auth::user();

        $attempts = QuizAttempt::with('quiz')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        // Calculate quiz statistics
        $totalQuizzes = QuizAttempt::where('user_id', $user->id)->count();
        $passedQuizzes = QuizAttempt::where('user_id', $user->id)
            ->where('passed', true)
            ->count();
        $averageScore = number_format(QuizAttempt::where('user_id', $user->id)
            ->avg('percentage') ?? 0, 2);
        $bestScore = QuizAttempt::where('user_id', $user->id)
            ->max('percentage') ?? 0;
        $passRate = $totalQuizzes > 0 ? round(($passedQuizzes / $totalQuizzes) * 100) : 0;

        // Get recent attempts for chart - KEEP AS OBJECTS (remove the map())
        $recentAttempts = QuizAttempt::with('quiz')
            ->where('user_id', $user->id)
            ->latest()
            ->take(7)
            ->get();
        // DO NOT convert to array - keep as Eloquent collection of objects

        return view('dashboard.quizzes', compact(
            'attempts',
            'totalQuizzes',
            'passedQuizzes',
            'averageScore',
            'bestScore',
            'passRate',
            'recentAttempts'  // This is now a collection of objects, not an array
        ));
    }

    /**
     * Show user's certificates
     */
    public function certificates()
    {
        $user = Auth::user();

        $certificates = Certificate::with('course')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        // Calculate certificate statistics
        $thisMonthCount = Certificate::where('user_id', $user->id)
            ->whereMonth('issue_date', Carbon::now()->month)
            ->count();

        $honorsCount = Certificate::where('user_id', $user->id)
            ->where('with_honors', true)
            ->count();

        // Get featured certificate (most recent or with honors)
        $featuredCertificate = Certificate::with('course')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        return view('dashboard.certificates', compact(
            'certificates',
            'thisMonthCount',
            'honorsCount',
            'featuredCertificate'
        ));
    }

    /**
     * Calculate learning streak
     */
    private function calculateStreak($userId)
    {
        $attempts = QuizAttempt::where('user_id', $userId)
            ->select('created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->pluck('created_at')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->unique()
            ->values();

        if ($attempts->isEmpty()) {
            return 0;
        }

        $streak = 1;
        $maxStreak = 1;

        for ($i = 0; $i < $attempts->count() - 1; $i++) {
            $currentDate = Carbon::parse($attempts[$i]);
            $nextDate = Carbon::parse($attempts[$i + 1]);

            if ($currentDate->diffInDays($nextDate) == 1) {
                $streak++;
                $maxStreak = max($maxStreak, $streak);
            } else {
                $streak = 1;
            }
        }

        return $maxStreak;
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'bio' => $request->bio,
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    /**
     * Update user avatar
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        return redirect()->route('profile')->with('success', 'Avatar updated successfully');
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('profile')->with('success', 'Password changed successfully');
    }

    /**
     * Add course to wishlist
     */
    public function addToWishlist(Course $course)
    {
        $user = Auth::user();

        $exists = Wishlist::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);

            if (request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Course added to wishlist']);
            }

            return redirect()->back()->with('success', 'Course added to wishlist');
        }

        if (request()->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Course already in wishlist']);
        }

        return redirect()->back()->with('info', 'Course already in wishlist');
    }

    /**
     * Remove course from wishlist
     */
    public function removeFromWishlist(Course $course)
    {
        $user = Auth::user();

        Wishlist::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Course removed from wishlist']);
        }

        return redirect()->back()->with('success', 'Course removed from wishlist');
    }
}
