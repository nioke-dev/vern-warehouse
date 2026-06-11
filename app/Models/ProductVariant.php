<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'product_id',
        'variant_name',
        'variant_unit',
        'sku',
        'initial_stock',
        'actual_stock',
        'expired_date',
        'barcode',
        'cost_price',
        'selling_price',
        'margin',
        'min_stock',
        'enable_stock_alert',
        'image_path',
    ];

    protected $casts = [
        'expired_date' => 'date',
        'enable_stock_alert' => 'boolean',
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'margin' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
