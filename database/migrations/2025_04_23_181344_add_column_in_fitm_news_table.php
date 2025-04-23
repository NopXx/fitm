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
        Schema::table('fitm_news', function (Blueprint $table) {
            // Rename existing columns
            $table->renameColumn('title', 'title_th');
            $table->renameColumn('description', 'description_th');

            // Add new nullable columns
            $table->string('title_en')->nullable();
            $table->text('description_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fitm_news', function (Blueprint $table) {
            // Remove the new columns
            $table->dropColumn(['title_en', 'description_en']);

            // Rename columns back to original names
            $table->renameColumn('title_th', 'title');
            $table->renameColumn('description_th', 'description');
        });
    }
};