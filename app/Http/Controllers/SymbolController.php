<?php

namespace App\Http\Controllers;

use App\Models\Symbol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SymbolController extends Controller
{
    public function index()
    {
        $symbols = Symbol::orderBy('id', 'asc')->get();
        return view('symbols.index', compact('symbols'));
    }

    public function create()
    {
        return view('symbols.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'name_th' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_th' => 'required|string',
            'description_en' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'download_link' => 'nullable|string|max:255',
            'rgb_code' => 'nullable|string|max:7',
            'cmyk_code' => 'nullable|string|max:50'
        ]);

        try {
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('symbols', 'public');
                $validated['image_path'] = $path;
            }

            Symbol::create($validated);

            return redirect()
                ->route('symbols.index')
                ->with('success', 'บันทึกข้อมูลสำเร็จ');
        } catch (\Exception $e) {
            Log::error('Error creating symbol: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
        }
    }

    public function edit($id)
    {
        $symbol = Symbol::findOrFail($id);
        return view('symbols.edit', compact('symbol'));
    }

    public function update(Request $request, $id)
    {
        $symbol = Symbol::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'name_th' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_th' => 'required|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'download_link' => 'nullable|string|max:255',
            'rgb_code' => 'nullable|string|max:7',
            'cmyk_code' => 'nullable|string|max:50'
        ]);

        try {
            if ($request->input('remove_image') == '1' && $symbol->image_path) {
                Storage::disk('public')->delete($symbol->image_path);
                $symbol->image_path = null;
            }

            if ($request->hasFile('image')) {
                if ($symbol->image_path) {
                    Storage::disk('public')->delete($symbol->image_path);
                }
                $path = $request->file('image')->store('symbols', 'public');
                $validated['image_path'] = $path;
            }

            $symbol->update($validated);

            return redirect()
                ->route('symbols.index')
                ->with('success', 'อัพเดทข้อมูลสำเร็จ');
        } catch (\Exception $e) {
            Log::error('Error updating symbol: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'เกิดข้อผิดพลาดในการอัพเดทข้อมูล');
        }
    }

    public function destroy($id)
    {
        try {
            $symbol = Symbol::findOrFail($id);

            if ($symbol->image_path) {
                Storage::disk('public')->delete($symbol->image_path);
            }

            $symbol->delete();

            return response()->json([
                'success' => true,
                'message' => 'ลบข้อมูลสำเร็จ'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting symbol: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล'
            ], 500);
        }
    }
}
