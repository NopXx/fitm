<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menu_categories', function (Blueprint $table) {
            $table->id();
            $table->string('system_name')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')
                  ->references('id')
                  ->on('menu_categories')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_categories');
    }
};
