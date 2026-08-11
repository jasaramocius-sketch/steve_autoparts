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
        if (str_starts_with($this->path, 'assets/')) {
            return asset($this->path);
        }
        return asset('storage/' . $this->path);
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
        $path = $file->storeAs('uploads/' . now()->format('Y/m'), $filename, 'public');

        $dimensions = @getimagesize($file->getPathname());

        return self::create([
            'original_name' => $file->getClientOriginalName(),
            'filename' => $filename,
            'path' => $path,
            'url' => 'storage/' . $path,
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

    public static function normalizePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $path = trim((string) $path);
        $path = preg_replace('#^/+#', '', $path);

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        if (str_starts_with($path, 'public/')) {
            $path = substr($path, strlen('public/'));
        }

        return $path === '' ? null : $path;
    }

    public static function markUsed(string $path, ?Model $attachable = null, bool $attach = true): void
    {
        $norm = static::normalizePath($path);
        if (!$norm) {
            return;
        }

        $image = static::where('path', $norm)->first();
        if (!$image) {
            return;
        }

        $image->is_unused = false;

        if ($attach && $attachable) {
            $image->attachable_type = get_class($attachable);
            $image->attachable_id = $attachable->getKey();
        }

        $image->save();
    }

    public static function attachPath(string $path, Model $attachable): self
    {
        $norm = static::normalizePath($path);
        if (!$norm) {
            throw new \InvalidArgumentException('Invalid image path.');
        }

        $existing = static::where('path', $norm)->first();

        if (
            $existing
            && $existing->attachable_type === get_class($attachable)
            && (int) $existing->attachable_id === (int) $attachable->getKey()
        ) {
            return $existing;
        }

        if ($existing && $existing->attachable_type === null && $existing->attachable_id === null) {
            $existing->attachable_type = get_class($attachable);
            $existing->attachable_id = $attachable->getKey();
            $existing->is_unused = false;
            $existing->save();
            return $existing;
        }

        $source = $existing ?: static::createFromPath($norm);

        return static::create([
            'original_name' => $source->original_name,
            'filename' => $source->filename,
            'path' => $source->path,
            'url' => $source->url,
            'mime_type' => $source->mime_type,
            'size' => $source->size,
            'width' => $source->width,
            'height' => $source->height,
            'alt_text' => $source->alt_text,
            'title' => $source->title,
            'is_unused' => false,
            'attachable_type' => get_class($attachable),
            'attachable_id' => $attachable->getKey(),
        ]);
    }

    public static function createFromPath(string $path): self
    {
        $full = resolveImageSource($path);
        $info = $full ? @getimagesize($full) : false;

        return static::create([
            'original_name' => basename($path),
            'filename' => basename($path),
            'path' => $path,
            'url' => 'storage/' . ltrim($path, '/'),
            'mime_type' => $info ? ($info['mime'] ?? 'image/jpeg') : 'image/jpeg',
            'size' => $full ? filesize($full) : null,
            'width' => $info[0] ?? null,
            'height' => $info[1] ?? null,
            'is_unused' => true,
        ]);
    }
}
