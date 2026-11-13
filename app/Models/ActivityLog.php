<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_role',
        'action',
        'module',
        'description',
        'properties',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * User who performed the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to log an administrative action into the audit trail.
     *
     * @param array<string, mixed> $properties
     */
    public static function record(string $action, string $module, string $description, array $properties = []): self
    {
        $currentUser = auth()->user();

        return static::create([
            'user_id' => $currentUser?->id,
            'user_name' => $currentUser?->name ?? 'System',
            'user_role' => $currentUser?->role ?? 'system',
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'properties' => ! empty($properties) ? $properties : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}

