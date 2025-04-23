<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            'title_en',
            'code',
            'created_at',
            'updated_at'
        ])->orderBy('updated_at', 'desc')->get();

        return response()->json($contents);
    }

    public function frontend($code)
    {
        $content = Content::where('code', $code)->first();

        if (!$content) {
            return redirect()->route('home')->with('error', 'Content not found');
        }

        return view('contents.frontend', compact('content'));
    }

    public function create()
    {
        return view('contents.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_th' => 'required|max:255',
            'title_en' => 'nullable|max:255',
            'detail_th' => 'required',
            'detail_en' => 'nullable',
            'code' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Auto-generate code if empty or consists only of whitespace
            $code = $request->code;
            if (empty(trim($code))) {
                $code = $this->generateUniqueCode($request->title_th ?? $request->title_en);
            }
            Log::info("Auto-generated code: {$code}");

            $content = Content::create([
                'title_th' => $request->title_th,
                'title_en' => $request->title_en,
                'detail_th' => $request->detail_th,
                'detail_en' => $request->detail_en,
                'code' => $code
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
            Log::error('Content edit failed: ' . $e->getMessage());
            return redirect()->route('contents.index')
                ->with('error', 'Content not found');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title_th' => 'required|max:255',
            'title_en' => 'nullable|max:255',
            'detail_th' => 'required',
            'detail_en' => 'nullable',
            'code' => 'required|max:100|unique:contents,code,' . $id
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

            // Auto-generate code if empty or consists only of whitespace
            $code = $request->code;
            if (empty(trim($code))) {
                $code = $this->generateUniqueCode($request->title_th ?? $request->title_en);
            }

            $content->update([
                'title_th' => $request->title_th,
                'title_en' => $request->title_en,
                'detail_th' => $request->detail_th,
                'detail_en' => $request->detail_en,
                'code' => $code
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Content updated successfully',
                'content' => $content
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Content update failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $content = Content::findOrFail($id);
            $contentName = $content->title_th ?? $content->title_en;

            $content->delete();

            Log::info("Content deleted: ID {$id}, Title: {$contentName}");

            return response()->json([
                'success' => true,
                'message' => 'Content deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Content deletion failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete content'
            ], 500);
        }
    }

    /**
     * Generate a unique code based on the title
     *
     * @param string $title
     * @return string
     */
    private function generateUniqueCode($title)
    {
        Log::debug($title);

        // Check if the title is in Thai or other non-Latin script
        if (!preg_match('/[a-zA-Z0-9]/', $title)) {
            // For non-Latin titles, create a transliterated version if possible
            // or generate a random code if transliteration yields empty result
            $transliterated = Str::ascii($title);

            if (empty(trim($transliterated))) {
                // If transliteration gives empty result, use timestamp and random string
                $code = time() . '-' . Str::random(5);
            } else {
                $code = Str::slug($transliterated);
            }
        } else {
            // For Latin-based titles, use normal slug
            $code = Str::slug($title);
        }

        // Limit the length to avoid overly long codes
        $code = Str::limit($code, 80, '');

        // If slug is empty after processing, generate a fallback
        if (empty($code)) {
            $code = time() . '-' . Str::random(5);
        }

        // Check if code already exists
        $count = 0;
        $originalCode = $code;

        while (Content::where('code', $code)->exists()) {
            $count++;
            $code = $originalCode . '-' . $count;
        }
        Log::debug($code);

        return $code;
    }

    /**
     * Bulk operations for content
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete',
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:contents,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            if ($request->action === 'delete') {
                $deletedCount = Content::whereIn('id', $request->ids)->delete();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => "{$deletedCount} content items deleted successfully"
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => false,
                'message' => 'Unknown action specified'
            ], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk action failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to perform bulk action',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search content by title or code
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (empty($query)) {
            return $this->show();
        }

        $contents = Content::where('title_th', 'LIKE', "%{$query}%")
            ->orWhere('title_en', 'LIKE', "%{$query}%")
            ->orWhere('code', 'LIKE', "%{$query}%")
            ->select(['id', 'title_th', 'title_en', 'code', 'created_at', 'updated_at'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json($contents);
    }
}
