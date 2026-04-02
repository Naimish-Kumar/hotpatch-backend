<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'app_id',
        'name',
        'slug',
        'description',
        'color',
        'auto_rollout',
    ];

    protected $casts = [
        'auto_rollout' => 'boolean',
    ];

    public function app()
    {
        return $this->belongsTo(HotpatchApp::class, 'app_id');
    }
}
