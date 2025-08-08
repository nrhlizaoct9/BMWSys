<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('jenisBarang')->latest()->get();
        return view('barangs.index', compact('barangs'));
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
            'satuan' => 'required|string|max:20',
            'harga' => 'nullable|numeric|min:0'
        ]);

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
            'nama_barang' => 'required|string|max:255',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'harga' => 'nullable|numeric|min:0'
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
