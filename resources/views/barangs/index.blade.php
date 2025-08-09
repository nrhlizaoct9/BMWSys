@extends('layouts.layouts')

@section('title', 'Data Barang')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white border-l-4 border-red-600 shadow-[0_0_35px_rgba(0,0,0,0.25)] rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800 border-b-2 border-red-600 pb-2">
                <i class="fas fa-box-open" style="color: #8B4513;"></i> Manajemen Stok Barang
            </h1>
            <a href="{{ route('barangs.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-semibold shadow">
                <i class="fas fa-plus"></i> Tambah Barang
            </a>
        </div>

        <table id="barangTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-800 table-auto border border-gray-200 shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Kode Barang</th>
                    <th class="px-6 py-3 text-left">Nama Barang</th>
                    <th class="px-6 py-3 text-left">Jenis Barang</th>
                    <th class="px-6 py-3 text-left">Stok</th>
                    <th class="px-6 py-3 text-left">Stok Min.</th>
                    <th class="px-6 py-3 text-left">Satuan</th>
                    <th class="px-6 py-3 text-left">Harga Beli</th>
                    <th class="px-6 py-3 text-left">Harga Jual</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($barangs as $barang)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-mono">{{ $barang->kode_barang }}</td>
                        <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                        <td class="px-6 py-4">{{ $barang->jenisBarang->nama_jenis }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $barang->isStokRendah() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $barang->stok }}
                                {{-- @if($barang->isStokRendah())
                                    <svg class="w-4 h-4 inline ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                @endif --}}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $barang->stok_min }}</td>
                        <td class="px-6 py-4">{{ $barang->satuan }}</td>
                        <td class="px-6 py-4">{{ $barang->harga_beli_formatted }}</td>
                        <td class="px-6 py-4">{{ $barang->harga_jual_formatted }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('barangs.edit', $barang->id) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
                            <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus barang ini?')" class="text-red-600 hover:underline font-medium">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-4 text-center text-gray-500">Tidak ada data barang</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#barangTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "← Sebelumnya",
                    next: "Berikutnya →"
                },
                zeroRecords: "Tidak ditemukan data yang cocok",
            },
            // Atur default sorting
            // order: [[0, 'asc']], // Kolom pertama (No) diurutkan ascending
            // columnDefs: [
            //     {
            //         orderable: false,
            //         targets: 9 // Nonaktifkan sorting untuk kolom aksi
            //     },
            //     {
            //         type: 'num-fmt',
            //         targets: [3,4,6,7] // Kolom angka (stok, harga)
            //     }
            // ]
        });
    });
</script>
{{-- <style>
    th.sorting::after {
        content: "↓↑";
        opacity: 0.3;
        margin-left: 8px;
        font-size: 12px;
        color: #6b7280;
        display: inline-block;
    }
    th.sorting_asc::after {
        content: "↑";
        opacity: 1;
        color: #ef4444;
    }
    th.sorting_desc::after {
        content: "↓";
        opacity: 1;
        color: #ef4444;
    }
</style> --}}
@endsection
