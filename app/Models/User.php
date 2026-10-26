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
    'total_earning',
    'kyc_status',
    'avatar',
    'role',
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
            'total_earning' => 'decimal:2',
        ];
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

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isUser(): bool
    {
        return in_array($this->role, ['user', 'affiliate', 'student']);
    }

    public function getRoleBadgeAttribute(): string
    {
        return match ($this->role) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            default => 'Student / Affiliate',
        };
    }
}
