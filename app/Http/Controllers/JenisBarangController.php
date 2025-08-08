<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    public function index()
    {
        $jenisBarangs = JenisBarang::latest()->get();
        return view('jenis-barang.index', compact('jenisBarangs'));
    }

    public function create()
    {
        return view('jenis-barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_barangs',
        ]);

        JenisBarang::create($request->all());

        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis barang berhasil ditambahkan');
    }

    public function edit(JenisBarang $jenisBarang)
    {
        return view('jenis-barang.edit', compact('jenisBarang'));
    }

    public function update(Request $request, JenisBarang $jenisBarang)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_barangs,nama_jenis,'.$jenisBarang->id,
        ]);

        $jenisBarang->update($request->all());

        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis barang berhasil diperbarui');
    }

    public function destroy(JenisBarang $jenisBarang)
    {
        $jenisBarang->delete();

        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis barang berhasil dihapus');
    }
}
