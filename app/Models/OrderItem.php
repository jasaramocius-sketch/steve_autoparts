<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksIsDeleted;

class OrderItem extends Model
{
    use SoftDeletes, TracksIsDeleted;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
        'is_deleted',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
