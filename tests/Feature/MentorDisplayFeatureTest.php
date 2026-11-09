<?php

namespace Tests\Feature;

use App\Models\Mentor;
use App\Models\User;
use Tests\TestCase;

class MentorDisplayFeatureTest extends TestCase
{
    public function test_homepage_displays_featured_mentors(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Adarsh Pandey', false);
        $response->assertSee('Ravi Gond', false);
        $response->assertSee('PAVAN PRAJAPATI', false);
        $response->assertSee('SOUMYADIP PANIA', false);
    }

    public function test_super_admin_can_toggle_mentor_featured_status(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'superadmin@skilllearner.com'],
            [
                'name' => 'Super Admin',
                'role' => 'super_admin',
                'password' => bcrypt('password'),
            ]
        );

        $mentor = Mentor::where('email', 'adarsh.pandey@skilllearner.com')->first();
        $this->assertNotNull($mentor);
        $this->assertTrue((bool) $mentor->is_featured);

        // Toggle to false
        $response = $this->actingAs($admin)->post(route('admin.mentors.toggle-featured', $mentor));
        $response->assertRedirect();

        $mentor->refresh();
        $this->assertFalse((bool) $mentor->is_featured);

        // Toggle back to true
        $response = $this->actingAs($admin)->post(route('admin.mentors.toggle-featured', $mentor));
        $response->assertRedirect();

        $mentor->refresh();
        $this->assertTrue((bool) $mentor->is_featured);
    }

    public function test_admin_mentors_management_page_renders_successfully(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'superadmin@skilllearner.com'],
            [
                'name' => 'Super Admin',
                'role' => 'super_admin',
                'password' => bcrypt('password'),
            ]
        );

        $response = $this->actingAs($admin)->get(route('admin.mentors'));

        $response->assertStatus(200);
        $response->assertSee('Mentor Management');
        $response->assertSee('On Home');
    }
}
