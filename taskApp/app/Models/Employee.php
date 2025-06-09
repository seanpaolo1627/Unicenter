<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employeasts';

    protected $fillable = [
        'emp_num',
        'lastname',
        'firstname',
        'middlename',
        'address_line',
        'brgy',
        'city',
        'province',
        'zipcode'
    ];
    
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
