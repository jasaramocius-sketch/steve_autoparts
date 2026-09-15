<?php

namespace App\Models;

use App\Traits\Revisable;
use App\Traits\TracksIsDeleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use Revisable, SoftDeletes, TracksIsDeleted;

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

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
