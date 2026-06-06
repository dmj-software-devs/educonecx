<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            if (! Schema::hasColumn('academy_sessions', 'session_type')) {
                $table->string('session_type')->default('practice')->after('status');
            }

            if (! Schema::hasColumn('academy_sessions', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('ended_at');
            }

            if (! Schema::hasColumn('academy_sessions', 'is_locked')) {
                $table->boolean('is_locked')->default(false)->after('submitted_at');
            }

            if (! Schema::hasColumn('academy_sessions', 'locked_at')) {
                $table->timestamp('locked_at')->nullable()->after('is_locked');
            }

            if (! Schema::hasColumn('academy_sessions', 'exam_score')) {
                $table->decimal('exam_score', 5, 2)->nullable()->after('overall_score');
            }

            if (! Schema::hasColumn('academy_sessions', 'exam_result')) {
                $table->string('exam_result')->nullable()->after('exam_score');
            }

            if (! Schema::hasColumn('academy_sessions', 'credit_used')) {
                $table->unsignedInteger('credit_used')->default(0)->after('exam_result');
            }
        });
    }

    public function down(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            foreach (['session_type', 'submitted_at', 'is_locked', 'locked_at', 'exam_score', 'exam_result', 'credit_used'] as $column) {
                if (Schema::hasColumn('academy_sessions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
