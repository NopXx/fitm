<?php

namespace App\Http\Controllers;

use App\Models\FitmVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FitmVideosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FitmVideo::latest()->get();
            return $data;
        }
        return view('fitmvideos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fitmvideos.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            FitmVideo::create([
                'name' => $request->name,
                'url' => $this->convertYouTubeUrl($request->url),
                'is_important' => $request->has('is_important') ? true : false,
            ]);

            return response()->json([
                'status' => true,
                'message' => __('fitmvideos.add_success'),
                'redirect' => route('fitmvideos.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('fitmvideos.add_error') . ': ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $video = FitmVideo::findOrFail($id);
        return view('fitmvideos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $video = FitmVideo::findOrFail($id);
            $video->update([
                'name' => $request->name,
                'url' => $this->convertYouTubeUrl($request->url),
                'is_important' => $request->has('is_important') ? true : false,
            ]);

            return response()->json([
                'status' => true,
                'message' => __('fitmvideos.update_success'),
                'redirect' => route('fitmvideos.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('fitmvideos.update_error') . ': ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $video = FitmVideo::findOrFail($id);
            $video->delete();

            return response()->json([
                'status' => true,
                'message' => __('fitmvideos.delete_success'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('fitmvideos.delete_error') . ': ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Convert YouTube URL to embeddable format.
     */
    private function convertYouTubeUrl($url)
    {
        if (preg_match('/(?:youtu\\.be\\/|youtube\\.com\\/(?:watch\\?v=|embed\\/|v\\/|shorts\\/))([\\w-]+)/', $url, $matches)) {
            $videoId = $matches[1];
            return "https://www.youtube.com/embed/$videoId";
        }
        return $url;
    }
}
