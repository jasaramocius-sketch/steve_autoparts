<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisable;

class Contact extends Model
{
    use Revisable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'user_id',
        'product_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
