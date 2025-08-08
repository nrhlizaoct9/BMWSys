<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        // Grafik per bulan tahun ini
        // $monthlyTransactions = Service::selectRaw('MONTH(transaction_date) as month, COUNT(*) as total')
        //     ->whereYear('transaction_date', now()->year)
        //     ->groupBy('month')
        //     ->orderBy('month')
        //     ->get();

        // Grafik per tahun
        // $yearlyTransactions = Service::selectRaw('YEAR(transaction_date) as year, COUNT(*) as total')
        //     ->groupBy('year')
        //     ->orderBy('year')
        //     ->get();

        // return view('dashboard.index', [
        //     'monthlyTransactions' => $monthlyTransactions,
        //     'yearlyTransactions' => $yearlyTransactions,
        // ]);

        // Grafik Distribusi Jenis Layanan
        // $transaksis = Transaksi::selectRaw('jenis_layanan, COUNT(*) as total')
        //     ->groupBy('jenis_layanan')
        //     ->get();

        // $labels = $transaksis->pluck('jenis_layanan');
        // $data = $transaksis->pluck('total');

        // return view('dashboard.index', compact('labels', 'data'));
        
        return view('dashboard');
    }
}
