<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title_th');
            $table->string('title_en');
            $table->longText('detail_th');
            $table->longText('detail_en');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE contents AUTO_INCREMENT = 1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('contents');
    }
};
