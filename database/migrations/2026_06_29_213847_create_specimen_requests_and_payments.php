<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('specimen_requests')) {
            Schema::create('specimen_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
                $table->string('request_number')->nullable()->index();
                $table->string('pickup_address')->nullable();
                $table->string('delivery_address')->nullable();
                $table->string('specimen_type')->nullable();
                $table->string('status')->default('pending')->index();
                $table->decimal('quoted_amount', 10, 2)->default(0);
                $table->string('payment_status')->default('unpaid')->index();
                $table->timestamp('paid_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->string('recipient_name')->nullable();
                $table->text('delivery_notes')->nullable();
                $table->longText('signature')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'specimen_request_id')) {
                $table->foreignId('specimen_request_id')->nullable()->after('subscription_id')->constrained('specimen_requests')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'specimen_request_id')) {
                $table->dropConstrainedForeignId('specimen_request_id');
            }
        });

        Schema::dropIfExists('specimen_requests');
    }
};
