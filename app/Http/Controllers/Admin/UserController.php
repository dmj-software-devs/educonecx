<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display list of students.
     */
    public function students()
    {
        $users = User::where('role', 'student')->latest()->paginate(15);
        return view('admin.users.students', compact('users'));
    }

    /**
     * Display list of instructors.
     */
    public function instructors()
    {
        $users = User::where('role', 'instructor')->latest()->paginate(15);
        return view('admin.users.instructors', compact('users'));
    }

    /**
     * Show form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,instructor,student',
            'status' => 'required|in:active,inactive,suspended',
            'phone' => 'nullable|max:20',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $enrollments = Enrollment::with('course')
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();
        
        $orders = Order::with('items')
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'total_enrollments' => Enrollment::where('user_id', $user->id)->count(),
            'completed_courses' => Enrollment::where('user_id', $user->id)
                ->whereNotNull('completed_at')
                ->count(),
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'total_spent' => Order::where('user_id', $user->id)
                ->where('payment_status', 'paid')
                ->sum('total'),
        ];

        return view('admin.users.show', compact('user', 'enrollments', 'orders', 'stats'));
    }

    /**
     * Show form for editing user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,instructor,student',
            'status' => 'required|in:active,inactive,suspended',
            'phone' => 'nullable|max:20',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if ($user->id === 1) {
            return back()->with('error', 'Cannot delete the main admin user.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Impersonate a user.
     */
    public function impersonate(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Cannot impersonate yourself.');
        }

        session()->put('impersonate', $user->id);

        return redirect()->route('dashboard')
            ->with('success', 'You are now impersonating ' . $user->name);
    }

    /**
     * Stop impersonating.
     */
    public function stopImpersonating()
    {
        session()->forget('impersonate');

        return redirect()->route('admin.dashboard')
            ->with('success', 'You are no longer impersonating another user.');
    }
}