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
        Schema::create('historical_events', function (Blueprint $table) {
            $table->id();
            $table->integer('year');                    // ปีที่เกิดเหตุการณ์
            $table->string('title');                 // หัวข้อเหตุการณ์
            $table->text('description');             // รายละเอียดเหตุการณ์
            $table->string('image_path')->nullable(); // path รูปภาพ (ถ้ามี)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_events');
    }
};
