<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'device_id',
        'release_id',
        'status',
        'is_patch',
        'download_size',
        'installed_at',
    ];

    protected $casts = [
        'is_patch' => 'boolean',
        'download_size' => 'integer',
        'installed_at' => 'datetime',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function release()
    {
        return $this->belongsTo(Release::class, 'release_id');
    }
}
