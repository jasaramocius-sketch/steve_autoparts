<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisable;

class Setting extends Model
{
    use Revisable;
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getAllAsArray()
    {
        return static::pluck('value', 'key')->toArray();
    }
}
