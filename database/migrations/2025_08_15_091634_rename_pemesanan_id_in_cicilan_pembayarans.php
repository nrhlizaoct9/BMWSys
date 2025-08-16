<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cicilan_pembayarans', function (Blueprint $table) {
            // Jika kolom pemesanan_id sudah ada
            if (Schema::hasColumn('cicilan_pembayarans', 'pemesanan_id')) {
                $table->renameColumn('pemesanan_id', 'pemesanan_barang_id');
            }
            // Jika kolom belum ada
            else {
                $table->foreignId('pemesanan_barang_id')
                      ->constrained('pemesanan_barangs')
                      ->onDelete('cascade')
                      ->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cicilan_pembayarans', function (Blueprint $table) {
            // Untuk rollback rename
            if (Schema::hasColumn('cicilan_pembayarans', 'pemesanan_barang_id')) {
                $table->renameColumn('pemesanan_barang_id', 'pemesanan_id');
            }
            // Untuk rollback penambahan kolom
            else {
                $table->dropForeign(['pemesanan_barang_id']);
                $table->dropColumn('pemesanan_barang_id');
            }
        });
    }
};
