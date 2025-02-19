<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function index()
    {
        return view('contents.index');
    }

    public function show()
    {
        $contents = Content::select([
            'id',
            'title_th',
            'title_en'
        ])->get();

        return response()->json($contents);
    }

    public function create()
    {
        return view('contents.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_th' => 'required',
            'title_en' => 'required',
            'detail_th' => 'required',
            'detail_en' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $content = Content::create([
                'title_th' => $request->title_th,
                'title_en' => $request->title_en,
                'detail_th' => $request->detail_th,
                'detail_en' => $request->detail_en
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Content created successfully',
                'content' => $content
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Content creation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $content = Content::findOrFail($id);
            return view('contents.edit', compact('content'));
        } catch (\Exception $e) {
            return redirect()->route('contents.index')
                ->with('error', 'Content not found');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title_th' => 'required',
            'title_en' => 'required',
            'detail_th' => 'required',
            'detail_en' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $content = Content::findOrFail($id);
            $content->update([
                'title_th' => $request->title_th,
                'title_en' => $request->title_en,
                'detail_th' => $request->detail_th,
                'detail_en' => $request->detail_en
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Content updated successfully',
                'content' => $content
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update content'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Content::findOrFail($id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false], 500);
        }
    }
}
