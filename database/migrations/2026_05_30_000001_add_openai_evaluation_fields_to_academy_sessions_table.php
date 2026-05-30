<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            if (! Schema::hasColumn('academy_sessions', 'transcript')) {
                $table->longText('transcript')->nullable()->after('feedback');
            }

            if (! Schema::hasColumn('academy_sessions', 'grammar_score')) {
                $table->decimal('grammar_score', 5, 2)->nullable()->after('transcript');
            }

            if (! Schema::hasColumn('academy_sessions', 'fluency_score')) {
                $table->decimal('fluency_score', 5, 2)->nullable()->after('grammar_score');
            }

            if (! Schema::hasColumn('academy_sessions', 'vocabulary_score')) {
                $table->decimal('vocabulary_score', 5, 2)->nullable()->after('fluency_score');
            }

            if (! Schema::hasColumn('academy_sessions', 'pronunciation_score')) {
                $table->decimal('pronunciation_score', 5, 2)->nullable()->after('vocabulary_score');
            }

            if (! Schema::hasColumn('academy_sessions', 'overall_score')) {
                $table->decimal('overall_score', 5, 2)->nullable()->after('pronunciation_score');
            }

            if (! Schema::hasColumn('academy_sessions', 'corrections')) {
                $table->json('corrections')->nullable()->after('overall_score');
            }

            if (! Schema::hasColumn('academy_sessions', 'strengths')) {
                $table->json('strengths')->nullable()->after('corrections');
            }

            if (! Schema::hasColumn('academy_sessions', 'weaknesses')) {
                $table->json('weaknesses')->nullable()->after('strengths');
            }

            if (! Schema::hasColumn('academy_sessions', 'ai_evaluation')) {
                $table->json('ai_evaluation')->nullable()->after('feedback');
            }

            if (! Schema::hasColumn('academy_sessions', 'evaluated_at')) {
                $table->timestamp('evaluated_at')->nullable()->after('ai_evaluation');
            }
        });
    }

    public function down(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            $columns = [
                'grammar_score',
                'fluency_score',
                'vocabulary_score',
                'pronunciation_score',
                'overall_score',
                'corrections',
                'strengths',
                'weaknesses',
                'ai_evaluation',
                'evaluated_at',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('academy_sessions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
