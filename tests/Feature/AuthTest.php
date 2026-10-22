<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that login screen renders properly.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login & Register');
    }

    /**
     * Test user can authenticate using the login screen.
     */
    public function test_users_can_authenticate_using_database_credentials(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'vansh@skilllearner.com'],
            [
                'name' => 'Vansh Tandon',
                'password' => Hash::make('password123'),
                'phone' => '+91 98765 43210',
                'affiliate_id' => 'SL-8821',
            ]
        );

        $response = $this->post('/login', [
            'username' => 'vansh@skilllearner.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/my-courses');
    }

    /**
     * Test authentication fails with wrong password.
     */
    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        $this->post('/login', [
            'username' => 'vansh@skilllearner.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /**
     * Test registration of a new user.
     */
    public function test_new_user_can_register(): void
    {
        $email = 'test_affiliate_'.rand(1000, 9999).'@example.com';

        $response = $this->post('/register-user', [
            'name' => 'Rajesh Sharma',
            'email' => $email,
            'phone' => '+91 91234 56789',
            'password' => 'secret123',
            'package' => 'Advance Package',
            'sponsor_id' => 'SL-8821',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => 'Rajesh Sharma',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/my-courses');
    }

    /**
     * Test user can log out.
     */
    public function test_user_can_logout(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'vansh@skilllearner.com'],
            [
                'name' => 'Vansh Tandon',
                'password' => Hash::make('password123'),
            ]
        );

        $response = $this->actingAs($user)->get('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
