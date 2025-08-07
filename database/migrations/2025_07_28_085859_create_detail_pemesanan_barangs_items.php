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
        // Schema::create('transaction_items', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
        //     $table->morphs('itemable'); // itemable_type, itemable_id
        //     $table->integer('quantity');
        //     $table->decimal('price', 10, 2);
        //     $table->decimal('total', 12, 2);
        //     $table->timestamps();
        // });

        Schema::create('detail_pemesanan_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_barang_id')->constrained();
            $table->foreignId('barang_id')->constrained();
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanan_barangs');
    }
};
