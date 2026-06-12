<?php

namespace App\Services;

use App\Exceptions\InsufficientPracticeCreditsException;
use App\Models\AcademySession;
use App\Models\Course;
use App\Models\PracticeCreditTransaction;
use App\Models\User;
use App\Models\UserPracticeCredit;
use Illuminate\Support\Facades\DB;

class PracticeCreditService
{
    public function getOrCreateWallet(User $user): UserPracticeCredit
    {
        return UserPracticeCredit::firstOrCreate(
            ['user_id' => $user->id],
            [
                'balance' => 0,
                'lifetime_granted' => 0,
                'lifetime_purchased' => 0,
                'lifetime_used' => 0,
            ]
        );
    }

    public function grantSignupCredits(User $user): UserPracticeCredit
    {
        $amount = (int) config('practice_room.credits.new_user_credits', 20);

        if ($amount <= 0) {
            return $this->getOrCreateWallet($user);
        }

        return DB::transaction(function () use ($user, $amount) {
            $wallet = UserPracticeCredit::where('user_id', $user->id)->lockForUpdate()->first()
                ?: $this->getOrCreateWallet($user);

            if ($this->hasTransaction($user, 'signup_bonus')) {
                return $wallet->refresh();
            }

            $balanceBefore = (int) $wallet->balance;
            $balanceAfter = $balanceBefore + $amount;

            $wallet->update([
                'balance' => $balanceAfter,
                'lifetime_granted' => (int) $wallet->lifetime_granted + $amount,
            ]);

            PracticeCreditTransaction::create([
                'user_id' => $user->id,
                'type' => 'signup_bonus',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'New user Practice Room signup bonus.',
            ]);

            return $wallet->refresh();
        });
    }

    public function getBalance(User $user): int
    {
        return (int) $this->getOrCreateWallet($user)->balance;
    }

    public function hasEnoughCredits(User $user, int $cost): bool
    {
        return $this->getBalance($user) >= $cost;
    }

    public function getSessionCost(string $sessionType): int
    {
        return (int) config(
            $sessionType === 'exam' ? 'practice_room.credits.exam_cost' : 'practice_room.credits.practice_cost',
            $sessionType === 'exam' ? 2 : 1
        );
    }

    public function deductCredits(User $user, int $amount, string $type, ?AcademySession $session = null, string $description = null, array $meta = []): PracticeCreditTransaction
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Credit deduction amount must be greater than zero.');
        }

        return DB::transaction(function () use ($user, $amount, $type, $session, $description, $meta) {
            $wallet = UserPracticeCredit::where('user_id', $user->id)->lockForUpdate()->first()
                ?: $this->getOrCreateWallet($user);

            if ($wallet->balance < $amount) {
                throw new InsufficientPracticeCreditsException();
            }

            $balanceBefore = (int) $wallet->balance;
            $balanceAfter = $balanceBefore - $amount;

            $wallet->update([
                'balance' => $balanceAfter,
                'lifetime_used' => (int) $wallet->lifetime_used + $amount,
            ]);

            return PracticeCreditTransaction::create([
                'user_id' => $user->id,
                'academy_session_id' => $session?->id,
                'type' => $type,
                'amount' => -$amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => $description,
                'meta' => $meta ?: null,
            ]);
        });
    }

    public function addCredits(User $user, int $amount, string $type, string $description = null, array $meta = []): PracticeCreditTransaction
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Credit add amount must be greater than zero.');
        }

        return DB::transaction(function () use ($user, $amount, $type, $description, $meta) {
            $wallet = UserPracticeCredit::where('user_id', $user->id)->lockForUpdate()->first()
                ?: $this->getOrCreateWallet($user);

            $balanceBefore = (int) $wallet->balance;
            $balanceAfter = $balanceBefore + $amount;
            $updates = ['balance' => $balanceAfter];

            if (in_array($type, ['signup_bonus', 'course_grant', 'admin_grant'], true)) {
                $updates['lifetime_granted'] = (int) $wallet->lifetime_granted + $amount;
            }

            if ($type === 'purchase') {
                $updates['lifetime_purchased'] = (int) $wallet->lifetime_purchased + $amount;
            }

            $wallet->update($updates);

            return PracticeCreditTransaction::create([
                'user_id' => $user->id,
                'type' => $type,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => $description,
                'meta' => $meta ?: null,
            ]);
        });
    }

    public function refundCredits(User $user, int $amount, ?AcademySession $session = null, string $description = null): PracticeCreditTransaction
    {
        $transaction = $this->addCredits(
            $user,
            $amount,
            'refund',
            $description ?: 'Refund for failed Practice Room session.',
            ['academy_session_id' => $session?->id]
        );

        if ($session) {
            $transaction->update(['academy_session_id' => $session->id]);
        }

        return $transaction;
    }

    public function grantCourseCredits(User $user, int $credits, $course = null): ?PracticeCreditTransaction
    {
        if ($credits <= 0) {
            return null;
        }

        $courseId = $course instanceof Course ? $course->id : ($course?->id ?? null);

        if ($courseId && PracticeCreditTransaction::where('user_id', $user->id)
            ->where('type', 'course_grant')
            ->where('meta->course_id', $courseId)
            ->exists()) {
            return null;
        }

        return $this->addCredits($user, $credits, 'course_grant', 'Course enrollment Practice Room credits', [
            'course_id' => $courseId,
        ]);
    }

    private function hasTransaction(User $user, string $type): bool
    {
        return PracticeCreditTransaction::where('user_id', $user->id)
            ->where('type', $type)
            ->exists();
    }
}
