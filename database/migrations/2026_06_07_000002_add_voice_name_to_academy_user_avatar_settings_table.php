<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('academy_user_avatar_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('academy_user_avatar_settings', 'voice_name')) {
                $table->string('voice_name')->nullable()->after('heygen_voice_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('academy_user_avatar_settings', function (Blueprint $table) {
            if (Schema::hasColumn('academy_user_avatar_settings', 'voice_name')) {
                $table->dropColumn('voice_name');
            }
        });
    }
};
