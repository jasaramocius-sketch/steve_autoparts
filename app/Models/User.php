<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\TracksIsDeleted;
use App\Traits\Revisable;

#[Fillable([
    'name', 'email', 'password', 'role', 'user_type',
    'phone', 'address', 'city', 'country', 'state', 'postal_code',
    'status', 'banned', 'is_deleted',
    'referred_by', 'provider', 'provider_id', 'refresh_token', 'access_token',
    'verification_code', 'new_email_verificiation_code',
    'device_token', 'avatar', 'avatar_original',
    'balance', 'referral_code', 'customer_package_id', 'remaining_uploads',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, TracksIsDeleted, Revisable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function followedSellers(): HasMany
    {
        return $this->hasMany(FollowedSeller::class);
    }
}
