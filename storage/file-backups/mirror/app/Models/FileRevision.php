<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileRevision extends Model
{
    protected $fillable = [
        'file_path',
        'event',
        'content_hash',
        'backup_path',
        'diff',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
