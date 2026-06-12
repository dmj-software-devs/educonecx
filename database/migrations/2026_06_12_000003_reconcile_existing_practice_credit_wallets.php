<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('users')
            || ! Schema::hasTable('user_practice_credits')
            || ! Schema::hasTable('practice_credit_transactions')) {
            return;
        }

        $signupCredits = (int) env('PRACTICE_ROOM_NEW_USER_CREDITS', 20);

        DB::table('users')
            ->select('id')
            ->orderBy('id')
            ->chunkById(100, function ($users) use ($signupCredits) {
                foreach ($users as $user) {
                    DB::transaction(function () use ($user, $signupCredits) {
                        $now = now();
                        $wallet = DB::table('user_practice_credits')
                            ->where('user_id', $user->id)
                            ->lockForUpdate()
                            ->first();

                        if (! $wallet) {
                            DB::table('user_practice_credits')->insert([
                                'user_id' => $user->id,
                                'balance' => 0,
                                'lifetime_granted' => 0,
                                'lifetime_purchased' => 0,
                                'lifetime_used' => 0,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]);

                            $wallet = DB::table('user_practice_credits')
                                ->where('user_id', $user->id)
                                ->lockForUpdate()
                                ->first();
                        }

                        $currentBalance = (int) DB::table('practice_credit_transactions')
                            ->where('user_id', $user->id)
                            ->sum('amount');

                        $signupGranted = (int) DB::table('practice_credit_transactions')
                            ->where('user_id', $user->id)
                            ->where('type', 'signup_bonus')
                            ->sum('amount');

                        if ($signupCredits > 0 && $signupGranted < $signupCredits) {
                            $topUp = $signupCredits - max(0, $signupGranted);
                            $balanceBefore = max(0, $currentBalance);
                            $balanceAfter = $balanceBefore + $topUp;

                            DB::table('practice_credit_transactions')->insert([
                                'user_id' => $user->id,
                                'academy_session_id' => null,
                                'type' => 'signup_bonus',
                                'amount' => $topUp,
                                'balance_before' => $balanceBefore,
                                'balance_after' => $balanceAfter,
                                'description' => 'Existing user Practice Room signup credit repair.',
                                'meta' => json_encode(['backfilled' => true, 'repair' => true]),
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]);
                        }

                        $this->recalculateWallet((int) $user->id);
                    });
                }
            }, 'id');
    }

    public function down(): void
    {
        if (! Schema::hasTable('practice_credit_transactions') || ! Schema::hasTable('user_practice_credits')) {
            return;
        }

        DB::table('practice_credit_transactions')
            ->where('type', 'signup_bonus')
            ->where('description', 'Existing user Practice Room signup credit repair.')
            ->orderBy('id')
            ->chunkById(100, function ($transactions) {
                foreach ($transactions as $transaction) {
                    DB::table('practice_credit_transactions')
                        ->where('id', $transaction->id)
                        ->delete();

                    $this->recalculateWallet((int) $transaction->user_id);
                }
            }, 'id');
    }

    private function recalculateWallet(int $userId): void
    {
        $transactions = DB::table('practice_credit_transactions')
            ->where('user_id', $userId);

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

        DB::table('user_practice_credits')
            ->where('user_id', $userId)
            ->update([
                'balance' => $balance,
                'lifetime_granted' => $lifetimeGranted,
                'lifetime_purchased' => $lifetimePurchased,
                'lifetime_used' => $lifetimeUsed,
                'updated_at' => now(),
            ]);
    }
};
