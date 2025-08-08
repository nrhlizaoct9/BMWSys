@extends('layouts.layouts')

@section('title', 'Data Supplier')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white border-l-4 border-red-600 shadow-[0_0_35px_rgba(0,0,0,0.25)] rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800 border-b-2 border-red-600 pb-2">
                🏪 Manajemen Supplier
            </h1>
            <a href="{{ route('suppliers.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-semibold shadow">
                <i class="fas fa-plus"></i> Tambah Supplier
            </a>
        </div>

        <table id="myTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-800 table-auto border border-gray-200 shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Alamat</th>
                    <th class="px-6 py-3 text-left">No. Telepon</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($suppliers as $supplier)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $supplier->nama }}</td>
                        <td class="px-6 py-4">{{ $supplier->alamat }}</td>
                        <td class="px-6 py-4">{{ $supplier->telepon }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus supplier ini?')" class="text-red-600 hover:underline font-medium">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data supplier.</td>
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
        $('#myTable').DataTable({
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
            }
        });
    });
</script>
@endsection
