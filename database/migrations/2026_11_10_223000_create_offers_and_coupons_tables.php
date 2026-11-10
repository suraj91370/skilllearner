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
        // 1. Add active_income and passive_income to packages table if missing
        if (Schema::hasTable('packages')) {
            Schema::table('packages', function (Blueprint $table) {
                if (! Schema::hasColumn('packages', 'active_income')) {
                    $table->decimal('active_income', 10, 2)->default(0)->after('price');
                }
                if (! Schema::hasColumn('packages', 'passive_income')) {
                    $table->decimal('passive_income', 10, 2)->default(0)->after('active_income');
                }
            });
        }

        // 2. Create offers table (for Flash sales, Festival offers, Global/Package discounts, Bundle deals)
        if (! Schema::hasTable('offers')) {
            Schema::create('offers', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('offer_type')->default('flash_sale'); // flash_sale, festival, discount, bundle
                $table->string('discount_type')->default('percentage'); // percentage, flat, bundle_free
                $table->decimal('discount_value', 10, 2)->default(0);
                $table->string('badge_text')->nullable();
                $table->text('banner_message')->nullable();
                $table->json('applicable_packages')->nullable(); // e.g. ["basic", "growth", "advance", "premium", "infinity"] or ["all"]
                $table->string('bundle_buy_package')->nullable();
                $table->string('bundle_free_package')->nullable();
                $table->boolean('show_timer')->default(true);
                $table->dateTime('starts_at')->nullable();
                $table->dateTime('ends_at')->nullable();
                $table->string('status', 30)->default('active'); // active, paused, expired
                $table->unsignedInteger('uses_count')->default(0);
                $table->decimal('total_discount_given', 12, 2)->default(0);
                $table->timestamps();
            });
        }

        // 3. Create coupons table (for coupon codes with limits, expiry, etc.)
        if (! Schema::hasTable('coupons')) {
            Schema::create('coupons', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->text('description')->nullable();
                $table->string('discount_type')->default('percentage'); // percentage, flat
                $table->decimal('discount_value', 10, 2)->default(0);
                $table->decimal('min_order_amount', 10, 2)->default(0);
                $table->decimal('max_discount_amount', 10, 2)->nullable();
                $table->json('applicable_packages')->nullable(); // e.g. ["all"] or ["advance", "premium"]
                $table->unsignedInteger('usage_limit')->nullable(); // overall limit
                $table->unsignedInteger('per_user_limit')->default(1);
                $table->unsignedInteger('used_count')->default(0);
                $table->dateTime('starts_at')->nullable();
                $table->dateTime('expires_at')->nullable();
                $table->string('status', 30)->default('active'); // active, paused, expired
                $table->timestamps();
            });
        }

        // 4. Create offer_redemptions table (for performance tracking and audit logs)
        if (! Schema::hasTable('offer_redemptions')) {
            Schema::create('offer_redemptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('coupon_id')->nullable();
                $table->unsignedBigInteger('offer_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('user_name')->nullable();
                $table->string('user_email')->nullable();
                $table->string('user_phone')->nullable();
                $table->string('package_slug');
                $table->string('package_name');
                $table->string('code_used')->nullable();
                $table->decimal('original_amount', 10, 2);
                $table->decimal('discount_amount', 10, 2);
                $table->decimal('final_amount', 10, 2);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_redemptions');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('offers');
    }
};

