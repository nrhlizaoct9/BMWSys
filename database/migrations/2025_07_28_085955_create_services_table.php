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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_pelanggan')->nullable();
            $table->string('plat_nomor')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('nomor_invoice')->unique();
            $table->decimal('total', 12, 2)->default(0);
            // Untuk ke menu keuangan
            $table->enum('tipe_pembayaran', ['tunai', 'kredit'])->default('tunai');
            $table->enum('status_pembayaran', ['lunas', 'belum_lunas'])->default('lunas');
            // $table->date('tanggal_jatuh_tempo')->nullable(); // Jika kredit
            $table->decimal('terbayar', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
