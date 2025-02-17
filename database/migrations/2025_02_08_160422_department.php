<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Departments Table
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('department_name_th');
            $table->string('department_code');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        // Drop tables in reverse order to avoid foreign key constraints
        Schema::dropIfExists('departments');
    }
};
