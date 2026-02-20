<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    protected $table = 'store_products';

    protected $fillable = [
        'category_id',
        'name_ar',
        'name_en',
        'slug_ar',
        'slug_en',
        'description_ar',
        'description_en',
        'price',
        'old_price',
        'discount_percent',
        'image_path',
        'stock',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'discount_percent' => 'integer',
        'stock' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}
