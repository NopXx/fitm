<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menu_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('language_code', 5);
            $table->string('name');
            $table->string('url')->nullable();
            $table->timestamps();
            $table->foreign('category_id')
                ->references('id')
                ->on('menu_categories')
                ->onDelete('cascade');

            $table->unique(['category_id', 'language_code'], 'unique_menu_translation_per_language');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_translations');
    }
};
