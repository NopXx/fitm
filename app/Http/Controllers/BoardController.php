<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    /**
     * Display a listing of the boards.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $boards = Board::all();
            return response()->json($boards);
        }

        return view('board.index');
    }

    /**
     * Show the form for creating a new board.
     */
    public function add()
    {
        return view('board.add');
    }

    /**
     * Store a newly created board in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'board_name_th' => 'required|string|max:255',
            'board_name_en' => 'nullable|string|max:255',
            'display_order' => 'required|integer|min:0',
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
            $board = new Board();
            $board->board_name_th = $request->board_name_th;
            $board->board_name_en = $request->board_name_en;
            $board->display_order = $request->display_order;
            $board->is_active = $request->is_active;
            $board->save();

            return response()->json([
                'status' => true,
                'message' => __('boards.add_success'),
                'redirect' => route('boards.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified board.
     */
    public function edit($id)
    {
        $board = Board::findOrFail($id);
        return view('board.edit', compact('board'));
    }

    /**
     * Update the specified board in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'board_name_th' => 'required|string|max:255',
            'board_name_en' => 'nullable|string|max:255',
            'display_order' => 'required|integer|min:0',
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
            $board = Board::findOrFail($id);
            $board->board_name_th = $request->board_name_th;
            $board->board_name_en = $request->board_name_en;
            $board->display_order = $request->display_order;
            $board->is_active = $request->is_active;
            $board->save();

            return response()->json([
                'status' => true,
                'message' => __('boards.update_success'),
                'redirect' => route('boards.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified board from storage.
     */
    public function destroy($id)
    {
        try {
            $board = Board::findOrFail($id);

            // Check if board has related personnel
            if ($board->personnel()->count() > 0) {
                return response()->json([
                    'status' => false,
                    'message' => __('boards.delete_failed_has_personnel')
                ]);
            }

            $board->delete();

            return response()->json([
                'status' => true,
                'message' => __('boards.delete_success')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
