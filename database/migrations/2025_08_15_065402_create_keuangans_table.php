<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Transaksi keuangan
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->enum('tipe', ['pemasukan', 'pengeluaran', 'pembayaran']);
            $table->string('kategori')->nullable(); // listrik, gaji, dll
            $table->decimal('jumlah', 12, 2);
            $table->text('keterangan')->nullable();
            $table->string('referensi')->nullable(); // no invoice pemesanan jika terkait
            $table->date('tanggal');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};
