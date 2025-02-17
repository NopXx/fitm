<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('symbols', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // university_emblem, university_color, university_tree, faculty_logo
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->text('description_th');
            $table->text('description_en')->nullable();
            $table->string('image_path');
            $table->string('download_link')->nullable();
            // สำหรับเก็บค่าสีกรณีเป็น university_color
            $table->string('rgb_code')->nullable();
            $table->string('cmyk_code')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('symbols');
    }
};
