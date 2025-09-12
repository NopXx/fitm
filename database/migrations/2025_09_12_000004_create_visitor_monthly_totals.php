<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visitor_monthly_totals', function (Blueprint $table) {
            $table->id();
            // Represent the month by the first day of month for easy date arithmetic
            $table->date('month')->unique();
            $table->unsignedInteger('unique_visitors')->default(0);
            $table->unsignedInteger('pageviews')->default(0);
            $table->timestamps();

            $table->index('month');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_monthly_totals');
    }
};

