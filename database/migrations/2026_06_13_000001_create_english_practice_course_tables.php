<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('english_practice_courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('level')->nullable();
            $table->string('status')->default('draft');
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->index(['status', 'sort_order']);
        });

        Schema::create('english_practice_course_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('english_practice_course_id')->constrained('english_practice_courses')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('status')->default('published');
            $table->timestamps();

            $table->index(['english_practice_course_id', 'status', 'sort_order'], 'ep_modules_course_status_sort_idx');
        });

        Schema::create('english_practice_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('english_practice_course_id')->constrained('english_practice_courses')->cascadeOnDelete();
            $table->foreignId('english_practice_course_module_id')->nullable()->constrained('english_practice_course_modules')->nullOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('video_type')->default('upload');
            $table->string('video_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_free')->default(false);
            $table->string('status')->default('published');
            $table->timestamps();

            $table->unique(['english_practice_course_id', 'slug'], 'ep_lessons_course_slug_unique');
            $table->index(['english_practice_course_id', 'status', 'sort_order'], 'ep_lessons_course_status_sort_idx');
        });

        Schema::create('english_practice_lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('english_practice_lesson_id')->constrained('english_practice_lessons')->cascadeOnDelete();
            $table->integer('watched_seconds')->default(0);
            $table->integer('duration_seconds')->nullable();
            $table->decimal('progress_percent', 5, 2)->default(0);
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('last_watched_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'english_practice_lesson_id'], 'ep_progress_user_lesson_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('english_practice_lesson_progress');
        Schema::dropIfExists('english_practice_lessons');
        Schema::dropIfExists('english_practice_course_modules');
        Schema::dropIfExists('english_practice_courses');
    }
};
