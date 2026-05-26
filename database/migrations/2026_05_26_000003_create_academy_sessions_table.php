<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('academy_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('academy_category_id')->nullable()->constrained('academy_categories')->nullOnDelete();
            $table->foreignId('academy_scenario_id')->nullable()->constrained('academy_scenarios')->nullOnDelete();
            $table->string('heygen_session_id')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('score', 4, 2)->nullable();
            $table->longText('feedback')->nullable();
            $table->longText('transcript')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academy_sessions');
    }
};
