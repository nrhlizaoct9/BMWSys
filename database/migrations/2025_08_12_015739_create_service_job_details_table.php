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
        Schema::create('service_job_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('services_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_job_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah_jam')->nullable(); // diisi kalau tipe per_hour
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_job_details');
    }
};
