<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('user_practice_sessions')) {
            Schema::create('user_practice_sessions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
                $table->unsignedInteger('monthly_minutes_allocated')->default(0);
                $table->unsignedInteger('monthly_minutes_used')->default(0);
                $table->unsignedInteger('purchased_minutes')->default(0);
                $table->unsignedInteger('total_available_minutes')->default(0);
                $table->timestamp('last_reset_at')->nullable();
                $table->timestamp('monthly_reset_date')->nullable();
                $table->timestamps();
            });
        }

        if (Schema::hasTable('user_practice_balances')) {
            DB::table('user_practice_balances')->orderBy('id')->each(function ($balance) {
                DB::table('user_practice_sessions')->updateOrInsert(
                    ['user_id' => $balance->user_id],
                    [
                        'monthly_minutes_allocated' => $balance->monthly_minutes_allocated ?? 0,
                        'monthly_minutes_used' => $balance->monthly_minutes_used ?? 0,
                        'purchased_minutes' => $balance->purchased_minutes ?? 0,
                        'total_available_minutes' => $balance->total_available_minutes ?? 0,
                        'last_reset_at' => $balance->last_reset_at,
                        'monthly_reset_date' => $balance->monthly_reset_date,
                        'created_at' => $balance->created_at ?? now(),
                        'updated_at' => $balance->updated_at ?? now(),
                    ]
                );
            });
        }

        if (! Schema::hasTable('avatar_usage_logs')) {
            Schema::create('avatar_usage_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('academy_session_id')->nullable()->constrained('academy_sessions')->nullOnDelete();
                $table->string('session_type')->default('practice');
                $table->timestamp('started_at')->nullable();
                $table->timestamp('ended_at')->nullable();
                $table->unsignedInteger('minutes_used')->default(0);
                $table->unsignedInteger('credits_consumed')->default(0);
                $table->string('source')->default('monthly');
                $table->timestamps();
                $table->index(['user_id', 'session_type']);
                $table->index('started_at');
            });
        } elseif (! Schema::hasColumn('avatar_usage_logs', 'credits_consumed')) {
            Schema::table('avatar_usage_logs', function (Blueprint $table) {
                $table->unsignedInteger('credits_consumed')->default(0)->after('minutes_used');
            });
        }

        if (Schema::hasTable('practice_usage_logs')) {
            DB::table('practice_usage_logs')->orderBy('id')->each(function ($log) {
                DB::table('avatar_usage_logs')->updateOrInsert(
                    ['academy_session_id' => $log->academy_session_id, 'user_id' => $log->user_id, 'started_at' => $log->started_at],
                    [
                        'session_type' => $log->session_type ?? 'practice',
                        'ended_at' => $log->ended_at,
                        'minutes_used' => $log->minutes_used ?? 0,
                        'credits_consumed' => ((int) ($log->minutes_used ?? 0)) * 2,
                        'source' => $log->source ?? 'monthly',
                        'created_at' => $log->created_at ?? now(),
                        'updated_at' => $log->updated_at ?? now(),
                    ]
                );
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('avatar_usage_logs');
        Schema::dropIfExists('user_practice_sessions');
    }
};
