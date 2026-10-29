<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ImpersonationTest extends TestCase
{
    protected User $superAdmin;

    protected User $admin;

    protected User $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::updateOrCreate(
            ['email' => 'superadmin_test@skilllearner.com'],
            [
                'name' => 'Super Admin Test',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'affiliate_id' => 'SL-SUPERT',
                'active_package' => 'Infinity Package',
            ]
        );

        $this->admin = User::updateOrCreate(
            ['email' => 'admin_test@skilllearner.com'],
            [
                'name' => 'Admin Test',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'affiliate_id' => 'SL-ADMINT',
                'active_package' => 'Premium Package',
            ]
        );

        $this->student = User::updateOrCreate(
            ['email' => 'student_test@skilllearner.com'],
            [
                'name' => 'Student Test',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'affiliate_id' => 'SL-STUDENTT',
                'active_package' => 'Advance Package',
            ]
        );
    }

    public function test_super_admin_can_impersonate_student_user(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('admin.impersonate', $this->student->id));

        $response->assertRedirect(route('portal.courses'));
        $this->assertEquals($this->student->id, Auth::id());
        $this->assertEquals($this->superAdmin->id, session('impersonated_by'));
        $this->assertEquals($this->student->id, session('user.id'));
    }

    public function test_super_admin_can_impersonate_admin_user(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('admin.impersonate', $this->admin->id));

        $response->assertRedirect(route('admin.users'));
        $this->assertEquals($this->admin->id, Auth::id());
        $this->assertEquals($this->superAdmin->id, session('impersonated_by'));
        $this->assertEquals($this->admin->id, session('user.id'));
    }

    public function test_regular_user_cannot_impersonate(): void
    {
        $response = $this->actingAs($this->student)
            ->get(route('admin.impersonate', $this->admin->id));

        $response->assertRedirect(route('portal.courses'));
        $this->assertEquals($this->student->id, Auth::id());
        $this->assertFalse(session()->has('impersonated_by'));
    }

    public function test_super_admin_can_leave_impersonation_and_return(): void
    {
        // 1. Super admin impersonates student
        $this->actingAs($this->superAdmin)
            ->get(route('admin.impersonate', $this->student->id));

        $this->assertEquals($this->student->id, Auth::id());

        // 2. Leave impersonation
        $leaveResponse = $this->get(route('admin.impersonate.leave'));

        $leaveResponse->assertRedirect(route('admin.users'));
        $this->assertEquals($this->superAdmin->id, Auth::id());
        $this->assertFalse(session()->has('impersonated_by'));
        $this->assertEquals($this->superAdmin->id, session('user.id'));
    }

    public function test_impersonation_banner_renders_when_active(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(route('admin.impersonate', $this->student->id));

        $response = $this->get(route('portal.courses'));

        $response->assertSee('Impersonation Active');
        $response->assertSee('Exit to Super Admin');
    }
}
