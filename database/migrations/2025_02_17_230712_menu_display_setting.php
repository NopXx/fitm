<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menu_display_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->boolean('is_visible')->default(true);
            $table->boolean('show_dropdown')->default(false);
            $table->string('css_class')->nullable();
            $table->string('icon_url')->nullable();
            $table->string('target', 20)->nullable();
            $table->timestamps();

            // $table->foreign('category_id')
            //     ->references('id')
            //     ->on('menu_categories')
            //     ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_display_settings');
    }
};
