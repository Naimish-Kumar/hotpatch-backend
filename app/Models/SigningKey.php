<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SigningKey extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'app_id',
        'name',
        'public_key',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function app()
    {
        return $this->belongsTo(HotpatchApp::class, 'app_id');
    }
}
