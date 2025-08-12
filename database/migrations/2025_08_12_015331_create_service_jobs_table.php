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
        Schema::create('service_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pekerjaan');
            $table->string('estimasi_waktu')->nullable();
            $table->enum('tipe_harga', ['tetap', 'per_jam'])->default('tetap');
            $table->decimal('harga_jual', 12, 2);
            $table->decimal('hpp_jasa', 12, 2)->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_jobs');
    }
};
