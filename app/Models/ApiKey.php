<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'app_id',
        'name',
        'key',
        'prefix',
        'last_used',
        'expires_at',
    ];

    protected $casts = [
        'last_used' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function app()
    {
        return $this->belongsTo(HotpatchApp::class, 'app_id');
    }
}
