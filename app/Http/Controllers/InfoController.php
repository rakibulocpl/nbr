<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function deskByDepartment(Request $request){
        try {
            $departmentId = $request->get('department_id');

            if (!$departmentId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Department ID is required.',
                    'data' => []
                ], 400);
            }

            // Load desks using the relationship
            $department = Department::with('desks')->find($departmentId);

            if (!$department) {
                return response()->json([
                    'status' => false,
                    'message' => 'Department not found.',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Desks loaded successfully.',
                'data' => $department->desks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
