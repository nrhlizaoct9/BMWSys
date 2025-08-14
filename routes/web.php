<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    ReportController,
    UserController,
    SupplierController,
    JenisBarangController,
    BarangController,
    PemesananController,
    ServiceJobController,
    ServiceController
};

// Auth Routes
// require __DIR__.'/auth.php';

// // Authenticated Routes
// Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Master Data
    Route::resource('users', UserController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('jenis-barang', JenisBarangController::class);
    Route::resource('barangs', BarangController::class);

    // Transaction
    Route::resource('pemesanans', PemesananController::class);
    Route::resource('service_jobs', ServiceJobController::class);
    Route::get('/services/{service}/pdf', [ServiceController::class, 'exportPdf'])->name('services.exportPdf');
    Route::resource('services', ServiceController::class);

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
// });
