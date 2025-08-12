@extends('layouts.layouts')

@section('title', 'Data Layanan Servis')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white border-l-4 border-red-600 shadow-[0_0_35px_rgba(0,0,0,0.25)] rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800 border-b-2 border-red-600 pb-2">
                <i class="fas fa-wrench text-red-500"></i> Manajemen Layanan Servis
            </h1>
            <a href="{{ route('service_jobs.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-semibold shadow">
                <i class="fas fa-plus"></i> Tambah Layanan Servis
            </a>
        </div>

        <table id="myTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-800 table-auto border border-gray-200 shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nama Pekerjaan</th>
                    <th class="px-6 py-3 text-left">Estimasi Waktu</th>
                    <th class="px-6 py-3 text-left">Tipe Harga</th>
                    <th class="px-6 py-3 text-left">Harga Jual</th>
                    <th class="px-6 py-3 text-left">HPP Jasa</th>
                    <th class="px-6 py-3 text-left">Deskripsi</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($services as $index => $service)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $service->nama_pekerjaan }}</td>
                        <td class="px-6 py-4">{{ $service->estimasi_waktu ?? '-' }}</td>
                        <td class="px-6 py-4">{{ ucfirst($service->tipe_harga) }}</td>
                        <td class="px-6 py-4">
                            {{ $service->harga_jual ? 'Rp '.number_format($service->harga_jual, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $service->hpp_jasa ? 'Rp '.number_format($service->hpp_jasa, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-6 py-4">{{ $service->deskripsi }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('service_jobs.edit', $service->id) }}" class="text-blue-600 hover:underline font-medium"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('service_jobs.destroy', $service->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus layanan ini?')" class="text-red-600 hover:underline font-medium">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data layanan servis</td>
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
