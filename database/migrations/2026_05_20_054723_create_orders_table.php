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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah');
            $table->integer('total_harga');
            $table->string('catatan')->nullable();
            $table->enum('status', ['menunggu konfirmasi', 'diproses', 'selesai', 'ditolak']);
            $table->string('alasan_tolak')->nullable();
            $table->enum('metode_bayar', ['cash', 'hutang'])->default('cash');
            $table->enum('tipe_penyerahan', ['ambil', 'antar'])->default('ambil');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
