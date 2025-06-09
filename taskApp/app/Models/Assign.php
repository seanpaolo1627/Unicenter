<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{

    use HasFactory;

    protected $table = 'assign_designations';

    protected $fillable = [
        'emp_num',
        'designation_id',
        'employee_type',
        'probationary',
        'daily_role',
        'status'
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_num', 'emp_num');
    }
}