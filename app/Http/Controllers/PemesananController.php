<?php

namespace App\Http\Controllers;

use App\Models\PemesananBarang;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    /**
     * Menampilkan history barang masuk
     */
    public function index()
    {
        $pemesanans = PemesananBarang::with(['supplier', 'details.barang'])
            ->orderBy('tanggal_datang', 'desc')
            ->paginate(10);

        return view('pemesanans.index', compact('pemesanans'));
    }

    /**
     * Form input barang datang
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        return view('pemesanans.create', compact('suppliers', 'barangs'));
    }

    /**
     * Proses penyimpanan data barang datang
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'nomor_surat_jalan' => 'required|unique:pemesanan_barangs',
            'tanggal_datang' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0' // ganti dari harga_satuan
        ]);

        DB::transaction(function () use ($validated) {
            // Catat kedatangan barang
            $pemesanan = PemesananBarang::create([
                'supplier_id' => $validated['supplier_id'],
                'nomor_surat_jalan' => $validated['nomor_surat_jalan'],
                'tanggal_datang' => $validated['tanggal_datang'],
                'status' => 'arrived'
            ]);

            // Simpan detail barang yang datang
            foreach ($validated['items'] as $item) {
                $pemesanan->details()->create([
                    'barang_id' => $item['barang_id'],
                    'quantity' => $item['quantity'],
                    'harga_beli' => $item['harga_beli']
                ]);

                // Update stok barang
                $barang = Barang::find($item['barang_id']);
                $barang->stok += $item['quantity'];
                $barang->harga_beli = $item['harga_beli']; // Update harga beli terbaru
                $barang->save();
            }
        });

        return redirect()->route('pemesanans.index')
            ->with('success', 'Data barang masuk berhasil dicatat');
    }

    public function show(PemesananBarang $pemesanan)
    {
        return view('pemesanans.show', compact('pemesanan'));
    }
}
