<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personnel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id');
            $table->string('firstname_th');
            $table->string('lastname_th');
            $table->string('firstname_en')->nullable();
            $table->string('lastname_en')->nullable();
            $table->string('position_th');
            $table->string('position_en')->nullable();
            $table->string('image')->nullable();
            $table->integer('display_order')->default(0);
            $table->string('order_title_th')->nullable();
            $table->string('order_title_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel');
    }
};
