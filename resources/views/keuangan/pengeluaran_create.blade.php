@extends('layouts.layouts')

@section('title', 'Tambah Pengeluaran')

@section('content')
<div class="max-w-md mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            <i class="fas fa-minus-circle mr-2 text-red-600"></i> Tambah Pengeluaran
        </h2>

        <form action="{{ route('keuangan.pengeluaran.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" id="kategori" required
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Pilih Kategori</option>
                    <option value="gaji">Gaji Karyawan</option>
                    <option value="listrik">Listrik</option>
                    <option value="air">Air</option>
                    <option value="bahan_baku">Bahan Baku</option>
                    <option value="perawatan">Perawatan Alat</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="jumlah" id="jumlah" min="1" step="any"
                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md"
                        placeholder="0" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal"
                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ now()->format('Y-m-d') }}" required>
            </div>

            <div class="mb-4">
                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('keuangan.index') }}"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 font-medium">
                    Batal
                </a>
                <button type="submit"
                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-medium">
                    <i class="fas fa-save mr-1"></i> Simpan Pengeluaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
