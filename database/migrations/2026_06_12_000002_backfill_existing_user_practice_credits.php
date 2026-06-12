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

        if ($signupCredits <= 0) {
            return;
        }

        DB::table('users')
            ->select('id')
            ->orderBy('id')
            ->chunkById(100, function ($users) use ($signupCredits) {
                foreach ($users as $user) {
                    $alreadyGranted = DB::table('practice_credit_transactions')
                        ->where('user_id', $user->id)
                        ->where('type', 'signup_bonus')
                        ->exists();

                    if ($alreadyGranted) {
                        continue;
                    }

                    $wallet = DB::table('user_practice_credits')
                        ->where('user_id', $user->id)
                        ->first();

                    if (! $wallet) {
                        $now = now();
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
                            ->first();
                    }

                    $balanceBefore = (int) ($wallet->balance ?? 0);
                    $balanceAfter = $balanceBefore + $signupCredits;
                    $now = now();

                    DB::table('user_practice_credits')
                        ->where('user_id', $user->id)
                        ->update([
                            'balance' => $balanceAfter,
                            'lifetime_granted' => (int) ($wallet->lifetime_granted ?? 0) + $signupCredits,
                            'updated_at' => $now,
                        ]);

                    DB::table('practice_credit_transactions')->insert([
                        'user_id' => $user->id,
                        'academy_session_id' => null,
                        'type' => 'signup_bonus',
                        'amount' => $signupCredits,
                        'balance_before' => $balanceBefore,
                        'balance_after' => $balanceAfter,
                        'description' => 'Existing user Practice Room signup bonus.',
                        'meta' => json_encode(['backfilled' => true]),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
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
            ->where('description', 'Existing user Practice Room signup bonus.')
            ->orderBy('id')
            ->chunkById(100, function ($transactions) {
                foreach ($transactions as $transaction) {
                    DB::table('user_practice_credits')
                        ->where('user_id', $transaction->user_id)
                        ->update([
                            'balance' => DB::raw('GREATEST(balance - ' . (int) $transaction->amount . ', 0)'),
                            'lifetime_granted' => DB::raw('GREATEST(lifetime_granted - ' . (int) $transaction->amount . ', 0)'),
                            'updated_at' => now(),
                        ]);

                    DB::table('practice_credit_transactions')
                        ->where('id', $transaction->id)
                        ->delete();
                }
            }, 'id');
    }
};
