<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksIsDeleted;

class Brand extends Model
{
    use SoftDeletes, TracksIsDeleted;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'website',
        'status',
        'is_deleted',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
