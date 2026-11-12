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
        // 1. Course Categories & Sub-Categories Table
        if (! Schema::hasTable('course_categories')) {
            Schema::create('course_categories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('parent_id')->nullable()->constrained('course_categories')->cascadeOnDelete();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('icon')->nullable(); // e.g., '🚀', '🎨', '💻', '📈'
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // Add category_id and subcategory_id to courses table if not exists
        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                if (! Schema::hasColumn('courses', 'category_id')) {
                    $table->foreignId('category_id')->nullable()->after('category')->constrained('course_categories')->nullOnDelete();
                }
                if (! Schema::hasColumn('courses', 'subcategory_id')) {
                    $table->foreignId('subcategory_id')->nullable()->after('category_id')->constrained('course_categories')->nullOnDelete();
                }
            });
        }

        // 2. Student Testimonials Table
        if (! Schema::hasTable('testimonials')) {
            Schema::create('testimonials', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('role_title')->nullable(); // e.g. "Growth Package Student", "Top Affiliate"
                $table->string('avatar')->nullable();
                $table->tinyInteger('rating')->default(5);
                $table->text('content');
                $table->string('earning_highlight')->nullable(); // e.g. "Earned ₹1,24,000 in 60 days"
                $table->boolean('is_featured')->default(true);
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // 3. Frequently Asked Questions (FAQs) Table
        if (! Schema::hasTable('faqs')) {
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->string('category')->default('general'); // general, courses, affiliate, payment
                $table->string('question');
                $table->text('answer');
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 4. Blogs & Platform Announcements Table
        if (! Schema::hasTable('blogs')) {
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('category')->default('announcement'); // announcement, training, update, success_story
                $table->string('thumbnail')->nullable();
                $table->text('excerpt')->nullable();
                $table->longText('content');
                $table->string('author_name')->default('SkillLearner Team');
                $table->boolean('is_published')->default(true);
                $table->boolean('is_pinned')->default(false);
                $table->integer('views_count')->default(0);
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                if (Schema::hasColumn('courses', 'subcategory_id')) {
                    $table->dropForeign(['subcategory_id']);
                    $table->dropColumn('subcategory_id');
                }
                if (Schema::hasColumn('courses', 'category_id')) {
                    $table->dropForeign(['category_id']);
                    $table->dropColumn('category_id');
                }
            });
        }

        Schema::dropIfExists('blogs');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('course_categories');
    }
};

