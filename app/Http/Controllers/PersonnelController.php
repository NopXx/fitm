<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Personnel;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    /**
     * แสดงหน้าบุคลากรทั้งหมด
     */
    public function index(Request $request)
    {
        $boards = Board::where('is_active', true)
            ->orderBy('display_order')
            ->with(['personnel' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('display_order')
                    ->orderBy('created_at');
            }])
            ->get();

        return view('personnel.frontend', compact('boards'));
    }

    /**
     * แสดงรายละเอียดของบุคลากรตาม board_id
     */
    public function showByBoard(Request $request, $board_id)
    {
        $board = Board::findOrFail($board_id);
        $personnel = Personnel::where('board_id', $board_id)
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('personnel.board', compact('board', 'personnel'));
    }

    /**
     * แสดงรายละเอียดของบุคลากรรายบุคคล
     */
    public function show(Request $request, $id)
    {
        $person = Personnel::findOrFail($id);

        return view('personnel.show', compact('person'));
    }
}
