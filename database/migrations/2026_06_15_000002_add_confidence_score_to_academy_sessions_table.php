<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            if (! Schema::hasColumn('academy_sessions', 'confidence_score')) {
                $table->decimal('confidence_score', 5, 2)->nullable()->after('vocabulary_score');
            }
        });
    }

    public function down(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            if (Schema::hasColumn('academy_sessions', 'confidence_score')) {
                $table->dropColumn('confidence_score');
            }
        });
    }
};
