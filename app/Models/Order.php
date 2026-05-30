<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'customer_name',
        'total_amount',
        'status',
        'order_date',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
