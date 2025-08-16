<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_datang');
            $table->string('nomor_surat_jalan')->unique();
            $table->enum('tipe_pembayaran', ['tunai', 'kredit'])->default('tunai');
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->string('status_pembayaran')->default('belum_lunas');
            $table->string('kode_transaksi_keuangan')->nullable()->unique();

            // Field diskon & PPN global
            $table->decimal('diskon_global_nilai', 12, 2)->default(0);
            $table->enum('diskon_global_tipe', ['persen', 'nominal'])->default('persen');
            $table->decimal('ppn_global_nilai', 12, 2)->default(0);
            $table->enum('ppn_global_tipe', ['persen', 'nominal'])->default('persen');

            // Field total
            $table->decimal('subtotal', 12, 2)->default(0); // total per item
            $table->decimal('total_diskon', 12, 2)->default(0);
            $table->decimal('total_ppn', 12, 2)->default(0);
            $table->decimal('total_akhir', 12, 2)->default(0);

            $table->timestamps();
            $table->softDeletes(); // untuk arsip data
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan_barangs');
    }
};
