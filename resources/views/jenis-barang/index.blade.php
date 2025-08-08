@extends('layouts.layouts')

@section('title', 'Data Jenis Barang')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white border-l-4 border-red-600 shadow-[0_0_35px_rgba(0,0,0,0.25)] rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800 border-b-2 border-red-600 pb-2">
                <i class="fas fa-boxes" style="color: #A0522D;"></i> Manajemen Jenis Barang
            </h1>
            <a href="{{ route('jenis-barang.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-semibold shadow">
                <i class="fas fa-plus"></i> Tambah Jenis Barang
            </a>
        </div>

        <table id="jenisBarangTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-800 table-auto border border-gray-200 shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nama Jenis Barang</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($jenisBarangs as $jenis)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $jenis->nama_jenis }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('jenis-barang.edit', $jenis->id) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
                            <form action="{{ route('jenis-barang.destroy', $jenis->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus jenis barang ini?')" class="text-red-600 hover:underline font-medium">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada data jenis barang</td>
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
        $('#jenisBarangTable').DataTable({
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
            columnDefs: [
                { orderable: false, targets: 2 } // Menonaktifkan sorting untuk kolom aksi
            ]
        });
    });
</script>
@endsection
