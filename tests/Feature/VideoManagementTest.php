<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VideoManagementTest extends TestCase
{
    protected User $superAdmin;

    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@skilllearner.com'],
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

        $this->regularUser = User::updateOrCreate(
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

    public function test_super_admin_can_access_video_management(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->withSession(['user' => ['role' => 'super_admin', 'name' => 'Alex Rivera']])
            ->get('/admin/videos');

        $response->assertStatus(200);
        $response->assertSee('Video Option &amp; Show/Hide Control', false);
        $response->assertSee('Add New Video');
    }

    public function test_regular_user_cannot_access_super_admin_video_management(): void
    {
        $response = $this->actingAs($this->regularUser)
            ->withSession(['user' => ['role' => 'user', 'name' => 'Vansh Tandon']])
            ->get('/admin/videos');

        $response->assertRedirect('/my-courses');
        $response->assertSessionHas('error');
    }

    public function test_super_admin_can_create_new_video(): void
    {
        $videoData = [
            'title' => 'Test Automated Video Creation',
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
            'description' => 'Test description for video management',
            'duration' => '10m 00s',
            'category' => 'Affiliate Training',
            'badge' => 'New',
            'is_visible' => 1,
        ];

        $response = $this->actingAs($this->superAdmin)
            ->withSession(['user' => ['role' => 'super_admin', 'name' => 'Alex Rivera']])
            ->post('/admin/videos', $videoData);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('videos', ['title' => 'Test Automated Video Creation']);
    }

    public function test_super_admin_can_toggle_video_show_and_hide(): void
    {
        $video = Video::create([
            'title' => 'Toggle Visibility Test Video',
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
            'is_visible' => true,
        ]);

        // Toggle from Visible (true) -> Hidden (false)
        $response = $this->actingAs($this->superAdmin)
            ->withSession(['user' => ['role' => 'super_admin', 'name' => 'Alex Rivera']])
            ->postJson("/admin/videos/{$video->id}/toggle-visibility");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_visible' => false,
        ]);

        $this->assertFalse($video->fresh()->is_visible);

        // Toggle back from Hidden (false) -> Visible (true)
        $response2 = $this->actingAs($this->superAdmin)
            ->withSession(['user' => ['role' => 'super_admin', 'name' => 'Alex Rivera']])
            ->postJson("/admin/videos/{$video->id}/toggle-visibility");

        $response2->assertStatus(200);
        $response2->assertJson([
            'success' => true,
            'is_visible' => true,
        ]);

        $this->assertTrue($video->fresh()->is_visible);
    }

    public function test_user_sees_only_visible_videos_and_hidden_videos_are_excluded(): void
    {
        $visibleVideo = Video::create([
            'title' => 'Visible Student Video 12345',
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
            'is_visible' => true,
        ]);

        $hiddenVideo = Video::create([
            'title' => 'Hidden Secret Video 98765',
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
            'is_visible' => false,
        ]);

        $response = $this->actingAs($this->regularUser)
            ->withSession(['user' => ['role' => 'user', 'name' => 'Vansh Tandon']])
            ->get('/videos');

        $response->assertStatus(200);
        $response->assertSee('Visible Student Video 12345');
        $response->assertDontSee('Hidden Secret Video 98765');
    }
}
