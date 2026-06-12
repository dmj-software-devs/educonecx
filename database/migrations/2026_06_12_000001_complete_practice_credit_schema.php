<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_practice_credits', function (Blueprint $table) {
            if (! Schema::hasColumn('user_practice_credits', 'lifetime_purchased')) {
                $table->unsignedInteger('lifetime_purchased')->default(0)->after('lifetime_granted');
            }
        });

        Schema::table('practice_credit_transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('practice_credit_transactions', 'balance_before')) {
                $table->unsignedInteger('balance_before')->default(0)->after('amount');
            }
        });

        Schema::table('academy_sessions', function (Blueprint $table) {
            if (! Schema::hasColumn('academy_sessions', 'credit_transaction_id')) {
                $table->foreignId('credit_transaction_id')
                    ->nullable()
                    ->after('credit_used')
                    ->constrained('practice_credit_transactions')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('academy_sessions', function (Blueprint $table) {
            if (Schema::hasColumn('academy_sessions', 'credit_transaction_id')) {
                $table->dropConstrainedForeignId('credit_transaction_id');
            }
        });

        Schema::table('practice_credit_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('practice_credit_transactions', 'balance_before')) {
                $table->dropColumn('balance_before');
            }
        });

        Schema::table('user_practice_credits', function (Blueprint $table) {
            if (Schema::hasColumn('user_practice_credits', 'lifetime_purchased')) {
                $table->dropColumn('lifetime_purchased');
            }
        });
    }
};
