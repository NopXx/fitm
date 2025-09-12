<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visitor_monthly_regions', function (Blueprint $table) {
            $table->id();
            $table->date('month');
            $table->string('region');
            $table->unsignedInteger('count')->default(0);
            $table->timestamps();

            $table->unique(['month', 'region']);
            $table->index('month');
            $table->index('region');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_monthly_regions');
    }
};

