<?php

if (!function_exists('sortUrl')) {
    function sortUrl($column, $currentSortBy, $currentSortDir): string
    {
        $newDir = $currentSortBy === $column && $currentSortDir === 'asc' ? 'desc' : 'asc';
        return request()->fullUrlWithQuery(['sort_by' => $column, 'sort_dir' => $newDir]);
    }
}

if (!function_exists('sortIndicator')) {
    function sortIndicator($column, $currentSortBy, $currentSortDir): string
    {
        if ($currentSortBy !== $column) return '';
        return $currentSortDir === 'asc'
            ? '<small class="text-muted">&nbsp;⋏</small>'
            : '<small class="text-muted">&nbsp;</small>';
    }
}

if (!function_exists('resolveImageSource')) {
    function resolveImageSource(?string $path): ?string
    {
        if (!$path) return null;

        $candidates = [public_path($path), storage_path('app/public/' . $path)];
        foreach ($candidates as $candidate) {
            if (file_exists($candidate)) {
                return $candidate;
            }
        }

        return null;
    }
}

if (!function_exists('normalizeImagePath')) {
    function normalizeImagePath($value, ?string $legacyPrefix = null): ?string
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        $value = trim((string) $value);

        if (preg_match('#^https?://#i', $value)) {
            return $value;
        }

        if (str_contains($value, '/')) {
            return $value;
        }

        if ($legacyPrefix) {
            return $legacyPrefix . '/' . $value;
        }

        return $value;
    }
}

if (!function_exists('storedPath')) {
    function storedPath($value, ?string $legacyPrefix = null, string $fallback = 'assets/images/placeholder.png'): string
    {
        $path = normalizeImagePath($value, $legacyPrefix);
        if (!$path || preg_match('#^https?://#i', $path)) {
            return $fallback;
        }

        return $path;
    }
}

if (!function_exists('webpOriginal')) {
    function webpOriginal(string $path): ?string
    {
        if (!preg_match('/\.webp$/i', $path)) {
            return null;
        }

        $info = pathinfo($path);
        foreach (['jpg', 'jpeg', 'png', 'gif'] as $ext) {
            $candidate = $info['dirname'] . '/' . $info['filename'] . '.' . $ext;
            $checkPath = str_starts_with($candidate, 'uploads/') ? 'storage/' . $candidate : $candidate;
            if (file_exists(public_path($checkPath))) {
                return $checkPath;
            }
        }

        return null;
    }
}

if (!function_exists('imageUrl')) {
    function imageUrl(string $path): string
    {
        if (preg_match('/\.webp$/i', $path)) {
            $original = webpOriginal($path);
            if ($original !== null) {
                return asset($original);
            }
        }

        if (str_starts_with($path, 'uploads/')) {
            return asset('storage/' . $path);
        }

        return asset($path);
    }
}

if (!function_exists('storedImageUrl')) {
    function storedImageUrl($value, ?string $legacyPrefix = null, string $fallback = 'assets/images/placeholder.png'): string
    {
        $path = normalizeImagePath($value, $legacyPrefix);
        if (!$path) {
            return asset($fallback);
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        if (str_starts_with($path, 'uploads/')) {
            return asset('storage/' . $path);
        }

        return imageUrl($path);
    }
}

if (!function_exists('webpExists')) {
    function webpExists(string $path): bool
    {
        $info = pathinfo($path);
        $webpPath = $info['dirname'] . '/' . $info['filename'] . '.webp';
        $checkPath = str_starts_with($webpPath, 'uploads/') ? 'storage/' . $webpPath : $webpPath;
        return file_exists(public_path($checkPath));
    }
}

if (!function_exists('webpSrc')) {
    function webpSrc(string $path): string
    {
        $info = pathinfo($path);
        $webpPath = $info['dirname'] . '/' . $info['filename'] . '.webp';
        if (str_starts_with($webpPath, 'uploads/')) {
            return asset('storage/' . $webpPath);
        }
        return asset($webpPath);
    }
}
