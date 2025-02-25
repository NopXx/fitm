<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DepartmentViewController extends Controller
{
    public function index($id) {
        $id = Departments::where('department_code', $id)->first();
        $department = Departments::with('content')->findOrFail($id->id);
        Log::debug($department);
        return view('department.index', compact('department'));
    }
}
