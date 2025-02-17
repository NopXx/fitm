<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'mediable_type' => 'required|string',
            'mediable_id' => 'required|integer'
        ]);

        try {
            $file = $request->file('file');
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs(
                'uploads/' . $request->mediable_type,
                $fileName,
                'public'
            );

            $media = Media::create([
                'file_name' => $fileName,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'path' => asset('storage/' . $path), // Return full URL
                'disk' => 'public',
                'mediable_type' => $request->mediable_type,
                'mediable_id' => $request->mediable_id
            ]);

            return response()->json([
                'success' => true,
                'media' => $media
            ]);
        } catch (\Exception $e) {
            Log::debug($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload file'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $media = Media::findOrFail($id);
            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Media deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete media'
            ], 500);
        }
    }

    public function browse(Request $request)
    {
        $query = Media::query();

        if ($request->type) {
            $query->where('mime_type', 'like', $request->type . '%');
        }

        if ($request->mediable_type) {
            $query->where('mediable_type', $request->mediable_type);
        }

        $media = $query->latest()->paginate(20);

        return response()->json([
            'success' => true,
            'media' => $media
        ]);
    }
}
