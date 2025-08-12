<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pemesanan_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_barang_id')->constrained()->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('harga_beli', 12, 2);

            // Field diskon per item
            $table->decimal('diskon_nilai', 12, 2)->default(0);
            $table->enum('diskon_tipe', ['persen', 'nominal'])->default('persen');

            // Field PPN per item
            $table->decimal('ppn_nilai', 12, 2)->default(0);
            $table->enum('ppn_tipe', ['persen', 'nominal'])->default('persen');

            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            // Index tambahan untuk performa query
            $table->index('pemesanan_barang_id');
            $table->index('barang_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanan_barangs');
    }
};
