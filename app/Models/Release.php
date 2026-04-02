<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'app_id',
        'version',
        'channel',
        'bundle_url',
        'object_key',
        'hash',
        'signature',
        'mandatory',
        'rollout_percentage',
        'is_encrypted',
        'is_patch',
        'base_version',
        'key_id',
        'size',
        'is_active',
    ];

    protected $casts = [
        'mandatory' => 'boolean',
        'is_encrypted' => 'boolean',
        'is_patch' => 'boolean',
        'is_active' => 'boolean',
        'rollout_percentage' => 'integer',
        'size' => 'integer',
    ];

    public function app()
    {
        return $this->belongsTo(HotpatchApp::class, 'app_id');
    }

    public function installations()
    {
        return $this->hasMany(Installation::class, 'release_id');
    }

    public function patches()
    {
        return $this->hasMany(Patch::class, 'release_id');
    }
}
