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
        Schema::table('historical_events', function (Blueprint $table) {
            // Rename existing columns
            $table->renameColumn('title', 'title_th');        // Rename title to title_th
            $table->renameColumn('description', 'description_th'); // Rename description to description_th

            // Add new English columns
            $table->string('title_en')->nullable();                 // หัวข้อเหตุการณ์
            $table->text('description_en')->nullable();             // รายละเอียดเหตุการณ์
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historical_events', function (Blueprint $table) {
            // Remove English columns
            $table->dropColumn('title_en');
            $table->dropColumn('description_en');

            // Rename columns back to original
            $table->renameColumn('title_th', 'title');
            $table->renameColumn('description_th', 'description');
        });
    }
};