<?php

namespace App\Http\Controllers;

use App\Models\Careers;
use App\Models\DepartmentContent;
use App\Models\Departments;
use App\Models\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('departments.index');
    }

    // Department Methods
    public function getDepartments()
    {
        $departments = Departments::select([
            'id',
            'department_code',
            'department_name_th'
        ])->get();

        return response()->json($departments);
    }

    public function createDepartment()
    {
        return view('departments.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_code' => 'required',
            'department_name_th' => 'required',
            'overview' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Create department
            $department = Departments::create([
                'department_code' => $request->department_code,
                'department_name_th' => $request->department_name_th
            ]);

            // Create department content
            if ($department) {
                DepartmentContent::create([
                    'department_id' => $department->id,
                    'overview' => $request->overview,
                    'status' => 'draft'
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('department.created_success'),
                'department' => $department
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Department creation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('department.create_error'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function editDepartment($id)
    {
        try {
            $department = Departments::with('content')->findOrFail($id);
            Log::debug($department);
            return view('departments.edit', compact('department'));
        } catch (\Exception $e) {
            return redirect()->route('departments.index')
                ->with('error', 'Department not found');
        }
    }

    public function updateDepartment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'department_code' => 'required|unique:departments,department_code,' . $id . ',id', // Changed from department_id to id
            'department_name_th' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $department = Departments::findOrFail($id);
            $department->update([
                'department_code' => $request->department_code,
                'department_name_th' => $request->department_name_th
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Department updated successfully',
                'department' => $department
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update department'
            ], 500);
        }
    }

    // Existing Delete Methods
    public function destroy($id)
    {
        try {
            Departments::findOrFail($id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::debug($e);
            return response()->json(['success' => false], 500);
        }
    }
}
