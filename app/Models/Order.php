<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
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
