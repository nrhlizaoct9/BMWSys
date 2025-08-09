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

        // Schema::create('detail_pemesanan_barangs', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('pemesanan_barang_id')->constrained();
        //     $table->foreignId('barang_id')->constrained();
        //     $table->integer('jumlah');
        //     $table->decimal('harga_satuan', 12, 2);
        //     $table->timestamps();
        // });

        Schema::create('detail_pemesanan_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_barang_id')->constrained()->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('harga_beli', 12, 2); // ganti dari harga_satuan
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('detail_pemesanan_barangs', function (Blueprint $table) {
            $table->dropColumn('subtotal');
        });
    }
};
