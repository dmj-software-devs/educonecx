<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            if (! Schema::hasColumn('academy_sessions', 'avatar_name')) {
                $table->string('avatar_name')->nullable()->after('raw_response');
            }

            if (! Schema::hasColumn('academy_sessions', 'avatar_image_url')) {
                $table->text('avatar_image_url')->nullable()->after('avatar_name');
            }

            if (! Schema::hasColumn('academy_sessions', 'context_name')) {
                $table->string('context_name')->nullable()->after('avatar_image_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            foreach (['avatar_name', 'avatar_image_url', 'context_name'] as $column) {
                if (Schema::hasColumn('academy_sessions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
