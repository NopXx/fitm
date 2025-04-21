<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->string('department_name_en')->nullable()->after('department_name_th');
            $table->longText('overview_th')->nullable()->after('department_code');
            $table->longText('overview_en')->nullable()->after('overview_th');
            $table->enum('status', ['draft', 'published'])->default('draft')->after('overview_en');
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn([
                'department_name_en',
                'overview_th',
                'overview_en',
                'status'
            ]);
        });
    }
};