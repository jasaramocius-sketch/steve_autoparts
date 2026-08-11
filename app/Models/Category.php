<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Support\Str;
use App\Traits\TracksIsDeleted;
use App\Traits\Revisable;

class Category extends Model
{
    use SoftDeletes, TracksIsDeleted, Revisable;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'image',
        'status',
        'is_deleted',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    protected $attributes = [
        'status' => true,
        'is_deleted' => false,
    ];


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('name');
    }

    public function childrenRecursive()
    {
        return $this->children()->where('status', true)->with('childrenRecursive');
    }

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'category_id');
    }

    public function getAllDescendantIds(): array
    {
        $ids = [$this->id];
        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getAllDescendantIds());
        }
        return $ids;
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id')->orderBy('name');
    }

    public function parent_category()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function getDisplayImagePath(): string
    {
        $storedImage = trim((string) $this->image);
        if ($storedImage !== '') {
            $candidate = storedPath($storedImage, 'assets/images/categories');
            if (file_exists(public_path($candidate))) {
                return $candidate;
            }
        }

        $fallbacks = [
            'engine-parts' => '1730804224silver-device-with-white-cover-that-says-word-it-minpng.png',
            'body-exterior' => '173080421331792401shockabsorber2-minpng.png',
            'interior-parts' => '1730804204oval-shaped-car-mirror-minpng.png',
            'electrical-lighting' => '1730804142c1b1489eb0545231cf0bfa44a827e2ae-minpng.png',
            'brakes-brake-parts' => '173080413017369231014177a5f-cedb-407a-8a1d-a6aa0f40249d-minpng.png',
            'transmission-drivetrain' => '1730804110engineering-concept-project-heating-house-thermostatic-valve-copper-fitting-project-minpng.png',
            'suspension-steering' => '1730804093huelpful-steering-wheel-isolated-white-background-minpng.png',
        ];

        $slug = Str::slug((string) ($this->slug ?: $this->name));
        $fallback = $fallbacks[$slug] ?? null;
        if ($fallback) {
            $candidate = 'assets/images/categories/' . $fallback;
            if (file_exists(public_path($candidate))) {
                return $candidate;
            }
        }

        return 'assets/images/placeholder.png';
    }

    public function getDisplayImage(): string
    {
        return basename($this->getDisplayImagePath());
    }

    /**
     * Get total products count including all descendant categories.
     * Requires withCount('products') and children to be eager loaded.
     */
    public function getTotalProductsCountAttribute(): int
    {
        $count = $this->products_count ?? 0;
        if ($this->relationLoaded('children')) {
            foreach ($this->children as $child) {
                $count += $child->total_products_count;
            }
        }
        return $count;
    }
}
