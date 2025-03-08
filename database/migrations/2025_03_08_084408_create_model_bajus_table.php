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
        Schema::create('model_bajus', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama_model'); 
            $table->integer('stok')->default(0); 
            $table->decimal('harga', 10, 2); 
            $table->text('keterangan')->nullable(); 
            $table->string('gambar')->nullable();
            $table->unsignedBigInteger('ukuran_id');
            $table->foreign('ukuran_id')->references('id')->on('ukurans')->onDelete('cascade');
            $table->unsignedBigInteger('bahan_id');
            $table->foreign('bahan_id')->references('id')->on('bahan_bajus')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_bajus');
    }
};
