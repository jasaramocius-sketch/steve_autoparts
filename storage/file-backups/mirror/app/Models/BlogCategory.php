<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   
use App\Traits\TracksIsDeleted;
use App\Traits\Revisable;

class BlogCategory extends Model
{
    use SoftDeletes, TracksIsDeleted, Revisable;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'parent_id',
        'is_deleted',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'blog_category_id');
    }
}
