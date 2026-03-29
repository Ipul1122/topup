<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Tambahkan 'status' di sini
    protected $fillable = [
        'category_id', 
        'name', 
        'sku_code', 
        'price_provider', 
        'price_sell', 
        'status', 
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}