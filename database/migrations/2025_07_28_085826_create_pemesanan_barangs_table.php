<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::create('transactions', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
        //     $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
        //     $table->foreignId('user_id')->constrained('users'); // petugas kasir/admin
        //     $table->string('invoice_number')->unique();
        //     $table->dateTime('transaction_date');
        //     $table->decimal('total_amount', 12, 2);
        //     $table->decimal('paid_amount', 12, 2);
        //     $table->string('payment_method'); // contoh: cash, transfer
        //     $table->enum('status', ['paid', 'unpaid', 'partial']);
        //     $table->timestamps();
        // });

        Schema::create('pemesanan_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained();
            $table->date('tanggal_datang'); // ganti dari 'tanggal'
            $table->string('nomor_surat_jalan')->unique(); // ganti dari 'nomor_invoice'
            $table->string('status')->default('arrived'); // hanya status arrived
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan_barangs');
    }
};
