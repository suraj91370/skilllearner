<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\CommissionService;
use Tests\TestCase;

class PackageUpgradePricingTest extends TestCase
{
    public function test_commission_service_upgrade_calculation_from_advance(): void
    {
        $premiumUpgrade = CommissionService::getUpgradeDetails('Advance Package', 'premium');
        $this->assertTrue($premiumUpgrade['is_upgrade']);
        $this->assertEquals(2499, $premiumUpgrade['discount']);
        $this->assertEquals(2500, $premiumUpgrade['payable_price']); // 4999 - 2499 = 2500

        $infinityUpgrade = CommissionService::getUpgradeDetails('Advance Package', 'infinity');
        $this->assertTrue($infinityUpgrade['is_upgrade']);
        $this->assertEquals(2499, $infinityUpgrade['discount']);
        $this->assertEquals(5500, $infinityUpgrade['payable_price']); // 7999 - 2499 = 5500

        $currentUpgrade = CommissionService::getUpgradeDetails('Advance Package', 'advance');
        $this->assertFalse($currentUpgrade['is_upgrade']);
        $this->assertTrue($currentUpgrade['is_current']);

        $lowerUpgrade = CommissionService::getUpgradeDetails('Advance Package', 'basic');
        $this->assertFalse($lowerUpgrade['is_upgrade']);
        $this->assertTrue($lowerUpgrade['is_lower']);
    }

    public function test_plans_page_displays_deducted_value_for_advance_user(): void
    {
        $user = new User([
            'id' => 9999,
            'name' => 'Adarsh Pandey',
            'email' => 'adarsh.test@example.com',
            'active_package' => 'Advance Package',
            'role' => 'affiliate',
        ]);

        $response = $this->actingAs($user)->get('/plans');

        $response->assertStatus(200);
        // Current plan banner
        $response->assertSee('Advance Package');
        $response->assertSee('Worth ₹2,499');
        // Premium upgrade discounted price
        $response->assertSee('₹2,500');
        $response->assertSee('₹2,499 Advance Package value deducted');
        // Infinity upgrade discounted price
        $response->assertSee('₹5,500');
    }

    public function test_buy_now_page_displays_upgrade_calculation_for_advance_user(): void
    {
        $user = new User([
            'id' => 9999,
            'name' => 'Ravi Gond',
            'email' => 'ravi.test@example.com',
            'phone' => '9876543210',
            'active_package' => 'Advance Package',
            'role' => 'affiliate',
        ]);

        $response = $this->actingAs($user)->get('/buy-now?package=premium');

        $response->assertStatus(200);
        $response->assertSee('Upgrade to Premium Package');
        $response->assertSee('₹2,500');
        $response->assertSee('ravi.test@example.com');
    }
}
