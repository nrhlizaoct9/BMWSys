<?php

namespace App\Http\Controllers;

use App\Models\PemesananBarang;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;

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
            'items.*.harga_beli' => 'required|numeric|min:0',
            'items.*.diskon_nilai' => 'nullable|numeric|min:0',
            'items.*.diskon_tipe' => 'nullable|in:persen,nominal',
            'items.*.ppn_nilai' => 'nullable|numeric|min:0',
            'items.*.ppn_tipe' => 'nullable|in:persen,nominal',
            'diskon_global_nilai' => 'nullable|numeric|min:0',
            'diskon_global_tipe' => 'nullable|in:persen,nominal',
            'ppn_global_nilai' => 'nullable|numeric|min:0',
            'ppn_global_tipe' => 'nullable|in:persen,nominal'
        ]);

        DB::transaction(function () use ($validated) {
            // Buat data pemesanan
            $pemesanan = PemesananBarang::create([
                'supplier_id' => $validated['supplier_id'],
                'nomor_surat_jalan' => $validated['nomor_surat_jalan'],
                'tanggal_datang' => $validated['tanggal_datang'],
                'status' => 'arrived',
                'diskon_global_nilai' => $validated['diskon_global_nilai'] ?? 0,
                'diskon_global_tipe' => $validated['diskon_global_tipe'] ?? 'persen',
                'ppn_global_nilai' => $validated['ppn_global_nilai'] ?? 0,
                'ppn_global_tipe' => $validated['ppn_global_tipe'] ?? 'persen'

            ]);

            // Hitung total sebelum diskon/ppn global
            $subtotal = 0;

            foreach ($validated['items'] as $item) {
                // Hitung subtotal per item
                $itemSubtotal = $item['quantity'] * $item['harga_beli'];

                // Hitung diskon item
                $diskon = 0;
                if (!empty($item['diskon_nilai'])) {
                    $diskon = ($item['diskon_tipe'] === 'persen')
                        ? $itemSubtotal * ($item['diskon_nilai'] / 100)
                        : $item['diskon_nilai'];
                }

                // Hitung ppn item
                $ppn = 0;
                if (!empty($item['ppn_nilai'])) {
                    $itemSubtotalAfterDiskon = $itemSubtotal - $diskon;
                    $ppn = ($item['ppn_tipe'] === 'persen')
                        ? $itemSubtotalAfterDiskon * ($item['ppn_nilai'] / 100)
                        : $item['ppn_nilai'];
                }

                $totalItem = $itemSubtotal - $diskon + $ppn;
                $subtotal += $itemSubtotal; // Akumulasi subtotal (sebelum diskon/ppn item)

                $pemesanan->details()->create([
                    'barang_id' => $item['barang_id'],
                    'quantity' => $item['quantity'],
                    'harga_beli' => $item['harga_beli'],
                    'diskon_nilai' => $item['diskon_nilai'] ?? 0,
                    'diskon_tipe' => $item['diskon_tipe'] ?? 'persen',
                    'ppn_nilai' => $item['ppn_nilai'] ?? 0,
                    'ppn_tipe' => $item['ppn_tipe'] ?? 'persen',
                    'subtotal' => $totalItem
                ]);

                // Update stok barang
                $barang = Barang::find($item['barang_id']);
                $barang->stok += $item['quantity'];
                $barang->harga_beli = $item['harga_beli'];
                $barang->save();
            }

            // Hitung diskon global
            $diskonGlobal = 0;
            if (!empty($validated['diskon_global_nilai'])) {
                $diskonGlobal = ($validated['diskon_global_tipe'] === 'persen')
                    ? $subtotal * ($validated['diskon_global_nilai'] / 100)
                    : $validated['diskon_global_nilai'];
            }

            // Hitung ppn global
            $ppnGlobal = 0;
            if (!empty($validated['ppn_global_nilai'])) {
                $totalAfterDiskonGlobal = $subtotal - $diskonGlobal;
                $ppnGlobal = ($validated['ppn_global_tipe'] === 'persen')
                    ? $totalAfterDiskonGlobal * ($validated['ppn_global_nilai'] / 100)
                    : $validated['ppn_global_nilai'];
            }

            // Update total akhir di pemesanan
            $pemesanan->update([
                'subtotal' => $subtotal,
                'total_diskon' => $diskonGlobal,
                'total_ppn' => $ppnGlobal,
                'total_akhir' => $subtotal - $diskonGlobal + $ppnGlobal
            ]);
        });

        return redirect()->route('pemesanans.index')
            ->with('success', 'Data barang masuk berhasil dicatat');
    }

    public function edit($id)
    {
        $pemesanan = PemesananBarang::with(['supplier', 'details.barang'])->findOrFail($id);
        $suppliers = Supplier::all();
        $barangs = Barang::all();

        return view('pemesanans.edit', [
            'pemesanan' => $pemesanan,
            'suppliers' => $suppliers,
            'barangs' => $barangs,
            'details' => $pemesanan->details // Kirim sebagai details
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'nomor_surat_jalan' => 'required|unique:pemesanan_barangs,nomor_surat_jalan,'.$id,
            'tanggal_datang' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0',
            'items.*.diskon_nilai' => 'nullable|numeric|min:0',
            'items.*.diskon_tipe' => 'nullable|in:persen,nominal',
            'items.*.ppn_nilai' => 'nullable|numeric|min:0',
            'items.*.ppn_tipe' => 'nullable|in:persen,nominal',
            'diskon_global_nilai' => 'nullable|numeric|min:0',
            'diskon_global_tipe' => 'nullable|in:persen,nominal',
            'ppn_global_nilai' => 'nullable|numeric|min:0',
            'ppn_global_tipe' => 'nullable|in:persen,nominal'
        ]);

         DB::transaction(function () use ($validated, $id) {
            $pemesanan = PemesananBarang::with('details')->findOrFail($id);

            // 1. Kembalikan stok lama
            foreach ($pemesanan->details as $detail) {
                $barang = Barang::find($detail->barang_id);
                $barang->stok -= $detail->quantity;
                $barang->save();
            }

            // 2. Hapus detail lama
            $pemesanan->details()->delete();

            // 3. Update data pemesanan utama
            $pemesanan->update([
                'supplier_id' => $validated['supplier_id'],
                'nomor_surat_jalan' => $validated['nomor_surat_jalan'],
                'tanggal_datang' => $validated['tanggal_datang'],
                'diskon_global_nilai' => $validated['diskon_global_nilai'] ?? 0,
                'diskon_global_tipe' => $validated['diskon_global_tipe'] ?? 'persen',
                'ppn_global_nilai' => $validated['ppn_global_nilai'] ?? 0,
                'ppn_global_tipe' => $validated['ppn_global_tipe'] ?? 'persen'
            ]);

            // 4. Hitung total sebelum diskon/ppn global
            $subtotal = 0;

            // 5. Buat detail baru dan update stok
            foreach ($validated['items'] as $item) {
                // Hitung subtotal per item
                $itemSubtotal = $item['quantity'] * $item['harga_beli'];

                // Hitung diskon item
                $diskon = 0;
                if (!empty($item['diskon_nilai'])) {
                    $diskon = ($item['diskon_tipe'] === 'persen')
                        ? $itemSubtotal * ($item['diskon_nilai'] / 100)
                        : $item['diskon_nilai'];
                }

                // Hitung ppn item
                $ppn = 0;
                if (!empty($item['ppn_nilai'])) {
                    $itemSubtotalAfterDiskon = $itemSubtotal - $diskon;
                    $ppn = ($item['ppn_tipe'] === 'persen')
                        ? $itemSubtotalAfterDiskon * ($item['ppn_nilai'] / 100)
                        : $item['ppn_nilai'];
                }

                $totalItem = $itemSubtotal - $diskon + $ppn;
                $subtotal += $itemSubtotal;

                // Buat detail baru
                $pemesanan->details()->create([
                    'barang_id' => $item['barang_id'],
                    'quantity' => $item['quantity'],
                    'harga_beli' => $item['harga_beli'],
                    'diskon_nilai' => $item['diskon_nilai'] ?? 0,
                    'diskon_tipe' => $item['diskon_tipe'] ?? 'persen',
                    'ppn_nilai' => $item['ppn_nilai'] ?? 0,
                    'ppn_tipe' => $item['ppn_tipe'] ?? 'persen',
                    'subtotal' => $totalItem
                ]);

                // Update stok barang
                $barang = Barang::find($item['barang_id']);
                $barang->stok += $item['quantity'];
                $barang->harga_beli = $item['harga_beli'];
                $barang->save();
            }

            // 6. Hitung diskon global
            $diskonGlobal = 0;
            if (!empty($validated['diskon_global_nilai'])) {
                $diskonGlobal = ($validated['diskon_global_tipe'] === 'persen')
                    ? $subtotal * ($validated['diskon_global_nilai'] / 100)
                    : $validated['diskon_global_nilai'];
            }

            // 7. Hitung ppn global
            $ppnGlobal = 0;
            if (!empty($validated['ppn_global_nilai'])) {
                $totalAfterDiskonGlobal = $subtotal - $diskonGlobal;
                $ppnGlobal = ($validated['ppn_global_tipe'] === 'persen')
                    ? $totalAfterDiskonGlobal * ($validated['ppn_global_nilai'] / 100)
                    : $validated['ppn_global_nilai'];
            }

            // 8. Update total akhir di pemesanan
            $pemesanan->update([
                'subtotal' => $subtotal,
                'total_diskon' => $diskonGlobal,
                'total_ppn' => $ppnGlobal,
                'total_akhir' => $subtotal - $diskonGlobal + $ppnGlobal
            ]);
        });

        return redirect()->route('pemesanans.index')
            ->with('success', 'Data pemesanan berhasil diperbarui');
    }

    public function show($id)
    {
        $pemesanan = PemesananBarang::with(['supplier', 'details.barang'])->findOrFail($id);
        return view('pemesanans.show', compact('pemesanan'));
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $pemesanan = PemesananBarang::with('details')->findOrFail($id);

            // Kembalikan stok barang
            foreach ($pemesanan->details as $detail) {
                $barang = Barang::find($detail->barang_id);
                $barang->stok -= $detail->quantity; // Kurangi stok
                $barang->save();
            }

            // Hapus detail pemesanan
            $pemesanan->details()->delete();

            // Hapus pemesanan
            $pemesanan->delete();
        });

        return redirect()->route('pemesanans.index')
            ->with('success', 'Pemesanan berhasil dihapus dan stok dikembalikan');
    }
}
