<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   
use App\Traits\TracksIsDeleted;

class Compare extends Model
{
    use SoftDeletes, TracksIsDeleted;

    protected $fillable = [
        'user_id',
        'product_id',
        'is_deleted',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
