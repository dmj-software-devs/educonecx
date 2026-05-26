<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('academy_scenarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academy_category_id')->constrained('academy_categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('level')->nullable();
            $table->text('description')->nullable();
            $table->longText('practice_text');
            $table->longText('avatar_instructions')->nullable();
            $table->json('sample_questions')->nullable();
            $table->string('video_url')->nullable();
            $table->string('audio_url')->nullable();
            $table->string('status')->default('active');
            $table->unsignedInteger('sort_order')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academy_scenarios');
    }
};
