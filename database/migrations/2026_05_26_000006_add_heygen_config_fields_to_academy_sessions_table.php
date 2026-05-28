<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            $table->string('heygen_avatar_id')->nullable()->after('heygen_session_id');
            $table->string('heygen_voice_id')->nullable()->after('heygen_avatar_id');
            $table->string('heygen_context_id')->nullable()->after('heygen_voice_id');
            $table->longText('dynamic_instructions')->nullable()->after('transcript');
            $table->json('config_source')->nullable()->after('dynamic_instructions');
        });
    }

    public function down(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            $table->dropColumn(['heygen_avatar_id', 'heygen_voice_id', 'heygen_context_id', 'dynamic_instructions', 'config_source']);
        });
    }
};
