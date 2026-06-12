<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\InsufficientPracticeCreditsException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PracticeCreditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PracticeCreditController extends Controller
{
    public function index(Request $request, PracticeCreditService $creditService): View
    {
        $query = User::with('practiceCredits')
            ->where('role', '!=', 'admin');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20)->withQueryString();
        $users->getCollection()->each(function (User $user) use ($creditService) {
            $creditService->getOrCreateWallet($user);
            $user->load('practiceCredits');
        });

        return view('admin.practice-credits.index', compact('users'));
    }

    public function show(User $user, PracticeCreditService $creditService): View
    {
        $wallet = $creditService->getOrCreateWallet($user);
        $transactions = $user->practiceCreditTransactions()->latest()->paginate(25);

        return view('admin.practice-credits.show', compact('user', 'wallet', 'transactions'));
    }

    public function add(Request $request, User $user, PracticeCreditService $creditService): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $creditService->addCredits(
            $user,
            (int) $validated['amount'],
            'admin_grant',
            $validated['description'] ?? 'Admin granted Practice Room credits.',
            ['admin_user_id' => $request->user()->id]
        );

        return back()->with('success', 'Practice credits added successfully.');
    }

    public function subtract(Request $request, User $user, PracticeCreditService $creditService): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            $creditService->deductCredits(
                $user,
                (int) $validated['amount'],
                'adjustment',
                null,
                $validated['description'] ?? 'Admin subtracted Practice Room credits.',
                ['admin_user_id' => $request->user()->id]
            );
        } catch (InsufficientPracticeCreditsException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('success', 'Practice credits subtracted successfully.');
    }
}
