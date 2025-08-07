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
    //    Schema::create('products', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->string('category');
    //         $table->decimal('buy_price', 10, 2);
    //         $table->decimal('sell_price', 10, 2);
    //         $table->integer('stock')->default(0);
    //         $table->integer('stock_min')->default(0);
    //         $table->timestamps();
    //     });

        Schema::create('jenis_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_barangs');
    }
};
