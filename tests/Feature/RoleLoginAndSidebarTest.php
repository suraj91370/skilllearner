<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleLoginAndSidebarTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure the 3 test users exist
        User::updateOrCreate(
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

        User::updateOrCreate(
            ['email' => 'admin@skilllearner.com'],
            [
                'name' => 'Pooja Sharma',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'affiliate_id' => 'SL-ADMIN01',
                'sponsor_id' => 'SL-SUPER',
                'active_package' => 'Premium Package',
                'wallet_balance' => 42000.00,
            ]
        );

        User::updateOrCreate(
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

    public function test_login_page_renders_unified_form_and_quick_switch(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Log In to SkillLearner');
        $response->assertSee('superadmin@skilllearner.com');
        $response->assertSee('admin@skilllearner.com');
        $response->assertSee('user@skilllearner.com');
    }

    public function test_super_admin_login_and_full_sidebar_visibility(): void
    {
        $loginResponse = $this->post('/login', [
            'username' => 'superadmin@skilllearner.com',
            'password' => 'password123',
        ]);

        // Everyone redirects to the 1 single page: /my-courses
        $loginResponse->assertRedirect('/my-courses');

        $superAdmin = User::where('email', 'superadmin@skilllearner.com')->first();
        $this->assertAuthenticatedAs($superAdmin);

        // On the 1 single /my-courses page, sidebar dynamically shows Super Admin sections
        $coursesResponse = $this->actingAs($superAdmin)->get('/my-courses');
        $coursesResponse->assertStatus(200);
        $coursesResponse->assertSee('Super Admin');
        $coursesResponse->assertSee('Administration');
        $coursesResponse->assertSee('All Users');
        $coursesResponse->assertSee('KYC Approvals');
        $coursesResponse->assertSee('Payout Approvals');
        $coursesResponse->assertSee('System Settings');
        $coursesResponse->assertDontSee('Affiliate Tools');

        // Super Admin can access all admin management routes
        $usersResponse = $this->actingAs($superAdmin)->get('/admin/users');
        $usersResponse->assertStatus(200);
        $usersResponse->assertSee('Super Admin');

        $settingsResponse = $this->actingAs($superAdmin)->get('/admin/settings');
        $settingsResponse->assertStatus(200);
        $settingsResponse->assertSee('Platform &amp; System Configuration', false);
    }

    public function test_admin_login_and_restricted_sidebar_visibility(): void
    {
        $loginResponse = $this->post('/login', [
            'username' => 'admin@skilllearner.com',
            'password' => 'password123',
        ]);

        // Everyone redirects to the 1 single page: /my-courses
        $loginResponse->assertRedirect('/my-courses');

        $admin = User::where('email', 'admin@skilllearner.com')->first();
        $this->assertAuthenticatedAs($admin);

        // On the 1 single /my-courses page, sidebar dynamically shows Admin sections
        $coursesResponse = $this->actingAs($admin)->get('/my-courses');
        $coursesResponse->assertStatus(200);
        $coursesResponse->assertSee('Admin');
        $coursesResponse->assertSee('Administration');
        $coursesResponse->assertSee('All Users');
        $coursesResponse->assertSee('KYC Approvals');
        $coursesResponse->assertSee('Payout Approvals');

        // In sidebar on /my-courses, System Settings and Student Affiliate Tools are HIDDEN
        $coursesResponse->assertDontSee('System Settings');
        $coursesResponse->assertDontSee('Affiliate Tools');

        // Admin cannot access Super Admin exclusive settings page directly
        $settingsResponse = $this->actingAs($admin)->get('/admin/settings');
        $settingsResponse->assertRedirect('/my-courses');
        $settingsResponse->assertSessionHas('error');
    }

    public function test_user_login_and_hidden_admin_sections(): void
    {
        $loginResponse = $this->post('/login', [
            'username' => 'user@skilllearner.com',
            'password' => 'password123',
        ]);

        // Everyone redirects to the 1 single page: /my-courses
        $loginResponse->assertRedirect('/my-courses');

        $user = User::where('email', 'user@skilllearner.com')->first();
        $this->assertAuthenticatedAs($user);

        // User views the 1 single /my-courses page
        $portalResponse = $this->actingAs($user)->get('/my-courses');
        $portalResponse->assertStatus(200);

        // Sidebar for User displays student tools
        $portalResponse->assertSee('Student / User');
        $portalResponse->assertSee('My Course');
        $portalResponse->assertSee('Affiliate Link');
        $portalResponse->assertSee('Token Purchases');
        $portalResponse->assertSee('Upgrade');
        $portalResponse->assertSee('Affiliate Tools');

        // Administration section is completely HIDDEN for User
        $portalResponse->assertDontSee('Administration');
        $portalResponse->assertDontSee('All Users');
        $portalResponse->assertDontSee('KYC Approvals');
        $portalResponse->assertDontSee('Payout Approvals');
        $portalResponse->assertDontSee('System Settings');

        // User cannot access admin routes directly -> redirected to /my-courses
        $adminAccessResponse = $this->actingAs($user)->get('/admin/users');
        $adminAccessResponse->assertRedirect('/my-courses');
        $adminAccessResponse->assertSessionHas('error');

        $settingsAccessResponse = $this->actingAs($user)->get('/admin/settings');
        $settingsAccessResponse->assertRedirect('/my-courses');
        $settingsAccessResponse->assertSessionHas('error');
    }
}
