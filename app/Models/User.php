<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'email',
        'password_hash',
        'display_name',
        'avatar_url',
        'google_id',
        'is_verified',
        'is_super_admin',
        'last_login_at',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    protected $hidden = [
        'password_hash',
        'verification_token',
        'reset_password_token',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'is_super_admin' => 'boolean',
            'last_login_at' => 'datetime',
            'reset_password_expires_at' => 'datetime',
        ];
    }

    public function apps()
    {
        return $this->hasMany(HotpatchApp::class, 'owner_id');
    }

    public function refreshTokens()
    {
        return $this->hasMany(RefreshToken::class);
    }
}
