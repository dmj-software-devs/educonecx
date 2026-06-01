<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            if (! Schema::hasColumn('academy_sessions', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('academy_sessions', 'academy_category_id')) {
                $table->foreignId('academy_category_id')->nullable()->constrained('academy_categories')->nullOnDelete();
            }

            if (! Schema::hasColumn('academy_sessions', 'academy_scenario_id')) {
                $table->foreignId('academy_scenario_id')->nullable()->constrained('academy_scenarios')->nullOnDelete();
            }

            if (! Schema::hasColumn('academy_sessions', 'liveavatar_embed_id')) {
                $table->string('liveavatar_embed_id')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'liveavatar_embed_url')) {
                $table->text('liveavatar_embed_url')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'heygen_avatar_id')) {
                $table->string('heygen_avatar_id')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'heygen_voice_id')) {
                $table->string('heygen_voice_id')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'heygen_context_id')) {
                $table->string('heygen_context_id')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'audio_path')) {
                $table->string('audio_path')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'transcript')) {
                $table->longText('transcript')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'pronunciation_score')) {
                $table->decimal('pronunciation_score', 5, 2)->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'grammar_score')) {
                $table->decimal('grammar_score', 5, 2)->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'fluency_score')) {
                $table->decimal('fluency_score', 5, 2)->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'vocabulary_score')) {
                $table->decimal('vocabulary_score', 5, 2)->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'overall_score')) {
                $table->decimal('overall_score', 5, 2)->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'corrections')) {
                $table->json('corrections')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'strengths')) {
                $table->json('strengths')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'weaknesses')) {
                $table->json('weaknesses')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'next_steps')) {
                $table->json('next_steps')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'feedback')) {
                $table->longText('feedback')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'ai_evaluation')) {
                $table->json('ai_evaluation')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'raw_response')) {
                $table->json('raw_response')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'status')) {
                $table->string('status')->default('pending');
            }

            if (! Schema::hasColumn('academy_sessions', 'started_at')) {
                $table->timestamp('started_at')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'ended_at')) {
                $table->timestamp('ended_at')->nullable();
            }

            if (! Schema::hasColumn('academy_sessions', 'evaluated_at')) {
                $table->timestamp('evaluated_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            foreach (['liveavatar_embed_id', 'liveavatar_embed_url', 'next_steps'] as $column) {
                if (Schema::hasColumn('academy_sessions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
