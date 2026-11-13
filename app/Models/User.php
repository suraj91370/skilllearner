<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'phone',
    'password',
    'affiliate_id',
    'sponsor_id',
    'active_package',
    'wallet_balance',
    'today_earning',
    'weekly_earning',
    'monthly_earning',
    'total_earning',
    'passive_earning',
    'industry_revenue',
    'kyc_status',
    'avatar',
    'role',
    'role_id',
    'payment_status',
    'is_blocked',
    'is_staff',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'wallet_balance' => 'decimal:2',
            'today_earning' => 'decimal:2',
            'weekly_earning' => 'decimal:2',
            'monthly_earning' => 'decimal:2',
            'total_earning' => 'decimal:2',
            'passive_earning' => 'decimal:2',
            'industry_revenue' => 'decimal:2',
            'is_blocked' => 'boolean',
            'is_staff' => 'boolean',
        ];
    }

    public function userCourses()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class)->latest();
    }

    public function payouts()
    {
        return $this->hasMany(Payout::class)->latest();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'user_courses')
            ->withPivot('progress_percent', 'completed_at')
            ->withTimestamps();
    }

    public function kyc()
    {
        return $this->hasOne(KycVerification::class);
    }

    public function roleModel()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class)->latest();
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']) || $this->is_staff;
    }

    public function isStaff(): bool
    {
        return (bool) $this->is_staff || in_array($this->role, ['super_admin', 'admin', 'support', 'finance', 'content_manager']);
    }

    public function isUser(): bool
    {
        return in_array($this->role, ['user', 'affiliate', 'student']) && ! $this->is_staff;
    }

    /**
     * Check if user has permission for a specific module and action.
     */
    public function hasPermission(string $module, string $action = 'view'): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (! $this->isStaff()) {
            return false;
        }

        // Check assigned Role model
        if ($this->roleModel) {
            return $this->roleModel->hasPermission($module, $action);
        }

        // Fallback for role slug if role_id not linked
        $role = Role::where('slug', $this->role)->first();
        if ($role) {
            return $role->hasPermission($module, $action);
        }

        return false;
    }

    /**
     * Check if user can access a module.
     */
    public function canAccessModule(string $module): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (! $this->isStaff()) {
            return false;
        }

        if ($this->roleModel) {
            return $this->roleModel->canAccessModule($module);
        }

        $role = Role::where('slug', $this->role)->first();
        if ($role) {
            return $role->canAccessModule($module);
        }

        return false;
    }

    public function getRoleBadgeAttribute(): string
    {
        if ($this->roleModel) {
            return $this->roleModel->name;
        }

        return match ($this->role) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'support' => 'Support Staff',
            'finance' => 'Finance Manager',
            'content_manager' => 'Content Manager',
            default => 'Student / Affiliate',
        };
    }
}
