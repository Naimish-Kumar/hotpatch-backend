<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPackage extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'currency',
        'interval',
        'description',
        'features',
        'is_active',
        'stripe_price_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'integer',
    ];
}
