<?php

namespace App\Http\Controllers;

use App\Models\PemesananBarang;
use App\Models\Keuangan;
use App\Models\CicilanPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function index()
    {
        // Dashboard keuangan
        $saldo = $this->hitungSaldo();
        $transaksi = Keuangan::with('user')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        $hutang = PemesananBarang::where('tipe_pembayaran', 'kredit')
            ->where('status_pembayaran', 'belum_lunas')
            ->with('supplier')
            ->get();

        return view('keuangan.index', compact('saldo', 'transaksi', 'piutang'));
    }

    public function createPemasukan()
    {
        return view('keuangan.pemasukan_create');
    }

    public function storePemasukan(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date'
        ]);

        DB::transaction(function () use ($validated) {
            Keuangan::create([
                'kode_transaksi' => Keuangan::generateKodeTransaksi('pemasukan'),
                'tipe' => 'pemasukan',
                'kategori' => $validated['kategori'],
                'jumlah' => $validated['jumlah'],
                'keterangan' => $validated['keterangan'],
                'tanggal' => $validated['tanggal'],
                'user_id' => Auth::id(),
            ]);
        });

        return redirect()->route('keuangan.index')->with('success', 'Pemasukan berhasil dicatat');
    }

    public function createPengeluaran()
    {
        return view('keuangan.pengeluaran_create');
    }

    public function storePengeluaran(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date'
        ]);

        DB::transaction(function () use ($validated) {
            Keuangan::create([
                'kode_transaksi' => Keuangan::generateKodeTransaksi('pengeluaran'),
                'tipe' => 'pengeluaran',
                'kategori' => $validated['kategori'],
                'jumlah' => $validated['jumlah'],
                'keterangan' => $validated['keterangan'],
                'tanggal' => $validated['tanggal'],
                'user_id' => Auth::id(),
            ]);
        });

        return redirect()->route('keuangan.index')->with('success', 'Pengeluaran berhasil dicatat');
    }

    public function bayarCicilan($pemesanan_id)
    {
        $pemesanan = PemesananBarang::with('supplier')
            ->withSum('cicilan', 'jumlah')
            ->findOrFail($pemesanan_id);

        $sisa = $pemesanan->total_akhir - ($pemesanan->cicilan_sum_jumlah ?? 0);

        return view('keuangan.cicilan_create', compact('pemesanan', 'sisa'));
    }

    public function storeCicilan(Request $request, $pemesanan_id)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'metode_bayar' => 'required|string',
            'catatan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($validated, $pemesanan_id) {
            // Catat cicilan
            $cicilan = CicilanPembayaran::create([
                'pemesanan_id' => $pemesanan_id,
                'jumlah' => $validated['jumlah'],
                'tanggal_bayar' => $validated['tanggal_bayar'],
                'metode_bayar' => $validated['metode_bayar'],
                'catatan' => $validated['catatan'],
                'user_id' => Auth::id(),
            ]);

            // Catat sebagai transaksi pembayaran
            $pemesanan = PemesananBarang::find($pemesanan_id);

            if ($pemesanan->cicilan->sum('jumlah') >= $pemesanan->total_akhir) {
                $pemesanan->update(['status_pembayaran' => 'lunas']);
            }

            Keuangan::create([
                'kode_transaksi' => Keuangan::generateKodeTransaksi('pembayaran'),
                'tipe' => 'pembayaran',
                'jumlah' => $validated['jumlah'],
                'keterangan' => 'Pembayaran cicilan untuk pemesanan ' . $pemesanan->nomor_surat_jalan,
                'referensi' => $pemesanan->nomor_surat_jalan,
                'tanggal' => $validated['tanggal_bayar'],
                'user_id' => Auth::id(),
            ]);
        });

        return redirect()->route('keuangan.index')->with('success', 'Pembayaran cicilan berhasil dicatat');
    }

    public function laporan()
    {
        $pendapatan_servis = Keuangan::where('kategori', 'servis')->sum('jumlah');
        $startDate = request('start_date') ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = request('end_date') ?? now()->endOfMonth()->format('Y-m-d');

        $transaksi = Keuangan::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal')
            ->get();

        $pemasukan = $transaksi->where('tipe', 'pemasukan')->sum('jumlah');
        $pengeluaran = $transaksi->where('tipe', 'pengeluaran')->sum('jumlah');
        $pembayaran = $transaksi->where('tipe', 'pembayaran')->sum('jumlah');

        return view('keuangan.laporan', compact(
            'transaksi', 'pemasukan', 'pengeluaran', 'pembayaran', 'startDate', 'endDate'
        ));
    }

    private function hitungSaldo()
    {
        $pemasukan = Keuangan::where('tipe', 'pemasukan')->sum('jumlah');
        $pengeluaran = Keuangan::where('tipe', 'pengeluaran')->sum('jumlah');
        $pembayaran = Keuangan::where('tipe', 'pembayaran')->sum('jumlah');

        return [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'pembayaran' => $pembayaran,
            'saldo' => $pemasukan + $pembayaran - $pengeluaran
        ];
    }
}
