<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 60)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('buyer_name');
            $table->string('buyer_email');
            $table->string('buyer_phone', 30)->nullable();
            $table->string('sponsor_id', 50)->nullable()->default('SL-ADMIN');
            $table->string('package_name');
            $table->string('package_slug', 50)->default('advance');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->decimal('original_amount', 10, 2)->default(0.00);
            $table->string('coupon_code', 50)->nullable();
            $table->decimal('coupon_discount', 10, 2)->default(0.00);
            $table->string('payment_method', 40)->default('cashfree'); // cashfree, manual_upi
            $table->string('transaction_id', 100)->nullable(); // Cashfree payment id or UPI UTR
            $table->string('payment_status', 30)->default('pending')->index(); // paid, pending, failed, refunded
            $table->string('failure_reason')->nullable();
            $table->string('refund_status', 30)->default('none')->index(); // none, requested, approved, rejected
            $table->decimal('refund_amount', 10, 2)->default(0.00);
            $table->text('refund_reason')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->string('invoice_number', 60)->nullable()->unique();
            $table->json('gateway_payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
