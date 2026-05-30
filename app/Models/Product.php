<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'details',
        'image_path',
        'category_id',
        'grade',
        'status',
        'daily_sales',
        'monthly_revenue',
    ];

    protected $casts = [
        'monthly_revenue' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
