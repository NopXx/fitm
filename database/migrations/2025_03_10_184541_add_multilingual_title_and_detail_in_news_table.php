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
            // Rename existing fields to Thai versions
            $table->renameColumn('title', 'title_th');
            $table->renameColumn('detail', 'detail_th');

            // Add English versions (nullable)
            $table->string('title_en')->nullable()->after('title_th');
            $table->text('detail_en')->nullable()->after('detail_th');

            // Update content fields to be nullable
            $table->longText('content_th')->nullable()->change();
            $table->longText('content_en')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Drop English columns
            $table->dropColumn(['title_en', 'detail_en']);

            // Rename Thai columns back to original names
            $table->renameColumn('title_th', 'title');
            $table->renameColumn('detail_th', 'detail');
        });
    }
};
