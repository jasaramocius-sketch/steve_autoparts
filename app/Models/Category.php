<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model; 
use App\Traits\TracksIsDeleted;

class Category extends Model
{
    use SoftDeletes, TracksIsDeleted;

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
