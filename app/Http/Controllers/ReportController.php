<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function index(Request $request) {
    $from = $request->from ?? now()->startOfMonth();
    $to = $request->to ?? now()->endOfMonth();
    $transactions = Transaction::whereBetween('transaction_date', [$from, $to])->get();
    return view('reports.index', compact('transactions', 'from', 'to'));
}
public function exportPdf() {
    // Optional: Export PDF pakai DomPDF atau Laravel Snappy
}

}
