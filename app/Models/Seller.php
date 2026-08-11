<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksIsDeleted;
use App\Traits\Revisable;

class Seller extends Model
{
    use SoftDeletes, TracksIsDeleted, Revisable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'location',
        'image',
        'status',
        'is_deleted',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    public function followedBy()
    {
        return $this->hasMany(FollowedSeller::class, 'seller_id');
    }

    public function getFollowersCountAttribute()
    {
        return $this->followedBy()->count();
    }
}
