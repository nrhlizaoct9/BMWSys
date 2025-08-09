<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        return view('barangs.index', [
            'barangs' => Barang::with('jenisBarang')->latest()->get()
        ]);
    }

    public function create()
    {
        $jenisBarangs = JenisBarang::all();
        return view('barangs.create', compact('jenisBarangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'stok' => 'required|integer|min:0',
            'stok_min' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gt:harga_beli'
        ]);

        // Generate kode barang otomatis
        $jenisBarang = JenisBarang::find($validated['jenis_barang_id']);
        $prefix = strtoupper(substr($jenisBarang->nama_jenis, 0, 3)); // Ambil 3 huruf depan

        $lastBarang = Barang::where('kode_barang', 'like', $prefix.'-%')
            ->orderBy('kode_barang', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastBarang) {
            $lastNumber = (int) substr($lastBarang->kode_barang, -3);
            $nextNumber = $lastNumber + 1;
        }

        $validated['kode_barang'] = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Barang::create($validated);

        return redirect()->route('barangs.index')
            ->with('success', 'Data barang berhasil ditambahkan');
    }

    public function edit(Barang $barang)
    {
        $jenisBarangs = JenisBarang::all();
        return view('barangs.edit', compact('barang', 'jenisBarangs'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,'.$barang->id.'|string|max:50',
            'nama_barang' => 'required|string|max:255',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'stok' => 'required|integer|min:0',
            'stok_min' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gt:harga_beli'
        ]);

        $barang->update($validated);

        return redirect()->route('barangs.index')
            ->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barangs.index')
            ->with('success', 'Data barang berhasil dihapus');
    }
}
