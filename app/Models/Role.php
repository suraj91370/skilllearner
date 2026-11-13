<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_system',
        'permissions',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'permissions' => 'array',
    ];

    /**
     * All modules in the system.
     */
    public const MODULES = [
        'users' => [
            'name' => 'Users & Students',
            'desc' => 'Manage student accounts, profile inspection, manual course enrollments, password resets & KYC',
            'icon' => '👥',
        ],
        'orders' => [
            'name' => 'Orders & Refunds',
            'desc' => 'Inspect transactions, approve/reject refunds, invoice generation & failed tracking',
            'icon' => '💳',
        ],
        'courses' => [
            'name' => 'Courses & Pricing',
            'desc' => 'Manage video lessons, course details, package pricing & discount structures',
            'icon' => '📚',
        ],
        'content' => [
            'name' => 'CMS & Content',
            'desc' => 'Manage homepage banners, categories, testimonials, FAQs, blogs & certificate templates',
            'icon' => '🎨',
        ],
        'reports' => [
            'name' => 'Reports & Analytics',
            'desc' => 'Revenue analytics, top selling courses, mentor earnings, growth charts & Excel/PDF exports',
            'icon' => '📊',
        ],
        'finance' => [
            'name' => 'Finance & Gateways',
            'desc' => 'Cashfree gateway settings, commission rates, affiliate wallet adjustments & payouts',
            'icon' => '⚡',
        ],
        'roles' => [
            'name' => 'Staff & Audit Trail',
            'desc' => 'Manage staff accounts, assign RBAC permissions & inspect activity audit logs',
            'icon' => '🛡️',
        ],
    ];

    /**
     * Available permission actions per module.
     */
    public const ACTIONS = [
        'view' => 'View / Read',
        'create' => 'Create / Add',
        'edit' => 'Edit / Update',
        'delete' => 'Delete / Block',
    ];

    /**
     * Staff users assigned to this role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if this role has permission for a specific module and action.
     */
    public function hasPermission(string $module, string $action = 'view'): bool
    {
        if ($this->slug === 'super_admin') {
            return true;
        }

        $perms = $this->permissions ?? [];
        if (! isset($perms[$module])) {
            return false;
        }

        return in_array($action, (array) $perms[$module], true);
    }

    /**
     * Check if role has any permission in a module.
     */
    public function canAccessModule(string $module): bool
    {
        if ($this->slug === 'super_admin') {
            return true;
        }

        $perms = $this->permissions ?? [];

        return ! empty($perms[$module]);
    }
}

