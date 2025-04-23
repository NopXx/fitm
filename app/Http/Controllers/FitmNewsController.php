<?php

namespace App\Http\Controllers;

use App\Models\FitmNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FitmNewsController extends Controller
{
    /**
     * Display a listing of the news.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $news = FitmNews::orderBy('published_date', 'desc')->get();
            return response()->json($news);
        }

        return view('fitmnews.index');
    }

    /**
     * Show the form for creating a new news item.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('fitmnews.add');
    }

    /**
     * Store a newly created news item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'issue_name' => 'required|string|max:255',
            'title_th' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_th' => 'nullable|string',
            'description_en' => 'nullable|string',
            'published_date' => 'required|date',
            'url' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except('cover_image');

        // Handle file upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('fitmnews', 'public');
            $data['cover_image'] = $path;
        }

        FitmNews::create($data);

        return redirect()->route('fitmnews.index')
            ->with('success', __('fitmnews.create_success'));
    }

    /**
     * Show the form for editing the specified news item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = FitmNews::findOrFail($id);
        return view('fitmnews.edit', compact('news'));
    }

    /**
     * Update the specified news item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'issue_name' => 'required|string|max:255',
            'title_th' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_th' => 'nullable|string',
            'description_en' => 'nullable|string',
            'published_date' => 'required|date',
            'url' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:4048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $news = FitmNews::findOrFail($id);
        $data = $request->except(['cover_image', 'file_changed']);

        // Handle file upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($news->cover_image) {
                Storage::disk('public')->delete($news->cover_image);
            }

            $path = $request->file('cover_image')->store('fitmnews', 'public');
            $data['cover_image'] = $path;
        } else if ($request->input('file_changed') == "1") {
            // If file_changed is set but no new file, it means the image was removed
            if ($news->cover_image) {
                Storage::disk('public')->delete($news->cover_image);
            }
            $data['cover_image'] = null;
        }

        $news->update($data);

        return redirect()->route('fitmnews.index')
            ->with('success', __('fitmnews.update_success'));
    }

    /**
     * Remove the specified news item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $news = FitmNews::findOrFail($id);

            // Delete associated image if exists
            if ($news->cover_image) {
                Storage::disk('public')->delete($news->cover_image);
            }

            $news->delete();

            return response()->json([
                'success' => true,
                'message' => __('fitmnews.delete_success')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}