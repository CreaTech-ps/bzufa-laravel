<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_super_admin',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_super_admin' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function canAccess(string $permissionSlug): bool
    {
        if (!$this->is_active) {
            return false;
        }
        if ($this->is_super_admin) {
            return true;
        }
        if (! $this->role) {
            return false;
        }

        if ($permissionSlug === 'financial' && $this->role->permissions()->whereIn('slug', [
            'financial',
            'financial_add',
            'financial_review',
            'financial_approve',
        ])->exists()) {
            return true;
        }

        return $this->role->hasPermission($permissionSlug);
    }

    public function isSuperAdmin(): bool
    {
        return (bool) $this->is_super_admin;
    }
}
