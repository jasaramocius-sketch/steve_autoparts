<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Traits\TracksIsDeleted; 

class Image extends Model
{
    use SoftDeletes, TracksIsDeleted;

    protected $fillable = [
        'original_name',
        'filename',
        'path',
        'url',
        'mime_type',
        'size',
        'width',
        'height',
        'alt_text',
        'title',
        'caption',
        'is_unused',
        'attachable_type',
        'attachable_id',
        'is_deleted',
    ];

    protected $casts = [
        'size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'is_unused' => 'boolean',
    ];

    public function attachable()
    {
        return $this->morphTo();
    }

    public function getSizeInKbAttribute(): string
    {
        return $this->size ? round($this->size / 1024, 1) . ' KB' : '-';
    }

    public function getThumbUrlAttribute(): string
    {
        return $this->url ?: asset('storage/' . $this->path);
    }

    public function getFilePathAttribute(): string
    {
        $paths = [
            public_path($this->path),
            storage_path('app/public/' . $this->path),
        ];
        foreach ($paths as $p) {
            if (file_exists($p)) {
                return $p;
            }
        }
        return $paths[0];
    }

    public function scopeUnused($query)
    {
        return $query->whereNull('attachable_type')->whereNull('attachable_id');
    }

    public function scopeConvertible($query)
    {
        return $query->whereIn('mime_type', ['image/jpeg', 'image/pjpeg', 'image/jpg']);
    }

    public static function storeFromUpload(
        UploadedFile $file,
        string $subdir = 'images',
        ?Model $attachable = null,
        ?string $altText = null,
        ?string $title = null
    ): self {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/' . $subdir, $filename);

        $dimensions = @getimagesize($file->getPathname());

        return self::create([
            'original_name' => $file->getClientOriginalName(),
            'filename' => $filename,
            'path' => $subdir . '/' . $filename,
            'url' => Storage::url($subdir . '/' . $filename),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'width' => $dimensions[0] ?? null,
            'height' => $dimensions[1] ?? null,
            'alt_text' => $altText,
            'title' => $title,
            'is_unused' => is_null($attachable),
            'attachable_type' => $attachable ? get_class($attachable) : null,
            'attachable_id' => $attachable?->id,
        ]);
    }
}
