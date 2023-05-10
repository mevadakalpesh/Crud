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
        Schema::create('csv_data', function (Blueprint $table) {
            $table->id();
            $table->string('role_no')->nullable();
            $table->string('fisrt_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('house_no')->nullable();
            $table->string('price')->nullable();
            $table->string('part')->nullable();
            $table->string('part_2')->nullable();
            $table->string('phone')->nullable();
            $table->string('hobie')->nullable();
            $table->string('mark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csv_data');
    }
};
