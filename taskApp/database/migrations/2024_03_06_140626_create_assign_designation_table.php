<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignDesignationTable extends Migration
{
    public function up()
    {
        Schema::create('assign_designations', function (Blueprint $table) {
            $table->id();
            $table->string('emp_num');
            $table->unsignedBigInteger('designation_id');
            $table->enum('employee_type', ['REGULAR', 'PROJECT', 'SEASONAL', 'FIXED-TERM', 'CASUAL', 'PROBATIONARY']);
            $table->string('probationary');
            $table->string('daily_role');
            $table->enum('status', ['ACTIVE', 'RESIGNED', 'AWOL']);
            $table->timestamps();

            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assign_designations');
    }
}