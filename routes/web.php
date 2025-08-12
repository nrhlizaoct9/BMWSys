<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ServiceJobController;


// Route::get('/', [DashboardController::class, 'index']);


// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('services', ServiceController::class);
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::resource('users', UserController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('jenis-barang', JenisBarangController::class);
    Route::resource('barangs', BarangController::class);
    Route::resource('pemesanans', PemesananController::class);
    Route::resource('service_jobs', ServiceJobController::class);


// });

// require __DIR__.'/auth.php';
