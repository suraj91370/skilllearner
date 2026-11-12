<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class CashfreePaymentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Clear log file before test
        File::put(storage_path('logs/laravel.log'), '');
    }

    public function test_cashfree_initiate_in_local_test_mode_renders_checkout_and_logs_order(): void
    {
        $response = $this->post(route('payment.cashfree.initiate'), [
            'name' => 'Rohan Test',
            'email' => 'rohan_cf_test@skilllearner.org',
            'phone' => '9876543210',
            'password' => 'password123',
            'package' => 'basic',
            'referral_code' => 'SL-ADMIN',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('payment.cashfree-checkout');
        $response->assertViewHas('isSimulated', true);
        $response->assertSee('LOCAL TEST GATEWAY');
        $response->assertSee('Pay ₹599');

        // Check laravel.log has written the initiation entry
        $logContent = File::get(storage_path('logs/laravel.log'));
        $this->assertStringContainsString('[CASHFREE-GATEWAY] 🚀 INITIATING ORDER (LOCAL TEST SIMULATOR MODE)', $logContent);
        $this->assertStringContainsString('Rohan Test', $logContent);
        $this->assertStringContainsString('rohan_cf_test@skilllearner.org', $logContent);
    }

    public function test_cashfree_callback_with_paid_status_activates_account_and_logs(): void
    {
        $course = Course::firstOrCreate([
            'title' => 'Digital Marketing Basics',
        ], [
            'slug' => 'digital-marketing-basics',
            'description' => 'Test course description',
            'package' => 'Basic Package',
            'status' => 'published',
        ]);

        // First initiate order
        $this->post(route('payment.cashfree.initiate'), [
            'name' => 'Aakash Sharma',
            'email' => 'aakash_cf_test@skilllearner.org',
            'phone' => '9123456789',
            'password' => 'password123',
            'package' => 'basic',
            'referral_code' => 'SL-ADMIN',
        ]);

        $orderData = session('pending_cashfree_order');
        $this->assertNotNull($orderData);
        $orderId = $orderData['order_id'];

        // Now simulate return callback with PAID
        $callbackResponse = $this->get(route('payment.cashfree.callback', [
            'order_id' => $orderId,
            'sim_status' => 'PAID',
        ]));

        $callbackResponse->assertRedirect('/payment-status');
        $callbackResponse->assertSessionHas('success');

        // Verify buyer user is activated
        $user = User::where('email', 'aakash_cf_test@skilllearner.org')->first();
        $this->assertNotNull($user);
        $this->assertEquals('paid', $user->payment_status);
        $this->assertEquals('Basic Package', $user->active_package);

        // Verify courses unlocked
        $unlocked = UserCourse::where('user_id', $user->id)->count();
        $this->assertGreaterThan(0, $unlocked);

        // Verify logs
        $logContent = File::get(storage_path('logs/laravel.log'));
        $this->assertStringContainsString('[CASHFREE-GATEWAY] 📥 PAYMENT RETURN CALLBACK RECEIVED', $logContent);
        $this->assertStringContainsString('Order status verified: \'PAID\'', $logContent);
        $this->assertStringContainsString('Activating User', $logContent);
        $this->assertStringContainsString('Payment Verified Successfully', $logContent);
    }

    public function test_cashfree_callback_with_failed_status_redirects_with_error(): void
    {
        $this->post(route('payment.cashfree.initiate'), [
            'name' => 'Kunal Failed Test',
            'email' => 'kunal_fail_test@skilllearner.org',
            'phone' => '9988776655',
            'password' => 'password123',
            'package' => 'basic',
            'referral_code' => 'SL-ADMIN',
        ]);

        $orderData = session('pending_cashfree_order');
        $orderId = $orderData['order_id'];

        $callbackResponse = $this->get(route('payment.cashfree.callback', [
            'order_id' => $orderId,
            'sim_status' => 'FAILED',
        ]));

        $callbackResponse->assertRedirect('/payment-status');
        $callbackResponse->assertSessionHas('error');

        $logContent = File::get(storage_path('logs/laravel.log'));
        $this->assertStringContainsString('Payment FAILED for Order', $logContent);
    }
}

