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
        // Combined FITM News table
        Schema::create('fitm_news', function (Blueprint $table) {
            $table->id();
            $table->string('issue_name'); // e.g., "FITM NEWS 64"
            $table->string('title'); // e.g., "ประชาสัมพันธ์ที่เกิดขึ้นภายในคณะฯ ของเดือนมกราคม 2568"
            $table->string('url')->nullable(); // e.g., "https://online.fliphtml5.com/efsms/hpub/"
            $table->date('published_date')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitm_news');
    }
};
