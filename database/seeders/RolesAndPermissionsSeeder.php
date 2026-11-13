<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Predefined System Roles
        $rolesData = [
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'description' => 'Universal root access across all modules, payments, staff management, and system settings.',
                'is_system' => true,
                'permissions' => [
                    'users' => ['view', 'create', 'edit', 'delete'],
                    'orders' => ['view', 'create', 'edit', 'delete'],
                    'courses' => ['view', 'create', 'edit', 'delete'],
                    'content' => ['view', 'create', 'edit', 'delete'],
                    'reports' => ['view', 'create', 'edit', 'delete'],
                    'finance' => ['view', 'create', 'edit', 'delete'],
                    'roles' => ['view', 'create', 'edit', 'delete'],
                ],
            ],
            [
                'name' => 'Support Staff',
                'slug' => 'support',
                'description' => 'Customer assistance, verifying KYC, unblocking accounts, resetting passwords, and checking course progress.',
                'is_system' => true,
                'permissions' => [
                    'users' => ['view', 'create', 'edit'],
                    'orders' => ['view'],
                    'courses' => ['view'],
                    'content' => ['view'],
                    'reports' => ['view'],
                    'finance' => [],
                    'roles' => [],
                ],
            ],
            [
                'name' => 'Finance Manager',
                'slug' => 'finance',
                'description' => 'Financial tracking, verifying transactions, approving/rejecting refunds, and viewing sales/revenue analytics.',
                'is_system' => true,
                'permissions' => [
                    'users' => ['view'],
                    'orders' => ['view', 'create', 'edit'],
                    'courses' => ['view'],
                    'content' => [],
                    'reports' => ['view', 'create', 'edit'],
                    'finance' => ['view', 'create', 'edit'],
                    'roles' => [],
                ],
            ],
            [
                'name' => 'Content Manager',
                'slug' => 'content_manager',
                'description' => 'Publishing courses, uploading video lessons, creating categories, banners, FAQs, and blog articles.',
                'is_system' => true,
                'permissions' => [
                    'users' => [],
                    'orders' => [],
                    'courses' => ['view', 'create', 'edit', 'delete'],
                    'content' => ['view', 'create', 'edit', 'delete'],
                    'reports' => ['view'],
                    'finance' => [],
                    'roles' => [],
                ],
            ],
        ];

        $createdRoles = [];
        foreach ($rolesData as $data) {
            $createdRoles[$data['slug']] = Role::updateOrCreate([
                'slug' => $data['slug'],
            ], $data);
        }

        // 2. Link existing Super Admin user
        $superAdminUser = User::where('role', 'super_admin')->first();
        if ($superAdminUser && isset($createdRoles['super_admin'])) {
            $superAdminUser->update([
                'role_id' => $createdRoles['super_admin']->id,
                'is_staff' => true,
            ]);
        }

        // 3. Create demo staff users for immediate testing if not existing
        $supportStaff = User::firstOrCreate([
            'email' => 'support@skilllearner.org',
        ], [
            'name' => 'Pooja Verma (Support)',
            'phone' => '9876543211',
            'password' => bcrypt('password123'),
            'role' => 'support',
            'role_id' => $createdRoles['support']->id,
            'is_staff' => true,
            'active_package' => 'Advance Package',
            'payment_status' => 'paid',
        ]);

        $financeStaff = User::firstOrCreate([
            'email' => 'finance@skilllearner.org',
        ], [
            'name' => 'Amitabh Sen (Finance)',
            'phone' => '9876543212',
            'password' => bcrypt('password123'),
            'role' => 'finance',
            'role_id' => $createdRoles['finance']->id,
            'is_staff' => true,
            'active_package' => 'Advance Package',
            'payment_status' => 'paid',
        ]);

        $contentStaff = User::firstOrCreate([
            'email' => 'content@skilllearner.org',
        ], [
            'name' => 'Kavita Joshi (Content)',
            'phone' => '9876543213',
            'password' => bcrypt('password123'),
            'role' => 'content_manager',
            'role_id' => $createdRoles['content_manager']->id,
            'is_staff' => true,
            'active_package' => 'Advance Package',
            'payment_status' => 'paid',
        ]);

        // 4. Seed initial Activity Logs for demonstration
        if (ActivityLog::count() === 0) {
            ActivityLog::create([
                'user_id' => $superAdminUser?->id,
                'user_name' => $superAdminUser?->name ?? 'Super Admin',
                'user_role' => 'super_admin',
                'action' => 'PRICE_CHANGED',
                'module' => 'courses',
                'description' => 'Updated Advance Package price from ₹2,999 to ₹2,499 (Festive Discount applied).',
                'properties' => [
                    'package' => 'advance',
                    'old_price' => 2999,
                    'new_price' => 2499,
                ],
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subHours(4),
            ]);

            ActivityLog::create([
                'user_id' => $financeStaff->id,
                'user_name' => $financeStaff->name,
                'user_role' => 'finance',
                'action' => 'REFUND_APPROVED',
                'module' => 'orders',
                'description' => 'Approved refund of ₹1,199 for Order #SKL_261110_7056 (Student duplicate payment).',
                'properties' => [
                    'order_id' => 'SKL_261110_7056',
                    'amount' => 1199,
                ],
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subHours(2),
            ]);

            ActivityLog::create([
                'user_id' => $contentStaff->id,
                'user_name' => $contentStaff->name,
                'user_role' => 'content_manager',
                'action' => 'BANNER_UPDATED',
                'module' => 'content',
                'description' => 'Published new hero announcement banner: "🚀 Admissions Open for 2026 Season".',
                'properties' => [
                    'banner_title' => 'Admissions Open for 2026',
                ],
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subMinutes(45),
            ]);
        }
    }
}

