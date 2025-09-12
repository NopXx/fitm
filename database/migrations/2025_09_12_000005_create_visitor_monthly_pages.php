<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visitor_monthly_pages', function (Blueprint $table) {
            $table->id();
            $table->date('month');
            $table->string('page');
            $table->unsignedInteger('visits')->default(0);
            $table->timestamps();

            $table->unique(['month', 'page']);
            $table->index('month');
            $table->index('page');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_monthly_pages');
    }
};

