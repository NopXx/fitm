<?php

namespace App\Http\Controllers;

use App\Models\DepartmentContent;
use App\Models\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DepartmentContentController extends Controller
{
    public function edit($departmentId)
    {
        try {
            $department = Departments::with('content')->findOrFail($departmentId);

            return view('departments.content.edit', compact('department'));
        } catch (\Exception $e) {
            return redirect()->route('departments.index')
                ->with('error', 'Department not found');
        }
    }

    public function update(Request $request, $departmentId)
    {
        $validator = Validator::make($request->all(), [
            'overview' => 'required',
            'status' => 'required|in:draft,published'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $department = Departments::findOrFail($departmentId);

            $contentData = [
                'overview' => $request->overview,
                'status' => $request->status
            ];

            $department->content()->updateOrCreate(
                ['department_id' => $departmentId],
                $contentData
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Content updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update content'
            ], 500);
        }
    }

    public function preview($departmentId)
    {
        try {
            $department = Departments::with('content')->findOrFail($departmentId);

            return view('departments.content.preview', compact('department'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found'
            ], 404);
        }
    }
}
