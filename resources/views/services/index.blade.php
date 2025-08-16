@extends('layouts.layouts')

@section('title', 'Data Service')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <!-- Flash Messages -->
    {{-- @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
    </div>
    @endif --}}

    <div class="bg-white border-l-4 border-red-600 shadow-[0_0_35px_rgba(0,0,0,0.25)] rounded-lg p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800 border-b-2 border-red-600 pb-2">
                <i class="fas fa-car mr-2" style="color: #7d1298;"></i>
                Data Transaksi Service
            </h1>
            <a href="{{ route('services.create') }}"
               class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-semibold shadow transition duration-200">
                <i class="fas fa-plus mr-1"></i> Tambah Service
            </a>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table id="serviceTable" class="min-w-full divide-y divide-gray-200 text-sm text-gray-800 border border-gray-200 shadow-md rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-left">No. Invoice</th>
                        <th class="px-6 py-3 text-left">Pelanggan</th>
                        <th class="px-6 py-3 text-left">Plat Nomor</th>
                        <th class="px-6 py-3 text-left">Total</th>
                        <th class="px-6 py-3 text-left">Status Bayar</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($services as $service)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ ($services->currentPage() - 1) * $services->perPage() + $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($service->tanggal)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $service->nomor_invoice }}</td>
                        <td class="px-6 py-4">{{ $service->nama_pelanggan }}</td>
                        <td class="px-6 py-4 uppercase">{{ $service->plat_nomor }}</td>
                        <td class="px-6 py-4 font-bold">Rp {{ number_format($service->total, 0, ',', '.') }}</td>
                        <td>
                            @if($service->tipe_pembayaran == 'tunai')
                                <span class="badge bg-green-100 text-green-800">Lunas</span>
                            @else
                                <span class="badge bg-yellow-100 text-yellow-800">
                                    Kredit (Rp {{ number_format($service->total_terbayar, 0) }}/{{ number_format($service->total, 0) }})
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <!-- View Button -->
                                <a href="{{ route('services.show', $service->id) }}"
                                   class="text-blue-600 hover:text-blue-800 p-1 rounded-full hover:bg-blue-50"
                                   title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('services.edit', $service->id) }}"
                                   class="text-yellow-600 hover:text-yellow-800 p-1 rounded-full hover:bg-yellow-50"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus service ini?')"
                                            class="text-red-600 hover:text-red-800 p-1 rounded-full hover:bg-red-50"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <i class="fas fa-info-circle mr-2"></i> Tidak ada data service
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
        <div class="mt-4">
            {{ $services->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable with enhanced configuration
        $('#serviceTable').DataTable({
            responsive: true,
            dom: '<"flex justify-between items-center mb-4"<"flex-1"l><"flex-1"f>>rt<"flex justify-between items-center mt-4"<"flex-1"i><"flex-1"p>>',
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "← Sebelumnya",
                    next: "Berikutnya →"
                },
                zeroRecords: "Tidak ditemukan data yang cocok",
                emptyTable: "Tidak ada data service",
                infoEmpty: "Menampilkan 0 dari 0 data",
            },
            columnDefs: [
                {
                    orderable: false,
                    targets: [6] // Disable sorting for action column
                },
                {
                    className: "whitespace-nowrap",
                    targets: [1, 6] // Apply nowrap for date and action columns
                }
            ],
            order: [[1, 'desc']], // Default sort by date descending
            initComplete: function() {
                // Optional: Add any initialization complete logic here
            }
        });
    });
</script>
@endsection
