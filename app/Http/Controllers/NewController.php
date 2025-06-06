<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewController extends Controller
{
    public function index()
    {
        return view('news.index');
    }

    public function getNews()
    {
        $new = News::with('new_type')->get();
        return response()->json($new);
    }

    public function show()
    {
        $newtypes = NewType::all();
        return view('news.add', compact('newtypes'));
    }

    public function store(Request $request)
    {
        Log::debug($request->all());
        try {
            // Validate input
            $request->validate([
                'title_th' => 'required|string|max:255',
                'title_en' => 'nullable|string|max:255',
                'display_type' => 'required',
                'new_type' => 'required',
                'detail_th' => 'required|string',
                'detail_en' => 'nullable|string',
                'content_th' => 'nullable|string',
                'content_en' => 'nullable|string',
                'cover' => 'nullable|string', // Allow string paths
                'effective_date' => 'required|date_format:Y-m-d',
                'link' => 'nullable|url',
                'status' => 'required|integer|in:0,1', // 0 = inactive, 1 = active
                'is_important' => 'nullable|boolean',
            ]);

            // Handle file upload
            $coverPath = null;
            if ($request->input('cover')) {
                $coverPath = Str::after($request->input('cover'), 'tmp/');
                Storage::disk('public')->move($request->input('cover'), "news/$coverPath");
            }

            // Insert into database
            $new = new News();
            $new->no = News::all()->count() + 1;
            $new->title_th = $request->title_th;
            $new->title_en = $request->title_en;
            $new->display_type = $request->display_type;
            $new->new_type = $request->new_type;
            $new->detail_th = $request->detail_th;
            $new->detail_en = $request->detail_en;
            $new->content_th = $request->content_th;
            $new->content_en = $request->content_en;
            $new->cover = $coverPath == null ? null : 'news/' . $coverPath;
            $new->effective_date = $request->effective_date;
            $new->view_count = 0; // Default view count
            $new->link = $request->link;
            $new->status = $request->status;
            $new->is_important = $request->has('is_important') ? 1 : 0;
            $new->created_at = now();
            $new->created_by = Auth::id(); // Assuming the user is logged in
            $new->updated_at = now();
            $new->updated_by = Auth::id();
            $new->save();

            Log::debug($new);

            return response()->json([
                'success' => true,
                'message' => 'News created successfully',
                'redirect' => route('new.index')
            ]);
        } catch (\Exception $e) {
            Log::error('News creation error: ' . $e->getMessage());

            // Clean up temporary file if it exists
            if ($request->input('cover')) {
                Storage::disk('public')->delete($request->input('cover'));
            }

            return response()->json([
                'success' => false,
                'message' => 'Error creating news: ' . $e->getMessage()
            ], 500);
        }
    }


    public function upload(Request $request)
    {
        try {
            if ($request->hasFile('cover')) {
                // Validate file
                $request->validate([
                    'cover' => 'required|image' // 2MB max
                ]);

                // Store file in tmp directory
                $path = $request->file('cover')->store('tmp', 'public');
                return response($path);
            }

            return response()->json(['error' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return response()->json(['error' => 'Upload failed: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $filePath = $request->getContent();
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                return response()->json(['success' => true]);
            }
            return response()->json(['error' => 'File not found'], 404);
        } catch (\Exception $e) {
            Log::error('File revert error: ' . $e->getMessage());
            return response()->json(['error' => 'Revert failed: ' . $e->getMessage()], 500);
        }
    }

    public function edit(News $new)
    {
        $newtypes = NewType::all();
        return view('news.edit', compact('new', 'newtypes'));
    }

    public function update(Request $request, News $new)
    {
        Log::debug($request->all());

        // Validate input
        $request->validate([
            'title_th' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'display_type' => 'required',
            'new_type' => 'required',
            'detail_th' => 'required|string',
            'detail_en' => 'nullable|string',
            'content_th' => 'nullable|string',
            'content_en' => 'nullable|string',
            'cover' => 'nullable|string',
            'effective_date' => 'required|date_format:Y-m-d',
            'link' => 'nullable|url',
            'status' => 'required|integer|in:0,1',
            'is_important' => 'nullable|boolean',
        ]);

        // Handle file upload
        $coverPath = $new->cover;
        if ($request->input('cover') && $request->input('cover') !== $new->cover) {
            $tmpPath = $request->input('cover');

            // Only move the file if it's from the tmp directory
            if (Str::contains($tmpPath, 'tmp/')) {
                $coverPath = Str::after($tmpPath, 'tmp/');

                // Move file from tmp to permanent location
                Storage::disk('public')->move($tmpPath, "news/$coverPath");

                // Delete old cover if exists
                if ($new->cover && Storage::disk('public')->exists($new->cover)) {
                    Storage::disk('public')->delete($new->cover);
                }

                $coverPath = "news/$coverPath";
            } else {
                // If the cover is already in storage, just update the path
                $coverPath = Str::after($tmpPath, 'storage/');
            }
        }

        $new->title_th = $request->title_th;
        $new->title_en = $request->title_en;
        $new->display_type = $request->display_type;
        $new->new_type = $request->new_type;
        $new->detail_th = $request->detail_th;
        $new->detail_en = $request->detail_en;
        $new->content_th = $request->content_th;
        $new->content_en = $request->content_en;
        $new->cover = $coverPath;
        $new->effective_date = $request->effective_date;
        $new->link = $request->link;
        $new->status = $request->status;
        $new->is_important = $request->has('is_important') ? 1 : 0;
        $new->updated_at = now();
        $new->updated_by = Auth::id();
        $new->save();

        if ($new) {
            return response()->json([
                'success' => true,
                'message' => 'News updated successfully.',
                'redirect' => route('new.index')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error creating news: '
            ], 500);
        }
    }

    public function delete(News $new)
    {
        try {
            // Delete associated cover image if it exists
            if ($new->cover && Storage::disk('public')->exists($new->cover)) {
                Storage::disk('public')->delete($new->cover);
            }

            // Soft delete the news item
            $new->deleted_at = now();
            $new->deleted_by = Auth::id();
            $new->save();

            // Perform the actual delete
            $deleted = $new->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'News deleted successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete news'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('News deletion error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error deleting news: ' . $e->getMessage()
            ], 500);
        }
    }
}
