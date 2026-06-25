<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('practice_session_packages')
            ->where('price', 10.00)
            ->where('minutes', 20)
            ->update([
                'minutes' => 30,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('practice_session_packages')
            ->where('price', 10.00)
            ->where('minutes', 30)
            ->update([
                'minutes' => 20,
                'updated_at' => now(),
            ]);
    }
};
