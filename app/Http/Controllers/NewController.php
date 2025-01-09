<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NewController extends Controller
{
    public function index()
    {
        return view('news.index');
    }

    public function getNews() {
        $new = News::all();
        return response()->json($new);
    }

    public function add()
    {
        return view('news.add');
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            // 'new_type' => 'required|integer',
            'title' => 'required|string|max:255',
            'detail' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,png|max:5120', // Max 5MB
            'effective_date' => 'required|date',
            'link' => 'nullable|url',
            'status' => 'required|integer|in:0,1', // 0 = inactive, 1 = active
        ]);

        // Handle file upload
        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('news', 'public');
        }

        // Insert into database
        $new = new News();

        // $new->new_type = $request->new_type;
        $new->title = $request->title;
        $new->deatil = $request->detail;
        $new->cover = $coverPath;
        $new->effective_date = $request->effective_date;
        $new->view_count = 0; // Default view count
        $new->link = $request->link;
        $new->status = $request->status;
        $new->created_at = now();
        $new->created_by = Auth::id(); // Assuming the user is logged in
        $new->updated_at = now();
        $new->updated_by = Auth::id();
        $new->save();

        if ($new) {
            return redirect()->route('new.index')->with('success', 'News added successfully.');
        } else {
            return back()->with('error', 'Failed to add news. Please try again.');
        }
    }
}
