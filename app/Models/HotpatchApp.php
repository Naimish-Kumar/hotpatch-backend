<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotpatchApp extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'apps';

    protected $fillable = [
        'id',
        'owner_id',
        'name',
        'slug',
        'platform',
        'api_key',
        'encryption_key',
        'tier',
        'stripe_customer_id',
        'stripe_subscription_id',
        'subscription_status',
        'subscription_end',
    ];

    protected $casts = [
        'subscription_end' => 'datetime',
    ];

    protected $hidden = [
        'api_key',
        'encryption_key',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function releases()
    {
        return $this->hasMany(Release::class, 'app_id');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'app_id');
    }
}
