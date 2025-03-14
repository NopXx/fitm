<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PersonnelAdminController extends Controller
{
    /**
     * Display a listing of the personnel.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $personnel = Personnel::with('board')->get();
            return response()->json($personnel);
        }

        return view('personnel.index');
    }

    /**
     * Show the form for creating a new personnel.
     */
    public function add()
    {
        $boards = Board::where('is_active', true)->orderBy('display_order')->get();
        return view('personnel.add', compact('boards'));
    }

    /**
     * Store a newly created personnel in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'board_id' => 'required|exists:boards,id',
            'firstname_th' => 'required|string|max:255',
            'lastname_th' => 'required|string|max:255',
            'firstname_en' => 'nullable|string|max:255',
            'lastname_en' => 'nullable|string|max:255',
            'position_th' => 'required|string|max:255',
            'position_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'required|integer|min:0',
            'order_title_th' => 'nullable|string|max:255',
            'order_title_en' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'is_active' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $personnel = new Personnel();
            $personnel->board_id = $request->board_id;
            $personnel->firstname_th = $request->firstname_th;
            $personnel->lastname_th = $request->lastname_th;
            $personnel->firstname_en = $request->firstname_en;
            $personnel->lastname_en = $request->lastname_en;
            $personnel->position_th = $request->position_th;
            $personnel->position_en = $request->position_en;
            $personnel->display_order = $request->display_order;
            $personnel->order_title_th = $request->order_title_th;
            $personnel->order_title_en = $request->order_title_en;
            $personnel->email = $request->email;
            $personnel->phone = $request->phone;
            $personnel->is_active = $request->is_active;

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('personnel', 'public');
                $personnel->image = $imagePath;
            }

            $personnel->save();

            return response()->json([
                'status' => true,
                'message' => __('personnel.add_success'),
                'redirect' => route('personnel.admin.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified personnel.
     */
    public function edit($id)
    {
        $personnel = Personnel::findOrFail($id);
        $boards = Board::where('is_active', true)->orderBy('display_order')->get();
        return view('personnel.edit', compact('personnel', 'boards'));
    }

    /**
     * Update the specified personnel in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'board_id' => 'required|exists:boards,id',
            'firstname_th' => 'required|string|max:255',
            'lastname_th' => 'required|string|max:255',
            'firstname_en' => 'nullable|string|max:255',
            'lastname_en' => 'nullable|string|max:255',
            'position_th' => 'required|string|max:255',
            'position_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'required|integer|min:0',
            'order_title_th' => 'nullable|string|max:255',
            'order_title_en' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'is_active' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $personnel = Personnel::findOrFail($id);
            $personnel->board_id = $request->board_id;
            $personnel->firstname_th = $request->firstname_th;
            $personnel->lastname_th = $request->lastname_th;
            $personnel->firstname_en = $request->firstname_en;
            $personnel->lastname_en = $request->lastname_en;
            $personnel->position_th = $request->position_th;
            $personnel->position_en = $request->position_en;
            $personnel->display_order = $request->display_order;
            $personnel->order_title_th = $request->order_title_th;
            $personnel->order_title_en = $request->order_title_en;
            $personnel->email = $request->email;
            $personnel->phone = $request->phone;
            $personnel->is_active = $request->is_active;

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($personnel->image) {
                    Storage::disk('public')->delete($personnel->image);
                }

                $imagePath = $request->file('image')->store('personnel', 'public');
                $personnel->image = $imagePath;
            }

            $personnel->save();

            return response()->json([
                'status' => true,
                'message' => __('personnel.update_success'),
                'redirect' => route('personnel.admin.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified personnel from storage.
     */
    public function destroy($id)
    {
        try {
            $personnel = Personnel::findOrFail($id);

            // Delete image if exists
            if ($personnel->image) {
                Storage::disk('public')->delete($personnel->image);
            }

            $personnel->delete();

            return response()->json([
                'status' => true,
                'message' => __('personnel.delete_success')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
