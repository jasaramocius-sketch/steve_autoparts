<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   
use App\Traits\TracksIsDeleted;
use App\Traits\Revisable;
use SteveStore\PageBuilder\Traits\HasBlocks;

class Blog extends Model
{
    use SoftDeletes, TracksIsDeleted, Revisable, HasBlocks;

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
}