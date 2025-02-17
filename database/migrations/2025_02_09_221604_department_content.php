<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('department_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->longText('overview');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE department_contents AUTO_INCREMENT = 1;');
    }

    public function down() : void
    {
        Schema::dropIfExists('department_contents');
    }
};
