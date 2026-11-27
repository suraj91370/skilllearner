<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CourseManagementTest extends TestCase
{
    protected User $superAdmin;

    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::where('affiliate_id', 'SL-SUPER')->first()
            ?? User::firstOrCreate(
                ['email' => 'superadmin@skilllearne.org'],
                [
                    'name' => 'Alex Rivera',
                    'password' => Hash::make('password123'),
                    'role' => 'super_admin',
                    'affiliate_id' => 'SL-SUPER',
                    'sponsor_id' => 'SL-MASTER',
                    'active_package' => 'Infinity Package',
                    'wallet_balance' => 95000.00,
                ]
            );

        $this->regularUser = User::where('email', 'user@skilllearner.com')->first()
            ?? User::firstOrCreate(
                ['email' => 'user@skilllearner.com'],
                [
                    'name' => 'Vansh Tandon',
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'affiliate_id' => 'SL-7719',
                    'sponsor_id' => 'SL-ADMIN',
                    'active_package' => 'Advance Package',
                    'wallet_balance' => 8400.00,
                ]
            );
    }

    public function test_super_admin_can_access_course_management(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->withSession(['user' => ['role' => 'super_admin', 'name' => 'Alex Rivera']])
            ->get('/admin/courses');

        $response->assertStatus(200);
        $response->assertSee('Course Management &amp; Show/Hide Control', false);
        $response->assertSee('TOTAL PLATFORM COURSES');
    }

    public function test_regular_user_cannot_access_super_admin_course_management(): void
    {
        $response = $this->actingAs($this->regularUser)
            ->withSession(['user' => ['role' => 'user', 'name' => 'Vansh Tandon']])
            ->get('/admin/courses');

        $response->assertRedirect('/my-courses');
        $response->assertSessionHas('error');
    }

    public function test_super_admin_can_toggle_course_show_and_hide(): void
    {
        $course = Course::firstOrCreate(
            ['slug' => 'test-show-hide-course'],
            [
                'title' => 'Test Show Hide Course',
                'category' => 'Marketing',
                'lessons' => 10,
                'duration' => '2h 30m',
                'is_visible' => true,
            ]
        );
        $course->update(['is_visible' => true]);

        // 1. Toggle to Hidden (false)
        $response = $this->actingAs($this->superAdmin)
            ->withSession(['user' => ['role' => 'super_admin', 'name' => 'Alex Rivera']])
            ->postJson("/admin/courses/{$course->id}/toggle-visibility");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_visible' => false,
        ]);

        $this->assertFalse($course->fresh()->is_visible);

        // 2. Regular user visits /my-courses -> hidden course must NOT be visible
        $studentResponse = $this->actingAs($this->regularUser)
            ->withSession(['user' => ['role' => 'user', 'name' => 'Vansh Tandon']])
            ->get('/my-courses');

        $studentResponse->assertStatus(200);
        $studentResponse->assertDontSee('Test Show Hide Course');

        // 3. Toggle back to Shown (true)
        $response2 = $this->actingAs($this->superAdmin)
            ->withSession(['user' => ['role' => 'super_admin', 'name' => 'Alex Rivera']])
            ->postJson("/admin/courses/{$course->id}/toggle-visibility");

        $response2->assertStatus(200);
        $response2->assertJson([
            'success' => true,
            'is_visible' => true,
        ]);

        $this->assertTrue($course->fresh()->is_visible);

        // 4. Regular user visits /my-courses -> course is visible again
        $studentResponse2 = $this->actingAs($this->regularUser)
            ->withSession(['user' => ['role' => 'user', 'name' => 'Vansh Tandon']])
            ->get('/my-courses');

        $studentResponse2->assertStatus(200);
        $studentResponse2->assertSee('Test Show Hide Course');
    }

    public function test_my_courses_page_displays_card_grid_with_start_now(): void
    {
        $response = $this->actingAs($this->regularUser)
            ->withSession(['user' => ['role' => 'user', 'name' => 'Vansh Tandon']])
            ->get('/my-courses');

        $response->assertStatus(200);
        // Verify key courses matching Image 1
        $response->assertSee('Reel Mastery by Canva');
        $response->assertSee('Canva Graphic Designing');
        $response->assertSee('E-mail Marketing');
        $response->assertSee('START NOW');
    }

    public function test_student_can_open_course_player_with_video_and_lessons_submenu(): void
    {
        $response = $this->actingAs($this->regularUser)
            ->withSession(['user' => ['role' => 'user', 'name' => 'Vansh Tandon']])
            ->get('/my-courses/reel-mastery-by-canva');

        $response->assertStatus(200);
        // Verify Image 2 elements
        $response->assertSee('COURSE VIDEO');
        $response->assertSee('COURSE LESSONS');
        $response->assertSee('DOWNLOAD CERTIFICATE');
        $response->assertSee('Reels Mastery Intro');
        $response->assertSee('Reels Mastery Part 1');
        $response->assertSee('Prev');
        $response->assertSee('Next');
    }
}
