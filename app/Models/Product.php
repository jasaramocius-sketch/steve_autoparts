<?php

namespace App\Models;

use App\Traits\Revisable;
use App\Traits\TracksIsDeleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use Revisable, SoftDeletes, TracksIsDeleted;

    protected $fillable = [
        'name',
        'slug',
        'sku',
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
        'specifications',
        'reviews_data',
        'is_deleted',
        'added_by',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_deleted' => 'boolean',
        'featured' => 'boolean',
        'features' => 'array',
        'specifications' => 'array',
        'reviews_data' => 'array',
    ];

    protected $attributes = [
        'status' => true,
        'is_deleted' => false,
        'featured' => false,
    ];

    public function getReviewsDataAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    public function getFeaturesAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    public function getSpecificationsAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }
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

    public static function generateSku(string $name, ?int $excludeId = null): string
    {
        $base = 'SKU-'.strtoupper(Str::substr(Str::slug($name), 0, 6));

        do {
            $candidate = $base.'-'.strtoupper(Str::random(5));
        } while (self::query()
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->where('sku', $candidate)
            ->exists());

        return $candidate;
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
