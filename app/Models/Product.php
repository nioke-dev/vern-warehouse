<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
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
