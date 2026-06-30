<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksIsDeleted;

class Faq extends Model
{
    use SoftDeletes, TracksIsDeleted;

    protected $fillable = [
        'question',
        'answer',
        'order',
        'status',
        'is_deleted',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
