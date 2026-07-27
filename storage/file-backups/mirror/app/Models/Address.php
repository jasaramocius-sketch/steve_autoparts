<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\TracksIsDeleted;

class Address extends Model
{
    use SoftDeletes, TracksIsDeleted;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'set_default',
        'is_deleted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}