<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('academy_user_avatar_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('heygen_avatar_id')->nullable();
            $table->string('heygen_voice_id')->nullable();
            $table->string('heygen_context_id')->nullable();
            $table->string('preferred_language')->nullable();
            $table->string('speaking_level')->nullable();
            $table->string('tutor_style')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academy_user_avatar_settings');
    }
};
