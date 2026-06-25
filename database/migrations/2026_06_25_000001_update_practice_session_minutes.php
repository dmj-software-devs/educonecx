<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('practice_session_packages')) {
            DB::table('practice_session_packages')
                ->where('price', 10.00)
                ->update([
                    'minutes' => 30,
                    'updated_at' => now(),
                ]);
        }

        foreach (['user_practice_sessions', 'user_practice_balances'] as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            DB::table($table)
                ->where('monthly_minutes_allocated', 20)
                ->update([
                    'monthly_minutes_allocated' => 15,
                    'total_available_minutes' => DB::raw('GREATEST((15 - monthly_minutes_used), 0) + purchased_minutes'),
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('practice_session_packages')) {
            DB::table('practice_session_packages')
                ->where('price', 10.00)
                ->update([
                    'minutes' => 20,
                    'updated_at' => now(),
                ]);
        }

        foreach (['user_practice_sessions', 'user_practice_balances'] as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            DB::table($table)
                ->where('monthly_minutes_allocated', 15)
                ->update([
                    'monthly_minutes_allocated' => 20,
                    'total_available_minutes' => DB::raw('GREATEST((20 - monthly_minutes_used), 0) + purchased_minutes'),
                    'updated_at' => now(),
                ]);
        }
    }
};
