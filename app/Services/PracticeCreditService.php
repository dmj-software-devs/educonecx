<?php

namespace App\Services;

use App\Exceptions\InsufficientPracticeCreditsException;
use App\Models\AcademySession;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
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
        // Free users no longer receive practice-time entitlements. Keep the
        // legacy wallet available only for internal cost accounting/backwards compatibility.
        return $this->getOrCreateWallet($user);
    }

    public function getBalance(User $user): int
    {
        return (int) $this->recalculateWallet($user)->balance;
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
        // Course enrollment no longer grants user-visible practice-time entitlements.
        return null;
    }

    public function recalculateWallet(User $user): UserPracticeCredit
    {
        $wallet = UserPracticeCredit::where('user_id', $user->id)->lockForUpdate()->first()
            ?: $this->getOrCreateWallet($user);

        $transactions = PracticeCreditTransaction::where('user_id', $user->id);
        $balance = max(0, (int) (clone $transactions)->sum('amount'));
        $lifetimeGranted = (int) (clone $transactions)
            ->whereIn('type', ['signup_bonus', 'course_grant', 'admin_grant'])
            ->where('amount', '>', 0)
            ->sum('amount');
        $lifetimePurchased = (int) (clone $transactions)
            ->where('type', 'purchase')
            ->where('amount', '>', 0)
            ->sum('amount');
        $lifetimeUsed = abs((int) (clone $transactions)
            ->where('amount', '<', 0)
            ->sum('amount'));

        $wallet->update([
            'balance' => $balance,
            'lifetime_granted' => $lifetimeGranted,
            'lifetime_purchased' => $lifetimePurchased,
            'lifetime_used' => $lifetimeUsed,
        ]);

        return $wallet->refresh();
    }

    public function minutesToInternalCredits(int $minutes): int
    {
        return max(0, $minutes) * 2;
    }

    public function getOrCreatePracticeBalance(User $user): \App\Models\UserPracticeBalance
    {
        return \App\Models\UserPracticeBalance::firstOrCreate(['user_id' => $user->id]);
    }

    public function syncMonthlyAllocation(User $user): \App\Models\UserPracticeBalance
    {
        $balance = $this->getOrCreatePracticeBalance($user);
        if (! $user->has_active_subscription) {
            $balance->update([
                'monthly_minutes_allocated' => 0,
                'monthly_minutes_used' => 0,
                'total_available_minutes' => 0,
            ]);
            return $balance->refresh();
        }

        $subscription = $user->active_subscription;
        $resetDate = $subscription?->end_date ? \Illuminate\Support\Carbon::parse($subscription->end_date) : now()->addMonth();
        $shouldReset = ! $balance->last_reset_at
            || ! $balance->monthly_reset_date
            || now()->greaterThanOrEqualTo($balance->monthly_reset_date);

        if ($shouldReset) {
            $balance->monthly_minutes_allocated = 20;
            $balance->monthly_minutes_used = 0;
            $balance->last_reset_at = now();
            $balance->monthly_reset_date = $resetDate;
        }

        $balance->total_available_minutes = max(0, ((int) $balance->monthly_minutes_allocated - (int) $balance->monthly_minutes_used) + (int) $balance->purchased_minutes);
        $balance->save();

        return $balance->refresh();
    }

    public function remainingMinutes(User $user): int
    {
        $balance = $this->syncMonthlyAllocation($user);
        return max(0, (int) $balance->total_available_minutes);
    }

    public function addPurchasedMinutes(User $user, int $minutes, string $description = null, array $meta = []): \App\Models\UserPracticeBalance
    {
        if ($minutes <= 0) {
            throw new \InvalidArgumentException('Minutes must be greater than zero.');
        }

        return DB::transaction(function () use ($user, $minutes, $description, $meta) {
            $balance = \App\Models\UserPracticeBalance::where('user_id', $user->id)->lockForUpdate()->first()
                ?: $this->getOrCreatePracticeBalance($user);
            $balance->purchased_minutes = (int) $balance->purchased_minutes + $minutes;
            $balance->save();
            $this->addCredits($user, $this->minutesToInternalCredits($minutes), 'purchase', $description ?: 'Practice session purchase.', $meta + ['minutes' => $minutes]);
            return $this->syncMonthlyAllocation($user);
        });
    }


    public function processPracticeSessionCheckout($checkout, ?User $fallbackUser = null): ?Order
    {
        if ((string) data_get($checkout, 'metadata.type') !== 'practice_sessions') {
            return null;
        }

        if ((string) data_get($checkout, 'payment_status') !== 'paid') {
            return null;
        }

        $stripeSessionId = (string) data_get($checkout, 'id');
        if ($stripeSessionId === '') {
            return null;
        }

        $existing = Order::where('transaction_id', $stripeSessionId)->first();
        if ($existing) {
            return $existing;
        }

        $userId = (int) data_get($checkout, 'metadata.user_id', $fallbackUser?->id);
        $user = $fallbackUser && (int) $fallbackUser->id === $userId ? $fallbackUser : User::find($userId);
        if (! $user) {
            return null;
        }

        $quantity = max(1, (int) data_get($checkout, 'metadata.quantity', 1));
        $minutes = max(20, (int) data_get($checkout, 'metadata.minutes', 20 * $quantity));
        $total = ((float) data_get($checkout, 'amount_total', 0)) / 100;

        return DB::transaction(function () use ($checkout, $stripeSessionId, $user, $quantity, $minutes, $total) {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'PS-' . strtoupper(uniqid()),
                'order_type' => 'practice_sessions',
                'subtotal' => $total,
                'total' => $total,
                'payment_method' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => $stripeSessionId,
                'stripe_session_id' => $stripeSessionId,
                'stripe_payment_intent' => data_get($checkout, 'payment_intent'),
                'stripe_response' => json_encode($checkout),
                'billing_name' => $user->name,
                'billing_email' => $user->email,
                'notes' => 'Purchased ' . $minutes . ' practice minutes via Stripe Checkout.',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'item_type' => 'practice_sessions',
                'course_id' => null,
                'item_name' => $quantity . ' Practice Session' . ($quantity === 1 ? '' : 's'),
                'price' => $total,
                'total' => $total,
            ]);

            $this->addPurchasedMinutes($user, $minutes, 'Practice session add-on purchase.', [
                'quantity' => $quantity,
                'stripe_session_id' => $stripeSessionId,
            ]);

            return $order;
        });
    }

    public function addManualMinutes(User $user, int $minutes, string $reason = null): \App\Models\UserPracticeBalance
    {
        return $this->addPurchasedMinutes($user, $minutes, 'Admin practice time adjustment.', ['reason' => $reason, 'source' => 'admin']);
    }

    public function removeManualMinutes(User $user, int $minutes, string $reason = null): \App\Models\UserPracticeBalance
    {
        return DB::transaction(function () use ($user, $minutes, $reason) {
            $balance = \App\Models\UserPracticeBalance::where('user_id', $user->id)->lockForUpdate()->first()
                ?: $this->getOrCreatePracticeBalance($user);
            $balance->purchased_minutes = max(0, (int) $balance->purchased_minutes - $minutes);
            $balance->save();
            return $this->syncMonthlyAllocation($user);
        });
    }

    public function recordUsageMinutes(User $user, AcademySession $session, int $minutes, string $source = 'session'): \App\Models\PracticeUsageLog
    {
        $minutes = max(1, $minutes);
        return DB::transaction(function () use ($user, $session, $minutes, $source) {
            $balance = \App\Models\UserPracticeBalance::where('user_id', $user->id)->lockForUpdate()->first()
                ?: $this->getOrCreatePracticeBalance($user);
            $remainingMonthly = max(0, (int) $balance->monthly_minutes_allocated - (int) $balance->monthly_minutes_used);
            $fromMonthly = min($remainingMonthly, $minutes);
            $fromPurchased = max(0, $minutes - $fromMonthly);
            $balance->monthly_minutes_used = (int) $balance->monthly_minutes_used + $fromMonthly;
            $balance->purchased_minutes = max(0, (int) $balance->purchased_minutes - $fromPurchased);
            $balance->total_available_minutes = max(0, ((int) $balance->monthly_minutes_allocated - (int) $balance->monthly_minutes_used) + (int) $balance->purchased_minutes);
            $balance->save();

            $session->update([
                'duration_seconds' => $minutes * 60,
                'credits_used' => $this->minutesToInternalCredits($minutes),
                'credit_used' => $this->minutesToInternalCredits($minutes),
            ]);

            $usageSource = $fromPurchased > 0 && $fromMonthly > 0
                ? 'monthly+purchased'
                : ($fromPurchased > 0 ? 'purchased' : 'monthly');

            return \App\Models\PracticeUsageLog::create([
                'user_id' => $user->id,
                'academy_session_id' => $session->id,
                'session_type' => $session->session_type ?: 'practice',
                'started_at' => $session->started_at,
                'ended_at' => $session->ended_at ?: now(),
                'minutes_used' => $minutes,
                'source' => $usageSource,
            ]);
        });
    }

    private function hasTransaction(User $user, string $type): bool
    {
        return PracticeCreditTransaction::where('user_id', $user->id)
            ->where('type', $type)
            ->exists();
    }
}
