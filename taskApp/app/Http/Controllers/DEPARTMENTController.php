<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;

class DEPARTMENTController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        if($departments->count() > 0){

            return response()->json([
                'status' => 200,
                'departments' => $departments
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No records found.'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dept_name' => 'required|string|max:191',
            'status' => 'required|in:ACTIVE,INACTIVE'
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $department = Department::create([
                'dept_name' => $request->dept_name,
                'status' => $request->status
            ]);

            if($department){

                return response()->json([
                    'status' => 200,
                    'message' => "Department Added."
                ], 200);
            }else{
                 return response()->json([
                    'status' => 500,
                    'message' => "Error."
                ], 500);

            }
        }
    }

    public function show($id)
    {
        $department = Department::find($id);
        if($department){

            return response()->json([
                    'status' => 200,
                    'department' => $department
                ], 200);

        }else{

            return response()->json([
                    'status' => 404,
                    'message' => "Department not found."
                ], 404);

        }
    }

    public function edit($id)
    {
        $department = Department::find($id);
        if($department){

            return response()->json([
                    'status' => 200,
                    'department' => $department
                ], 200);

        }else{

            return response()->json([
                    'status' => 404,
                    'message' => "Department not found."
                ], 404);

        }
    }

     public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'dept_name' => 'required|string|max:191',
            'status' => 'required|in:ACTIVE,INACTIVE'
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $department = Department::find($id);

            if($department){

                $department->update([
                    'dept_name' => $request->dept_name,
                    'status' => $request->status
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Edit Successful."
                ], 200);
            }else{
                 return response()->json([
                    'status' => 404,
                    'message' => "Department not found."
                ], 404);

            }
        }
    }

    public function destroy($id)
    {
        $department = Department::find($id);
        if($department){

            $department->delete();
            return response()->json([
                    'status' => 200,
                    'message' => "Successfully removed."
                ], 200);
        }else{
             return response()->json([
                    'status' => 404,
                    'message' => "Item not found."
                ], 404);
        }
    }

}


