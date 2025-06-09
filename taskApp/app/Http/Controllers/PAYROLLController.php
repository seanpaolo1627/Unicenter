<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use Illuminate\Support\Facades\Validator;

class PayrollController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|integer|exists:employeasts,id',
            'basic_salary' => 'required|numeric',
            'additionals' => 'required|numeric',
            'deductions' => 'required|numeric',
            'government_contributions' => 'required|numeric',
            'professional_tax' => 'required|numeric',
            'loans' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $total_net_pay = $request->basic_salary + $request->additionals - ($request->deductions + $request->government_contributions + $request->professional_tax + $request->loans);

        $payroll = Payroll::create(array_merge($request->all(), ['total_net_pay' => $total_net_pay]));

        return response()->json(['message' => 'Payroll created successfully', 'data' => $payroll], 201);
    }
    public function index()
    {
        $payrolls = Payroll::with('employee')->get(); // Assuming you have a relationship set up in your Payroll model
    
        return response()->json([
            'status' => 200,
            'payrolls' => $payrolls
        ]);
    }    
}
