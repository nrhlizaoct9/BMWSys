@extends('layouts.layouts')

@section('title', 'Detail Pemesanan Barang')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white p-8 rounded-2xl border-[3px] border-black shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] hover:shadow-[0_15px_50px_-15px_rgba(0,0,0,0.25)] transition-shadow duration-300">
        <!-- Header Section -->
        <div class="flex items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-file-invoice text-blue-500 mr-3"></i> Detail Pemesanan Barang
                </h1>
                <p class="text-gray-500 mt-2">Berikut detail lengkap pemesanan barang</p>
            </div>
            <div class="bg-blue-50 px-5 py-2 rounded-lg border border-blue-200">
                <span class="font-semibold text-blue-700">Nomor:</span>
                <span class="ml-2">{{ $pemesanan->nomor_surat_jalan }}</span>
            </div>
        </div>
        <div class="border-b border-gray-200 mb-6"></div>

        <!-- Informasi Utama -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Supplier Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-truck text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Supplier</h3>
                        <p class="text-lg font-bold text-gray-800 mt-1">{{ $pemesanan->supplier->nama }}</p>
                    </div>
                </div>
                <div class="flex items-center text-gray-500 text-sm">
                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                    <span>{{ $pemesanan->supplier->alamat }}</span>
                </div>
            </div>

            <!-- Date Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="far fa-calendar-alt text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Tanggal Datang</h3>
                        <p class="text-lg font-bold text-gray-800 mt-1">
                            {{ $pemesanan->tanggal_datang->isoFormat('D MMMM Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center text-gray-500 text-sm">
                    <i class="far fa-clock mr-2 text-gray-400"></i>
                    <span>{{ $pemesanan->tanggal_datang->diffForHumans() }}</span>
                </div>
            </div>

            <!-- Status Card (Uncommented and improved) -->
            {{-- <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <i class="fas fa-info-circle text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Status</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                {{ $pemesanan->status == 'arrived' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($pemesanan->status) }}
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $pemesanan->status == 'arrived' ? 'Barang telah diterima' : 'Dalam proses' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center text-gray-500 text-sm">
                    <i class="fas fa-history mr-2 text-gray-400"></i>
                    <span>Terakhir diperbarui: {{ $pemesanan->updated_at->diffForHumans() }}</span>
                </div>
            </div> --}}
        </div>

        <!-- Daftar Barang -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-amber-100 p-2 rounded-lg">
                    <i class="fas fa-boxes text-amber-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold">Daftar Barang</h3>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Diskon</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">PPN</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pemesanan->details as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $item->barang->nama_barang }}</div>
                                <div class="text-sm text-gray-500">{{ $item->barang->kode_barang }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ $item->quantity }} {{ $item->barang->satuan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                @if($item->punyaDiskon())
                                    @if($item->diskon_tipe == 'persen')
                                        {{ $item->diskon_nilai }}%
                                    @else
                                        Rp {{ number_format($item->diskon_nilai, 0, ',', '.') }}
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                @if($item->punyaPpn())
                                    @if($item->ppn_tipe == 'persen')
                                        {{ $item->ppn_nilai }}%
                                    @else
                                        Rp {{ number_format($item->ppn_nilai, 0, ',', '.') }}
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Ringkasan Pembayaran -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Subtotal</h3>
                <p class="text-2xl font-bold">Rp {{ number_format($pemesanan->subtotal, 0, ',', '.') }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <h3 class="text-sm font-medium text-gray-500 mb-2">
                    Diskon Global
                    @if($pemesanan->diskon_global_nilai > 0)
                        <span class="text-xs text-gray-400">
                            ({{ $pemesanan->diskon_global_tipe == 'persen' ? 'Persentase' : 'Nominal' }})
                        </span>
                    @endif
                </h3>
                <p class="text-2xl font-bold text-red-600">
                    @if($pemesanan->diskon_global_tipe == 'persen')
                        - {{ $pemesanan->diskon_global_nilai }}%
                    @else
                        - Rp {{ number_format($pemesanan->total_diskon, 0, ',', '.') }}
                    @endif
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <h3 class="text-sm font-medium text-gray-500 mb-2">
                    PPN Global
                    @if($pemesanan->ppn_global_nilai > 0)
                        <span class="text-xs text-gray-400">
                            ({{ $pemesanan->ppn_global_tipe == 'persen' ? 'Persentase' : 'Nominal' }})
                        </span>
                    @endif
                </h3>
                <p class="text-2xl font-bold text-green-600">
                    @if($pemesanan->ppn_global_tipe == 'persen')
                        + {{ $pemesanan->ppn_global_nilai }}%
                    @else
                        + Rp {{ number_format($pemesanan->total_ppn, 0, ',', '.') }}
                    @endif
                </p>
            </div>
        </div>

        <!-- Total Pembayaran -->
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200 mb-10">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-blue-800">Total Pembayaran</h3>
                    <p class="text-sm text-blue-600">Termasuk semua pajak dan diskon</p>
                </div>
                <div class="text-3xl font-bold text-blue-900">
                    Rp {{ number_format($pemesanan->total_akhir, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('pemesanans.index') }}"
                class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 font-semibold transition">
                ← Kembali ke daftar
            </a>
            {{-- <button onclick="window.print()"
                    class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                <i class="fas fa-print mr-2"></i> Cetak
            </button> --}}
        </div>
    </div>
</div>
@endsection
