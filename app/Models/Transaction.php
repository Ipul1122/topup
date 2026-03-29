<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'customer_name',
        'customer_phone',
        'target_user_id',
        'amount',
        'payment_status',
        'topup_status',
        'sn',
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
