<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function picker(Request $request)
    {
        $query = Image::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $query->orderBy('created_at', 'desc');

        $images = $query->paginate(18)->withQueryString();

        return response()->json([
            'images' => $images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'thumb_url' => $image->thumb_url,
                    'original_name' => $image->original_name,
                    'filename' => $image->filename,
                    'path' => $image->path,
                    'mime_type' => $image->mime_type,
                    'size_in_kb' => $image->size_in_kb,
                ];
            }),
            'last_page' => $images->lastPage(),
            'current_page' => $images->currentPage(),
            'total' => $images->total(),
        ]);
    }

    public function pickerStore(Request $request)
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
        ]);

        $uploaded = [];
        foreach ($request->file('images') as $file) {
            $image = Image::storeFromUpload($file, 'images');
            $uploaded[] = [
                'id' => $image->id,
                'thumb_url' => $image->thumb_url,
                'original_name' => $image->original_name,
                'filename' => $image->filename,
                'path' => $image->path,
                'mime_type' => $image->mime_type,
                'size_in_kb' => $image->size_in_kb,
            ];
        }

        return response()->json(['success' => true, 'images' => $uploaded]);
    }

    public function pickerStoreFromUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:2048',
        ]);

        $url = $request->url;

        if (!preg_match('/^https?:\/\//i', $url)) {
            return response()->json(['success' => false, 'message' => 'Only http/https image URLs are allowed.'], 422);
        }

        $context = stream_context_create([
            'http' => [
                'timeout' => 20,
                'ignore_errors' => true,
                'user_agent' => 'Mozilla/5.0 (compatible; StAutopartsImageDownloader/1.0)',
            ],
            'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
        ]);

        $contents = @file_get_contents($url, false, $context);
        if ($contents === false || strlen($contents) === 0) {
            return response()->json(['success' => false, 'message' => 'Could not download the image from the provided URL.'], 422);
        }

        if (strlen($contents) > 10 * 1024 * 1024) {
            return response()->json(['success' => false, 'message' => 'The image is larger than the 10MB limit.'], 422);
        }

        $info = @getimagesizefromstring($contents);
        if ($info === false) {
            return response()->json(['success' => false, 'message' => 'The URL does not point to a valid image.'], 422);
        }

        $allowedMimes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg',
        ];

        $mime = $info['mime'];
        if (!isset($allowedMimes[$mime])) {
            return response()->json(['success' => false, 'message' => 'Unsupported image type: ' . $mime], 422);
        }
        $ext = $allowedMimes[$mime];

        $originalName = basename((string) parse_url($url, PHP_URL_PATH)) ?: ('image.' . $ext);
        if (!preg_match('/\.' . preg_quote($ext, '/') . '$/i', $originalName)) {
            $originalName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $ext;
        }

        $tmp = tempnam(sys_get_temp_dir(), 'imgdl_');
        if ($tmp === false) {
            return response()->json(['success' => false, 'message' => 'Could not create a temporary file.'], 500);
        }

        try {
            file_put_contents($tmp, $contents);
            $uploadedFile = new UploadedFile($tmp, $originalName, $mime, null, true);
            $image = Image::storeFromUpload($uploadedFile, 'images');
        } finally {
            @unlink($tmp);
        }

        return response()->json([
            'success' => true,
            'image' => [
                'id' => $image->id,
                'thumb_url' => $image->thumb_url,
                'original_name' => $image->original_name,
                'filename' => $image->filename,
                'path' => $image->path,
                'mime_type' => $image->mime_type,
                'size_in_kb' => $image->size_in_kb,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
        ]);

        $uploaded = 0;
        foreach ($request->file('images') as $file) {
            Image::storeFromUpload($file, 'images');
            $uploaded++;
        }

        return back()->with('success', "{$uploaded} image(s) uploaded successfully.");
    }

    public function index(Request $request)
    {
        $query = Image::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $filter = $request->filter;
        $convertibleMimes = ['image/jpeg', 'image/pjpeg', 'image/jpg', 'image/png', 'image/gif'];
        if ($filter === 'unused') {
            $query->whereNull('attachable_type')->whereNull('attachable_id');
        } elseif ($filter === 'attached') {
            $query->whereNotNull('attachable_type');
        } elseif ($filter === 'convertible') {
            $query->whereIn('mime_type', $convertibleMimes)
                  ->whereRaw("SUBSTRING_INDEX(filename, '.', 1) NOT IN (SELECT SUBSTRING_INDEX(filename, '.', 1) FROM images WHERE mime_type = 'image/webp')");
        }

        $sort = $request->sort ?? 'created_at';
        $order = $request->order ?? 'desc';
        $allowedSorts = ['created_at', 'original_name', 'size', 'width', 'height'];
        if (!in_array($sort, $allowedSorts)) $sort = 'created_at';
        $query->orderBy($sort, $order === 'asc' ? 'asc' : 'desc');

        $images = $query->paginate(24)->onEachSide(2)->withQueryString();

        $convertibleQuery = Image::whereIn('mime_type', $convertibleMimes)
            ->whereRaw("SUBSTRING_INDEX(filename, '.', 1) NOT IN (SELECT SUBSTRING_INDEX(filename, '.', 1) FROM images WHERE mime_type = 'image/webp')");

        $stats = [
            'total' => Image::count(),
            'unused' => Image::whereNull('attachable_type')->whereNull('attachable_id')->count(),
            'attached' => Image::whereNotNull('attachable_type')->count(),
            'convertible' => $convertibleQuery->count(),
            'total_size' => Image::sum('size'),
        ];

        return view('admin.images.index', compact('images', 'stats'));
    }

    public function edit($id)
    {
        $image = Image::with('attachable', 'products')->findOrFail($id);
        $usageLocations = $image->usageLocations();
        return view('admin.images.edit', compact('image', 'usageLocations'));
    }

    public function update(Request $request, $id)
    {
        $image = Image::findOrFail($id);

        $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:500',
        ]);

        $image->update($request->only(['alt_text', 'title', 'caption']));

        return redirect()->route('admin.images.edit', $image->id)
            ->with('success', 'Image details updated successfully.');
    }

    public function convert($id)
    {
        $image = Image::findOrFail($id);

        if (!in_array($image->mime_type, ['image/jpeg', 'image/pjpeg', 'image/jpg', 'image/png', 'image/gif'])) {
            return back()->with('error', 'Only JPEG, PNG, and GIF images can be converted to WebP.');
        }

        $sourcePath = $image->file_path;
        if (!file_exists($sourcePath)) {
            return back()->with('error', 'File not found.');
        }

        $webpFilename = pathinfo($image->filename, PATHINFO_FILENAME) . '.webp';

        if (Image::where('filename', $webpFilename)->exists()) {
            return back()->with('error', 'This image is already converted to WebP.');
        }

        $destPath = dirname($sourcePath) . '/' . $webpFilename;

        if (!convertToWebp($sourcePath, $destPath, 80)) {
            return back()->with('error', 'Could not convert image to WebP.');
        }

        $webpSize = filesize($destPath);
        $webpInfo = getimagesize($destPath);

        $publicBase = public_path();
        $storageBase = storage_path('app/public');
        $relativePath = match (true) {
            str_starts_with($destPath, $publicBase)  => substr($destPath, strlen($publicBase) + 1),
            str_starts_with($destPath, $storageBase) => substr($destPath, strlen($storageBase) + 1),
            default => pathinfo($image->path, PATHINFO_DIRNAME) . '/' . $webpFilename,
        };
        $converted = Image::create([
            'original_name' => pathinfo($image->original_name, PATHINFO_FILENAME) . '.webp',
            'filename' => $webpFilename,
            'path' => $relativePath,
            'url' => 'storage/' . $relativePath,
            'mime_type' => 'image/webp',
            'size' => $webpSize,
            'width' => $webpInfo[0] ?? null,
            'height' => $webpInfo[1] ?? null,
            'alt_text' => $image->alt_text,
            'title' => $image->title,
            'caption' => $image->caption,
            'attachable_type' => $image->attachable_type,
            'attachable_id' => $image->attachable_id,
        ]);

        return redirect()->route('admin.images.index')
            ->with('success', "Converted {$image->original_name} to {$converted->original_name} successfully.");
    }

    public function bulkConvert(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'No images selected.');
        }

        $images = Image::whereIn('id', $ids)
            ->whereIn('mime_type', ['image/jpeg', 'image/pjpeg', 'image/jpg', 'image/png', 'image/gif'])
            ->get();

        $converted = 0;
        $failed = 0;

        foreach ($images as $image) {
            try {
                $sourcePath = $image->file_path;
                if (!file_exists($sourcePath)) { $failed++; continue; }

                $webpFilename = pathinfo($image->filename, PATHINFO_FILENAME) . '.webp';

                if (Image::where('filename', $webpFilename)->exists()) { $converted++; continue; }

                $destPath = dirname($sourcePath) . '/' . $webpFilename;

                if (!convertToWebp($sourcePath, $destPath, 80)) { $failed++; continue; }

                $webpSize = filesize($destPath);
                $dimensions = getimagesize($destPath);

                $publicBase = public_path();
                $storageBase = storage_path('app/public');
                $relativePath = match (true) {
                    str_starts_with($destPath, $publicBase)  => substr($destPath, strlen($publicBase) + 1),
                    str_starts_with($destPath, $storageBase) => substr($destPath, strlen($storageBase) + 1),
                    default => pathinfo($image->path, PATHINFO_DIRNAME) . '/' . $webpFilename,
                };
                Image::create([
                    'original_name' => pathinfo($image->original_name, PATHINFO_FILENAME) . '.webp',
                    'filename' => $webpFilename,
                    'path' => $relativePath,
                    'url' => 'storage/' . $relativePath,
                    'mime_type' => 'image/webp',
                    'size' => $webpSize,
                    'width' => $dimensions[0] ?? null,
                    'height' => $dimensions[1] ?? null,
                    'alt_text' => $image->alt_text,
                    'title' => $image->title,
                    'attachable_type' => $image->attachable_type,
                    'attachable_id' => $image->attachable_id,
                ]);

                $converted++;
            } catch (\Exception $e) {
                $failed++;
            }
        }

        return back()->with('success', "{$converted} images converted to WebP." . ($failed ? " {$failed} failed." : ''));
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'No images selected.');
        }

        $images = Image::whereIn('id', $ids)->get();

        $deleted = 0;
        foreach ($images as $image) {
            $filePath = $image->file_path;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $image->delete();
            $deleted++;
        }

        return back()->with('success', "{$deleted} images deleted successfully.");
    }

    public function bulkMarkUnused(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'No images selected.');
        }

        Image::whereIn('id', $ids)->update([
            'attachable_type' => null,
            'attachable_id' => null,
        ]);

        return back()->with('success', count($ids) . ' images marked as unused.');
    }
}
