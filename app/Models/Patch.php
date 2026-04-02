<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patch extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'release_id',
        'base_version',
        'patch_url',
        'object_key',
        'hash',
        'signature',
        'size',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function release()
    {
        return $this->belongsTo(Release::class, 'release_id');
    }
}
