<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksIsDeleted;
use App\Traits\Revisable;

class Coupon extends Model
{
    use SoftDeletes, TracksIsDeleted, Revisable;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_uses',
        'used_count',
        'starts_at',
        'expires_at',
        'status',
        'is_deleted',
    ];

    protected $casts = [
        'status' => 'boolean',
        'starts_at' => 'date',
        'expires_at' => 'date',
    ];

    public function isValid(): bool
    {
        if (!$this->status) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->starts_at && $this->starts_at->isFuture()) return false;
        return true;
    }
}
