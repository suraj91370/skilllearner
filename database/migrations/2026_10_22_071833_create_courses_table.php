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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->string('package_name')->nullable();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('badge')->nullable();
            $table->string('instructor')->nullable();
            $table->string('instructor_avatar')->nullable();
            $table->string('banner_title')->nullable();
            $table->string('banner_tag')->nullable();
            $table->string('accent', 30)->nullable();
            $table->string('gradient')->nullable();
            $table->integer('lessons')->default(0);
            $table->string('duration', 50)->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->text('tagline')->nullable();
            $table->longText('description')->nullable();
            $table->json('what_you_learn')->nullable();
            $table->json('modules')->nullable();
            $table->json('requirements')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
