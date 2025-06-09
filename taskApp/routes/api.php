<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DEPARTMENTController;
use App\Http\Controllers\EMPLOYEEController;
use App\Http\Controllers\DESIGNATIONController;
use App\Http\Controllers\ASSIGNController;
use App\Http\Controllers\PayrollController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Employee Routes
Route::get('employees', [EMPLOYEEController::class, 'index']);
Route::post('employees', [EMPLOYEEController::class, 'store']);
Route::get('employees/{id}', [EMPLOYEEController::class, 'show']);
Route::get('employees/{id}/edit', [EMPLOYEEController::class, 'edit']);
Route::put('employees/{id}/edit', [EMPLOYEEController::class, 'update']);
Route::delete('employees/{id}/delete', [EMPLOYEEController::class, 'destroy']);

// Department Routes
Route::get('departments', [DEPARTMENTController::class, 'index']);
Route::post('departments', [DEPARTMENTController::class, 'store']);
Route::get('departments/{id}', [DEPARTMENTController::class, 'show']);
Route::get('departments/{id}/edit', [DEPARTMENTController::class, 'edit']);
Route::put('departments/{id}/edit', [DEPARTMENTController::class, 'update']);
Route::delete('departments/{id}/delete', [DEPARTMENTController::class, 'destroy']);

// Designation Routes
Route::get('designation', [DESIGNATIONController::class, 'index']);
Route::post('designation', [DESIGNATIONController::class, 'store']);
Route::get('designation/{id}', [DESIGNATIONController::class, 'show']);
Route::get('designation/{id}/edit', [DESIGNATIONController::class, 'edit']);
Route::put('designation/{id}/edit', [DESIGNATIONController::class, 'update']);
Route::delete('designation/{id}/delete', [DESIGNATIONController::class, 'destroy']);

// Assign Designations Routes
Route::get('assign_designations', [ASSIGNController::class, 'index']);
Route::post('assign_designations', [ASSIGNController::class, 'store']);
Route::get('assign_designations/{id}', [ASSIGNController::class, 'show']);
Route::get('assign_designations/{id}/edit', [ASSIGNController::class, 'edit']);
Route::put('assign_designations/{id}/edit', [ASSIGNController::class, 'update']);
Route::delete('assign_designations/{id}/delete', [ASSIGNController::class, 'destroy']);

// Payroll Routes
Route::get('/payrolls', [PayrollController::class, 'index']);
Route::post('/payrolls', [PayrollController::class, 'store']);
Route::get('/payrolls/{id}', [PayrollController::class, 'show']);
Route::put('/payrolls/{id}', [PayrollController::class, 'update']);
Route::delete('/payrolls/{id}', [PayrollController::class, 'destroy']);
