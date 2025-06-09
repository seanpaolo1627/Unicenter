<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeastTable extends Migration
{
    public function up()
    {
        Schema::create('employeasts', function (Blueprint $table) {
            $table->id();
            $table->string('emp_num');
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('address_line');
            $table->string('brgy');
            $table->string('city');
            $table->string('province');
            $table->string('zipcode');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employeasts');
    }
}