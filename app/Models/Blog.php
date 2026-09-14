<?php

namespace App\Models;

use App\Traits\Revisable;
use App\Traits\TracksIsDeleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SteveStore\PageBuilder\Traits\HasBlocks;

class Blog extends Model
{
    use HasBlocks, Revisable, SoftDeletes, TracksIsDeleted;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'details',
        'status',
        'blog_category_id',
        'is_deleted',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
