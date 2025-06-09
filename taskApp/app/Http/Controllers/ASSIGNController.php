<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assign;
use Illuminate\Support\Facades\Validator;

class ASSIGNController extends Controller
{
    public function index()
    {
        $assign_designation = Assign::with('employee')->get();
        if ($assign_designation->count() > 0) {
            $assigns = $assign_designation->map(function($assign) {
                return [
                    'id' => $assign->id,
                    'emp_num' => $assign->emp_num,
                    'firstname' => $assign->employee ? $assign->employee->firstname : null,
                    'lastname' => $assign->employee ? $assign->employee->lastname : null,
                    'designation_id' => $assign->designation_id,
                    'employee_type' => $assign->employee_type,
                    'probationary' => $assign->probationary,
                    'daily_role' => $assign->daily_role,
                    'status' => $assign->status
                ];
            });
            return response()->json([
                'status' => 200,
                'assigns' => $assigns
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No records found.'
            ], 404);
        }
    }

    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'emp_num' => 'required|string|max:255',
            'designation_id' => 'required|exists:designations,id',
            'employee_type' => 'required|in:REGULAR,PROJECT,SEASONAL,FIXED-TERM,CASUAL,PROBATIONARY',
            'probationary' => 'required|string|max:255',
            'daily_role' => 'required|string|max:255',
            'status' => 'required|in:ACTIVE,RESIGNED,AWOL'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $assign = Assign::create([
            'emp_num' => $request->emp_num,
            'designation_id' => $request->designation_id,
            'employee_type' => $request->employee_type,
            'probationary' => $request->probationary,
            'daily_role' => $request->daily_role,
            'status' => $request->status
        ]);

        if ($assign) {
            return response()->json([
                'status' => 200,
                'message' => 'Role assignment added successfully.',
                'assign' => $assign
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Error.'
            ], 500);
        }
    }

    public function show($id)
    {
        $assign = Assign::find($id);
        if ($assign) {
            return response()->json([
                'status' => 200,
                'assign' => $assign
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Role assignment not found.'
            ], 404);
        }
    }

    public function edit($id)
    {
        $assign = Assign::find($id);
        if ($assign) {
            return response()->json([
                'status' => 200,
                'assign' => $assign
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'role assignment not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'emp_num' => 'required|string|max:255',
            'designation_id' => 'required|exists:designations,id',
            'employee_type' => 'required|in:REGULAR,PROJECT,SEASONAL,FIXED-TERM,CASUAL,PROBATIONARY',
            'probationary' => 'required|string|max:255',
            'daily_role' => 'required|string|max:255',
            'status' => 'required|in:ACTIVE,RESIGNED,AWOL'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $assign = Assign::find($id);
        if ($assign) {
            $assign->update([
                'emp_num' => $request->emp_num,
                'designation_id' => $request->designation_id,
                'employee_type' => $request->employee_type,
                'probationary' => $request->probationary,
                'daily_role' => $request->daily_role,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Role assignment updated successfully.',
                'assign' => $assign
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Role assignment not found.'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $assign = Assign::find($id);
        if ($assign) {
            $assign->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Role assignment removed.'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Role assignment not found.'
            ], 404);
        }
    }
}