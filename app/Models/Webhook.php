<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'app_id',
        'url',
        'events',
        'is_active',
        'secret',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function app()
    {
        return $this->belongsTo(HotpatchApp::class, 'app_id');
    }
}
