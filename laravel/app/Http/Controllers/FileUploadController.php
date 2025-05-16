<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class FileUploadController extends Controller
{public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
        'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        // Store the file
        $path = $request->file('document')->store('uploads');
        // Return a response
        return response()->json(['path' => $path], 200);
    }

    public function uploadMinio(Request $request)
    {
        // Validate the request
        $request->validate([
        'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $doc = $request->file('document');
        $filename = uniqid() . '.' . $doc->getClientOriginalExtension();

        try {
            $path = $doc->storeAs('uploads', $filename, ['disk' => 'minio']);
            return response()->json(['path' => $path], 200);
        } catch (\Exception $e) {   
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        // Validate image
        $request->validate([
            // 'image' => 'required|image|max:2048',
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $image = $request->file('document'); // this must not be null!
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();

        // Store original to MinIO
        $originalPath = 'uploads/' . $fileName;
        Storage::disk('minio')->put($originalPath, file_get_contents($image));

        // Create and store thumbnail
        $thumbnailPath = 'thumbnails/' . $fileName;
        $thumbnailImage = InterventionImage::make($image)->fit(200, 200)->encode();
        Storage::disk('minio')->put($thumbnailPath, (string) $thumbnailImage);

        return response()->json([
            'original' => config('filesystems.disks.minio.url') . '/' . $originalPath,
            'thumbnail' => config('filesystems.disks.minio.url') . '/' . $thumbnailPath,
        ]);
    }
}