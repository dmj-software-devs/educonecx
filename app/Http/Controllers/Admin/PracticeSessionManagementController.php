<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PracticeUsageLog;
use App\Models\User;
use App\Models\UserPracticeBalance;
use App\Services\PracticeCreditService;
use Illuminate\Http\Request;

class PracticeSessionManagementController extends Controller
{
    public function index()
    {
        $balances = UserPracticeBalance::with('user')->latest()->paginate(25);
        $stats = [
            'total_minutes_used' => PracticeUsageLog::sum('minutes_used'),
            'total_purchased_minutes' => UserPracticeBalance::sum('purchased_minutes'),
            'monthly_usage' => PracticeUsageLog::where('created_at', '>=', now()->startOfMonth())->sum('minutes_used'),
            'practice_usage' => PracticeUsageLog::where('session_type', 'practice')->sum('minutes_used'),
            'exam_usage' => PracticeUsageLog::where('session_type', 'exam')->sum('minutes_used'),
        ];
        $topUsers = PracticeUsageLog::selectRaw('user_id, SUM(minutes_used) as total_minutes')->with('user')->groupBy('user_id')->orderByDesc('total_minutes')->limit(10)->get();
        $recentUsage = PracticeUsageLog::with(['user', 'session'])->latest()->limit(50)->get();
        $users = User::orderBy('name')->limit(500)->get();

        return view('admin.practice-sessions.index', compact('balances', 'stats', 'topUsers', 'recentUsage', 'users'));
    }

    public function adjust(Request $request, PracticeCreditService $service)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'action' => ['required', 'in:add,remove'],
            'minutes' => ['required', 'integer', 'min:1'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::findOrFail($validated['user_id']);
        $validated['action'] === 'add'
            ? $service->addManualMinutes($user, (int) $validated['minutes'], $validated['reason'] ?? null)
            : $service->removeManualMinutes($user, (int) $validated['minutes'], $validated['reason'] ?? null);

        return back()->with('success', 'Practice time balance updated.');
    }
}
