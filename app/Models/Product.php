<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 
        'name', 
        'sku_code', 
        'price_provider', 
        'price_sell', 
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
