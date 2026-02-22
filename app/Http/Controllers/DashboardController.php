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
use App\Models\User;
use App\Models\Wishlist;

class DashboardController extends Controller
{
    /**
     * Show student dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'enrolled_courses' => Enrollment::where('user_id', $user->id)->count(),
            'completed_courses' => Enrollment::where('user_id', $user->id)
                ->whereNotNull('completed_at')
                ->count(),
            'quizzes_taken' => QuizAttempt::where('user_id', $user->id)->count(),
            'certificates_earned' => Certificate::where('user_id', $user->id)->count(),
        ];
        
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
            ->inRandomOrder()
            ->take(3)
            ->get();
        
        return view('dashboard.index', compact(
            'user', 'stats', 'recentCourses', 'recentQuizzes', 'recommendedCourses'
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
        
        return view('dashboard.courses', compact('enrollments'));
    }

    /**
     * Show user's quizzes
     */
    public function quizzes()
    {
        $user = Auth::user();
        
        $attempts = QuizAttempt::with('quiz')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);
        
        return view('dashboard.quizzes', compact('attempts'));
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
        
        return view('dashboard.certificates', compact('certificates'));
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
                Storage::delete($user->avatar);
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
            
            return response()->json(['success' => true, 'message' => 'Course added to wishlist']);
        }
        
        return response()->json(['success' => false, 'message' => 'Course already in wishlist']);
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
        
        return response()->json(['success' => true, 'message' => 'Course removed from wishlist']);
    }
}