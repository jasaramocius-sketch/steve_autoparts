<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisable;

class HomePageSection extends Model
{
    use HasFactory, Revisable;

    protected $fillable = [
        'section_name',
        'title',
        'subtitle',
        'description',
        'image',
        'button_text',
        'button_url',
        'order',
        'status',
        'extra_data',
    ];

    protected $casts = [
        'extra_data' => 'json',
        'status' => 'boolean',
    ];
}
