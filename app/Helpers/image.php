<?php

if (!function_exists('convertToWebp')) {
    function convertToWebp(string $sourcePath, string $destPath, int $quality = 80): bool
    {
        if (!file_exists($sourcePath)) {
            return false;
        }

        $info = @getimagesize($sourcePath);
        if ($info === false) {
            return false;
        }

        $mime = $info['mime'];
        $imageResource = match ($mime) {
            'image/jpeg', 'image/jpg', 'image/pjpeg' => @imagecreatefromjpeg($sourcePath),
            'image/png' => @imagecreatefrompng($sourcePath),
            'image/gif' => @imagecreatefromgif($sourcePath),
            'image/webp' => @imagecreatefromwebp($sourcePath),
            default => null,
        };

        if (!$imageResource) {
            return false;
        }

        if ($mime === 'image/png') {
            imagepalettetotruecolor($imageResource);
            imagealphablending($imageResource, true);
            imagesavealpha($imageResource, true);
        }

        $result = @imagewebp($imageResource, $destPath, $quality);
        imagedestroy($imageResource);

        return $result;
    }
}

if (!function_exists('saveImageWithWebp')) {
    function saveImageWithWebp($file, string $dir): string
    {
        $destination = public_path($dir);

        // Directory create karo agar nahi hai
        if (!is_dir($destination)) {
            mkdir($destination, 0775, true);
        }

        // Permission check
        if (!is_writable($destination)) {
            throw new Exception("Upload directory is not writable: " . $destination);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->extension();

        $file->move($destination, $filename);

        $fullPath = $destination . '/' . $filename;
        $webpPath = $destination . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp';

        convertToWebp($fullPath, $webpPath);

        return $filename;
    }
}

if (!function_exists('saveImageFromUrlWithWebp')) {
    function saveImageFromUrlWithWebp(string $url, string $dir): ?string
    {
        $response = \Illuminate\Support\Facades\Http::get($url);
        if ($response->failed()) {
            return null;
        }

        $contentType = $response->header('Content-Type');
        if (!str_contains($contentType, 'image/')) {
            return null;
        }

        $extension = 'jpg';
        if (str_contains($contentType, 'jpeg') || str_contains($contentType, 'jpg')) {
            $extension = 'jpg';
        } elseif (str_contains($contentType, 'png')) {
            $extension = 'png';
        } elseif (str_contains($contentType, 'webp')) {
            $extension = 'webp';
        } elseif (str_contains($contentType, 'gif')) {
            $extension = 'gif';
        }

        $filename = time() . '_' . uniqid() . '.' . $extension;
        $dirPath = public_path($dir);
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0755, true);
        }
        file_put_contents($dirPath . '/' . $filename, $response->body());

        $webpPath = $dirPath . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp';
        $fullPath = $dirPath . '/' . $filename;

        convertToWebp($fullPath, $webpPath);

        return $filename;
    }
}

if (!function_exists('deleteImageFiles')) {
    function deleteImageFiles(?string $filename, string $dir): void
    {
        if (!$filename) return;

        $fullPath = public_path($dir . '/' . $filename);
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }

        $webpPath = dirname($fullPath) . '/' . pathinfo($fullPath, PATHINFO_FILENAME) . '.webp';
        if (file_exists($webpPath)) {
            @unlink($webpPath);
        }
    }
}

if (!function_exists('webpExists')) {
    function webpExists(string $path): bool
    {
        $info = pathinfo($path);
        return file_exists(public_path($info['dirname'] . '/' . $info['filename'] . '.webp'));
    }
}

if (!function_exists('webpSrc')) {
    function webpSrc(string $path): string
    {
        $info = pathinfo($path);
        return asset($info['dirname'] . '/' . $info['filename'] . '.webp');
    }
}

if (!function_exists('imgTag')) {
    function imgTag(string $src, string $alt = '', string $class = '', string $extra = ''): string
    {
        $placeholder = asset('assets/images/placeholder.png');
        $onerror = "this.onerror=null;this.src='{$placeholder}'";
        $classAttr = $class ? " class=\"{$class}\"" : '';
        $extraAttr = $extra ? " {$extra}" : '';

        $html = '<img src="' . asset($src) . '" alt="' . e($alt) . '"' . $classAttr . ' onerror="' . $onerror . '"' . $extraAttr . '>';

        if (webpExists($src)) {
            $html = '<picture><source srcset="' . webpSrc($src) . '" type="image/webp">' . $html . '</picture>';
        }

        return $html;
    }
}
