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
        Schema::create('model_baju_ukuran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_baju_id');
            $table->unsignedBigInteger('ukuran_id');
            $table->integer('stok')->default(0); // Stok per ukuran
            $table->foreign('model_baju_id')->references('id')->on('model_bajus')->onDelete('cascade');
            $table->foreign('ukuran_id')->references('id')->on('ukurans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_baju_ukuran');
    }
};
