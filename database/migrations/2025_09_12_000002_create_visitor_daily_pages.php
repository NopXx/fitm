<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visitor_daily_pages', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('page'); // store empty string for homepage/null
            $table->unsignedInteger('visits')->default(0);
            $table->timestamps();

            $table->unique(['date', 'page']);
            $table->index('date');
            $table->index('page');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_daily_pages');
    }
};

