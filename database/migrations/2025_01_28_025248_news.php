<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id'); // Unsigned integer, auto-increment, primary key
            $table->integer('no')->nullable(false);
            $table->integer('display_type')->nullable()->comment('display type');
            $table->integer('new_type')->nullable();
            $table->text('title')->nullable()->comment('ชื่อ');
            $table->text('detail')->nullable()->comment('รายละเอียด');
            $table->text('content')->nullable();
            $table->text('cover')->nullable()->comment('image news');
            $table->dateTime('effective_date')->nullable()->comment('แสดงวันที่');
            $table->integer('view_count')->nullable();
            $table->text('link')->nullable();
            $table->integer('status')->nullable()->comment('status');
            $table->dateTime('created_at')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->bigInteger('deleted_by')->nullable();

            // Foreign keys
            // $table->foreign('display_type')->references('id')->on('display_type');
            // $table->foreign('new_type')->references('id')->on('new_type');
        });

        // Set the auto-increment start value to 11
        DB::statement('ALTER TABLE news AUTO_INCREMENT = 11;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
