<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksIsDeleted;
use App\Traits\Revisable;

class Order extends Model
{
    use SoftDeletes, TracksIsDeleted, Revisable;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'order_number',
        'total_amount',
        'status',
        'shipping_address_id',
        'shipping_details',
        'delivery_type',
        'payment_method',
        'payment_details',
        'additional_info',
        'shipping_fee',
        'tax',
        'is_deleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}