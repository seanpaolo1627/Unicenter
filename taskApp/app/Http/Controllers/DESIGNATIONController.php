<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;
use Illuminate\Support\Facades\Validator;

class DESIGNATIONController extends Controller
{
    public function index()
    {
        $designations = Designation::all();
        if ($designations->count() > 0) {
            return response()->json([
                'status' => 200,
                'designations' => $designations
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
            'designation_name' => 'required|string|max:191',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:ACTIVE,INACTIVE'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $designation = Designation::create([
            'designation_name' => $request->designation_name,
            'department_id' => $request->department_id,
            'status' => $request->status
        ]);

        if ($designation) {
            return response()->json([
                'status' => 200,
                'message' => "Designation added successfully.",
                'designation' => $designation
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Error."
            ], 500);
        }
    }

    public function show($id)
    {
        $designation = Designation::find($id);
        if ($designation) {
            return response()->json([
                'status' => 200,
                'designation' => $designation
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Designation not found."
            ], 404);
        }
    }

    public function edit($id)
    {
        $designation = Designation::find($id);
        if ($designation) {
            return response()->json([
                'status' => 200,
                'designation' => $designation
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Designation not found."
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'designation_name' => 'required|string|max:191',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:ACTIVE,INACTIVE'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $designation = Designation::find($id);
        if ($designation) {
            $designation->update([
                'designation_name' => $request->designation_name,
                'department_id' => $request->department_id,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Designation updated successfully.",
                'designation' => $designation
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Designation not found."
            ], 404);
        }
    }

    public function destroy($id)
    {
        $designation = Designation::find($id);
        if ($designation) {
            $designation->delete();
            return response()->json([
                'status' => 200,
                'message' => "Designation removed."
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Designation not found."
            ], 404);
        }
    }
}