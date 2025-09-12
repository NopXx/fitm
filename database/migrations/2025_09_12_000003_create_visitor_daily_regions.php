<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visitor_daily_regions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('region'); // store 'Unknown' for null
            $table->unsignedInteger('count')->default(0);
            $table->timestamps();

            $table->unique(['date', 'region']);
            $table->index('date');
            $table->index('region');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_daily_regions');
    }
};

