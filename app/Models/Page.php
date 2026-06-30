<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksIsDeleted;

class Page extends Model
{
    use SoftDeletes, TracksIsDeleted;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'status',
        'is_deleted',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
