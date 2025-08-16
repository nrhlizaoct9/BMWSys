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
        // Cicilan pembayaran kredit
        Schema::create('cicilan_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanan_barangs')->onDelete('cascade');
            $table->decimal('jumlah', 12, 2);
            $table->date('tanggal_bayar');
            $table->string('metode_bayar')->default('tunai');
            $table->string('bukti_bayar')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cicilan_pembayarans');
    }
};
