<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('practice_session_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('minutes');
            $table->decimal('price', 8, 2);
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('user_practice_balances', function (Blueprint $table) {
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

        Schema::create('practice_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('academy_session_id')->nullable()->constrained('academy_sessions')->nullOnDelete();
            $table->string('session_type')->default('practice');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->unsignedInteger('minutes_used')->default(0);
            $table->string('source')->default('monthly');
            $table->timestamps();
            $table->index(['user_id', 'session_type']);
        });

        DB::table('practice_session_packages')->insert([
            'name' => '1 Practice Session',
            'minutes' => 20,
            'price' => 10.00,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('practice_usage_logs');
        Schema::dropIfExists('user_practice_balances');
        Schema::dropIfExists('practice_session_packages');
    }
};
