<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class EMPLOYEEController extends Controller
{
    public function index()
    {
        $employeasts = Employee::all();
        if($employeasts->count() > 0){

            return response()->json([
                'status' => 200,
                'employees' => $employeasts
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
            'emp_num' => 'required|string|max:191',
            'lastname' => 'required|string|max:191',
            'firstname' => 'required|string|max:191',
            'middlename' => 'required|string|max:191',
            'address_line' => 'required|string|max:191',
            'brgy' => 'required|string|max:191',
            'city' => 'required|string|max:191',
            'province' => 'required|string|max:191',
            'zipcode' => 'required|string|max:191'
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $employee = Employee::create([
                'emp_num' => $request->emp_num,
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'address_line' => $request->address_line,
                'brgy' => $request->brgy,
                'city' => $request->city,
                'province' => $request->province,
                'zipcode' => $request->zipcode
            ]);

            if($employee){

                return response()->json([
                    'status' => 200,
                    'message' => "Employee Added."
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
        $employee = Employee::find($id);
        if($employee){

            return response()->json([
                    'status' => 200,
                    'employee' => $employee
                ], 200);

        }else{

            return response()->json([
                    'status' => 404,
                    'message' => "Employee not found."
                ], 404);

        }
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        if($employee){

            return response()->json([
                    'status' => 200,
                    'employee' => $employee
                ], 200);

        }else{

            return response()->json([
                    'status' => 404,
                    'message' => "Employee not found."
                ], 404);

        }
    }

     public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'emp_num' => 'required|string|max:191',
            'lastname' => 'required|string|max:191',
            'firstname' => 'required|string|max:191',
            'middlename' => 'required|string|max:191',
            'address_line' => 'required|string|max:191',
            'brgy' => 'required|string|max:191',
            'city' => 'required|string|max:191',
            'province' => 'required|string|max:191',
            'zipcode' => 'required|string|max:191'
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $employee = Employee::find($id);

            if($employee){

                $employee->update([
                    'emp_num' => $request->emp_num,
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'middlename' => $request->middlename,
                    'address_line' => $request->address_line,
                    'brgy' => $request->brgy,
                    'city' => $request->city,
                    'province' => $request->province,
                    'zipcode' => $request->zipcode
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Edit Successful."
                ], 200);
            }else{
                 return response()->json([
                    'status' => 404,
                    'message' => "Employee not found."
                ], 404);

            }
        }
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if($employee){

            $employee->delete();
            return response()->json([
                    'status' => 200,
                    'message' => "Employee removed."
                ], 200);
        }else{
             return response()->json([
                    'status' => 404,
                    'message' => "Employee not found."
                ], 404);
        }
    }

    }


