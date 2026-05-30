<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageOrder extends Model
{
    protected $fillable = [
        'order_id',
        'customer_name',
        'email',
        'whatsapp',
        'package_name',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
