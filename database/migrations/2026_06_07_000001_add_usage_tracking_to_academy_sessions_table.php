<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            if (! Schema::hasColumn('academy_sessions', 'session_type')) {
                $table->string('session_type', 20)->default('practice')->after('academy_scenario_id');
            }

            if (! Schema::hasColumn('academy_sessions', 'credits_used')) {
                $table->unsignedInteger('credits_used')->default(0)->after('score');
            }

            if (! Schema::hasColumn('academy_sessions', 'duration_seconds')) {
                $table->unsignedInteger('duration_seconds')->nullable()->after('credits_used');
            }

            if (! Schema::hasColumn('academy_sessions', 'evaluation_used')) {
                $table->boolean('evaluation_used')->default(false)->after('duration_seconds');
            }

            if (! Schema::hasColumn('academy_sessions', 'recording_used')) {
                $table->boolean('recording_used')->default(false)->after('evaluation_used');
            }

            if (! Schema::hasColumn('academy_sessions', 'attempt_locked')) {
                $table->boolean('attempt_locked')->default(false)->after('recording_used');
            }
        });
    }

    public function down(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            foreach (['session_type', 'credits_used', 'duration_seconds', 'evaluation_used', 'recording_used', 'attempt_locked'] as $column) {
                if (Schema::hasColumn('academy_sessions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
