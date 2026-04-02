<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'app_id',
        'actor',
        'action',
        'entity_id',
        'metadata',
        'ip_address',
    ];

    public function app()
    {
        return $this->belongsTo(HotpatchApp::class, 'app_id');
    }
}
