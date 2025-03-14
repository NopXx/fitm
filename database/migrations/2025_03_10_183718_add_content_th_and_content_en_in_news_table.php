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
        Schema::table('news', function (Blueprint $table) {
            // Rename existing content column to content_th
            $table->renameColumn('content', 'content_th');

            // Add new content_en column
            $table->longText('content_en')->nullable()->after('content_th');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Drop content_en column
            $table->dropColumn('content_en');

            // Rename content_th back to content
            $table->renameColumn('content_th', 'content');
        });
    }
};
