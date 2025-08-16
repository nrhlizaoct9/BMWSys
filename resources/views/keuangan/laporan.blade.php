@extends('layouts.layouts')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-file-alt mr-2"></i> Laporan Keuangan
            </h2>

            <form method="GET" class="flex items-center space-x-3">
                <div>
                    <label for="start_date" class="sr-only">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                        class="border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <span>s/d</span>
                <div>
                    <label for="end_date" class="sr-only">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                        class="border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
            </form>
        </div>

        <!-- Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <h3 class="text-sm font-medium text-green-800">Total Pemasukan</h3>
                <p class="text-2xl font-bold mt-2">Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                <h3 class="text-sm font-medium text-red-800">Total Pengeluaran</h3>
                <p class="text-2xl font-bold mt-2">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <h3 class="text-sm font-medium text-blue-800">Pembayaran Piutang</h3>
                <p class="text-2xl font-bold mt-2">Rp {{ number_format($pembayaran, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Grafik (Placeholder) -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-medium text-gray-700">Grafik Arus Kas</h3>
                <div class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                </div>
            </div>
            <div class="h-64 flex items-center justify-center bg-white rounded">
                <p class="text-gray-400">[Visualisasi grafik akan ditampilkan di sini]</p>
            </div>
        </div>

        <!-- Detail Transaksi -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-left">Kode</th>
                        <th class="px-6 py-3 text-left">Tipe</th>
                        <th class="px-6 py-3 text-left">Keterangan</th>
                        <th class="px-6 py-3 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transaksi as $trx)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $trx->tanggal->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $trx->kode_transaksi }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($trx->tipe == 'pemasukan')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                    Pemasukan
                                </span>
                            @elseif($trx->tipe == 'pengeluaran')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                    Pengeluaran
                                </span>
                            @else
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                    Pembayaran
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ $trx->keterangan }}
                            @if($trx->kategori)
                                <span class="text-xs text-gray-500 block mt-1">{{ $trx->kategori }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-medium
                            @if($trx->tipe == 'pemasukan' || $trx->tipe == 'pembayaran') text-green-600 @else text-red-600 @endif">
                            Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada transaksi pada periode yang dipilih
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gray-50 font-semibold">
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-right">Total</td>
                        <td class="px-6 py-3 text-right">
                            Rp {{ number_format($pemasukan + $pembayaran - $pengeluaran, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Tombol Cetak -->
        <div class="mt-6 flex justify-end">
            <button onclick="window.print()"
                class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 font-medium">
                <i class="fas fa-print mr-1"></i> Cetak Laporan
            </button>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .content-print, .content-print * {
            visibility: visible;
        }
        .content-print {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection
