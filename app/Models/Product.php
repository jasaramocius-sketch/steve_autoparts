<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksIsDeleted;    

class Product extends Model
{
    use SoftDeletes, TracksIsDeleted;   

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'old_price',
        'image',
        'badge',
        'category_id',
        'rating',
        'reviews',
        'featured',
        'product_type',
        'stock',
        'status',
        'is_deleted',
        'added_by',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_deleted' => 'boolean',
        'featured' => 'boolean',
    ];

    protected $attributes = [
        'status' => true,
        'is_deleted' => false,
        'featured' => false,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}