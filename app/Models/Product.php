<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksIsDeleted;
use App\Traits\Revisable;
use App\Models\Image;

class Product extends Model
{
    use SoftDeletes, TracksIsDeleted, Revisable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'old_price',
        'image',
        'badge',
        'category_id',
        'brand_id',
        'seller_id',
        'year',
        'make',
        'model',
        'rating',
        'reviews',
        'featured',
        'product_type',
        'stock',
        'status',
        'tab_label_1',
        'tab_label_2',
        'tab_label_3',
        'policy_text',
        'features',
        'reviews_data',
        'is_deleted',
        'added_by',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_deleted' => 'boolean',
        'featured' => 'boolean',
        'features' => 'array',
        'reviews_data' => 'array',
    ];

    protected $attributes = [
        'status' => true,
        'is_deleted' => false,
        'featured' => false,
    ];

    public function getReviewsDataAttribute($value)
    {
        if (is_array($value)) return $value;
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    public function getFeaturesAttribute($value)
    {
        if (is_array($value)) return $value;
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function galleryImages()
    {
        return $this->belongsToMany(Image::class, 'image_product', 'product_id', 'image_id');
    }
}
