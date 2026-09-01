<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'order_qty',
        'order_price',
        'order_subtotal'
    ];

    // one to one
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
