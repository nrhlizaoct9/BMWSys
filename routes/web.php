<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    DashboardController,
    ReportController,
    UserController,
    SupplierController,
    JenisBarangController,
    BarangController,
    PemesananController,
    ServiceJobController,
    ServiceController,
    KeuanganController
};

// Auth Routes
// require __DIR__.'/auth.php';

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware(['auth'])->group(function () {

    // Auth Routes
    // Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    // Route::post('/', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    Route::post('/services/{service}/bayar', [ServiceController::class, 'bayar'])->name('services.bayar');
    Route::get('/services/{service}/pdf', [ServiceController::class, 'exportPdf'])->name('services.exportPdf');
    Route::resource('services', ServiceController::class);

    // Keuangan Routes
    Route::prefix('keuangan')->group(function () {
        Route::get('/', [KeuanganController::class, 'index'])->name('keuangan.index');

        // Pemasukan
        Route::get('/pemasukan/create', [KeuanganController::class, 'createPemasukan'])->name('keuangan.pemasukan.create');
        Route::post('/pemasukan', [KeuanganController::class, 'storePemasukan'])->name('keuangan.pemasukan.store');

        // Pengeluaran
        Route::get('/pengeluaran/create', [KeuanganController::class, 'createPengeluaran'])->name('keuangan.pengeluaran.create');
        Route::post('/pengeluaran', [KeuanganController::class, 'storePengeluaran'])->name('keuangan.pengeluaran.store');

        // Cicilan
        Route::get('/cicilan/{pemesanan}/bayar', [KeuanganController::class, 'bayarCicilan'])->name('keuangan.bayar-cicilan');
        Route::post('/cicilan/{pemesanan}', [KeuanganController::class, 'storeCicilan'])->name('keuangan.cicilan.store');

        // Laporan
        Route::get('/laporan', [KeuanganController::class, 'laporan'])->name('keuangan.laporan');

        // Export
        Route::get('/export', [KeuanganController::class, 'export'])->name('keuangan.export');
    });

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});

Route::redirect('/', '/login');

