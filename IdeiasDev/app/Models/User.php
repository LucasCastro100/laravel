<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'system_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role_id === 1;
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 2;
    }

    public function isUser(): bool
    {
        return $this->role_id === 3;
    }

    public function canCreate(): bool
    {
        if ($this->isSuperAdmin()) return true;

        if ($this->system?->slug === 'tbr') return false;

        if (in_array($this->system?->slug, ['financeiro', 'clientes'])) return true;

        return in_array($this->role_id, [2, 3]);
    }

    public function canEdit(): bool
    {
        if ($this->isSuperAdmin()) return true;

        if ($this->system?->slug === 'tbr') return false;

        if (in_array($this->system?->slug, ['financeiro', 'clientes'])) return true;

        return in_array($this->role_id, [2]);
    }

    public function canDelete(): bool
    {
        if ($this->isSuperAdmin()) return true;

        if ($this->system?->slug === 'tbr') return false;

        if (in_array($this->system?->slug, ['financeiro', 'clientes'])) return true;

        return $this->role_id === 1;
    }
}
