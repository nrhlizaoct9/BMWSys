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
        // Schema::create('stock_logs', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('product_id')->constrained()->onDelete('cascade');
        //     $table->enum('type', ['in', 'out', 'opname', 'adjustment']);
        //     $table->integer('quantity');
        //     $table->text('note')->nullable();
        //     $table->timestamps();
        // });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_pelanggan')->nullable();
            $table->string('plat_nomor')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('nomor_invoice')->unique();
            $table->decimal('total', 12, 2);
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
