<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'device_id',
        'app_id',
        'platform',
        'current_version',
        'last_seen',
    ];

    protected $casts = [
        'last_seen' => 'datetime',
    ];

    public function app()
    {
        return $this->belongsTo(HotpatchApp::class, 'app_id');
    }

    public function installations()
    {
        return $this->hasMany(Installation::class, 'device_id');
    }
}
