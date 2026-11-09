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
        if (! Schema::hasTable('mentors')) {
            Schema::create('mentors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('phone', 50)->nullable();
                $table->string('photo')->nullable();
                $table->text('bio')->nullable();
                $table->string('expertise')->nullable();
                $table->string('experience', 100)->nullable();
                $table->string('qualification')->nullable();
                $table->json('social_links')->nullable();
                $table->json('assigned_courses')->nullable();
                $table->decimal('commission_percentage', 5, 2)->default(15.00);
                $table->string('status', 30)->default('active'); // active, blocked
                $table->string('kyc_status', 30)->default('approved'); // pending, approved, rejected
                $table->string('pan_number', 30)->nullable();
                $table->string('aadhar_number', 30)->nullable();
                $table->string('bank_name')->nullable();
                $table->string('holder_name')->nullable();
                $table->string('account_number')->nullable();
                $table->string('ifsc_code', 30)->nullable();
                $table->string('upi_id')->nullable();
                $table->string('kyc_document')->nullable();
                $table->decimal('total_earned', 10, 2)->default(0.00);
                $table->decimal('wallet_balance', 10, 2)->default(0.00);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('mentor_payouts')) {
            Schema::create('mentor_payouts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('mentor_id')->constrained('mentors')->cascadeOnDelete();
                $table->decimal('amount', 10, 2);
                $table->string('payment_method', 50)->default('Bank Transfer');
                $table->string('status', 30)->default('pending'); // pending, approved, rejected
                $table->string('transaction_id')->nullable();
                $table->text('notes')->nullable();
                $table->timestamp('processed_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_payouts');
        Schema::dropIfExists('mentors');
    }
};
