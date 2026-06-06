<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_practice_credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('balance')->default(0);
            $table->unsignedInteger('lifetime_used')->default(0);
            $table->unsignedInteger('lifetime_granted')->default(0);
            $table->timestamps();
        });

        Schema::create('practice_credit_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('academy_session_id')->nullable()->constrained('academy_sessions')->nullOnDelete();
            $table->string('type');
            $table->integer('amount');
            $table->unsignedInteger('balance_after')->default(0);
            $table->string('description')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practice_credit_transactions');
        Schema::dropIfExists('user_practice_credits');
    }
};
