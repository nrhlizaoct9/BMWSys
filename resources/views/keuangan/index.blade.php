<!-- resources/views/keuangan/index.blade.php -->
@extends('layouts.layouts')

@section('title', 'Manajemen Keuangan')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Dashboard Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <h3 class="text-sm font-medium text-green-800">Total Pemasukan</h3>
                <p class="text-2xl font-bold mt-2">Rp {{ number_format($saldo['pemasukan'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                <h3 class="text-sm font-medium text-red-800">Total Pengeluaran</h3>
                <p class="text-2xl font-bold mt-2">Rp {{ number_format($saldo['pengeluaran'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <h3 class="text-sm font-medium text-blue-800">Pembayaran Piutang</h3>
                <p class="text-2xl font-bold mt-2">Rp {{ number_format($saldo['pembayaran'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                <h3 class="text-sm font-medium text-purple-800">Saldo Kas</h3>
                <p class="text-2xl font-bold mt-2">Rp {{ number_format($saldo['saldo'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Hutang ke supplier -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-exclamation-circle text-yellow-500 mr-2"></i> Hutang ke Supplier
                </h2>
            </div>

            @if($piutang->isEmpty())
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-center">
                    Tidak ada piutang yang belum lunas
                </div>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">No. Surat Jalan</th>
                                <th class="px-6 py-3 text-left">Supplier</th>
                                <th class="px-6 py-3 text-right">Total Tagihan</th>
                                <th class="px-6 py-3 text-right">Terbayar</th>
                                <th class="px-6 py-3 text-right">Sisa</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($piutang as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $item->nomor_surat_jalan }}</td>
                                <td class="px-6 py-4">{{ $item->supplier->nama }}</td>
                                <td class="px-6 py-4 text-right">Rp {{ number_format($item->total_akhir, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right">Rp {{ number_format($item->cicilan_sum_jumlah ?? 0, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-semibold text-red-600">
                                    Rp {{ number_format($item->total_akhir - ($item->cicilan_sum_jumlah ?? 0), 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('keuangan.bayar-cicilan', $item->id) }}"
                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                        Bayar Cicilan
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Riwayat Transaksi -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-history text-gray-500 mr-2"></i> Riwayat Transaksi
                </h2>
                <div class="flex space-x-2">
                    <a href="{{ route('keuangan.pemasukan.create') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 font-semibold">
                        <i class="fas fa-plus mr-1"></i> Pemasukan
                    </a>
                    <a href="{{ route('keuangan.pengeluaran.create') }}"
                       class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-semibold">
                        <i class="fas fa-minus mr-1"></i> Pengeluaran
                    </a>
                    <a href="{{ route('keuangan.laporan') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold">
                        <i class="fas fa-file-alt mr-1"></i> Laporan
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">Kode</th>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-left">Tipe</th>
                            <th class="px-6 py-3 text-left">Kategori</th>
                            <th class="px-6 py-3 text-right">Jumlah</th>
                            <th class="px-6 py-3 text-left">Keterangan</th>
                            <th class="px-6 py-3 text-left">User</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transaksi as $trx)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $trx->kode_transaksi }}</td>
                            <td class="px-6 py-4">{{ $trx->tanggal->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
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
                            <td class="px-6 py-4">{{ $trx->kategori ?? '-' }}</td>
                            <td class="px-6 py-4 text-right font-medium
                                @if($trx->tipe == 'pemasukan' || $trx->tipe == 'pembayaran') text-green-600 @else text-red-600 @endif">
                                Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">{{ $trx->keterangan }}</td>
                            <td class="px-6 py-4">{{ $trx->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $transaksi->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
