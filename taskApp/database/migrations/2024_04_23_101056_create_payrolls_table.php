<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employeasts');
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('additionals', 10, 2)->default(0.00);
            $table->decimal('deductions', 10, 2)->default(0.00);
            $table->decimal('government_contributions', 10, 2)->default(0.00);
            $table->decimal('professional_tax', 10, 2)->default(0.00);
            $table->decimal('loans', 10, 2)->default(0.00);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_net_pay', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}