<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('academy_scenarios', function (Blueprint $table) {
            $table->string('heygen_avatar_id')->nullable()->after('audio_url');
            $table->string('heygen_voice_id')->nullable()->after('heygen_avatar_id');
            $table->string('heygen_context_id')->nullable()->after('heygen_voice_id');
        });
    }

    public function down(): void
    {
        Schema::table('academy_scenarios', function (Blueprint $table) {
            $table->dropColumn(['heygen_avatar_id', 'heygen_voice_id', 'heygen_context_id']);
        });
    }
};
