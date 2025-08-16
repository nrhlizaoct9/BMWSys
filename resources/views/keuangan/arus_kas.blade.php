@extends('layouts.layouts')

@section('title', 'Laporan Arus Kas')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-chart-line mr-2"></i> Laporan Arus Kas
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

        <!-- Grafik Arus Kas -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-medium text-gray-700">Grafik Arus Kas Harian</h3>
                <div class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                </div>
            </div>
            <div class="h-96 bg-white rounded p-4">
                <canvas id="cashFlowChart"></canvas>
            </div>
        </div>

        <!-- Detail Harian -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Transaksi Harian</h3>

            @foreach($grouped as $date => $data)
            <div class="mb-6 border-b border-gray-200 pb-4">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-medium text-gray-700">
                        {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                    </h4>
                    <div class="flex space-x-4">
                        <span class="text-sm text-green-600">
                            <i class="fas fa-arrow-down mr-1"></i> Rp {{ number_format($data['pemasukan'], 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-blue-600">
                            <i class="fas fa-exchange-alt mr-1"></i> Rp {{ number_format($data['pembayaran'], 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-red-600">
                            <i class="fas fa-arrow-up mr-1"></i> Rp {{ number_format($data['pengeluaran'], 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                @if($data['transaksi']->isNotEmpty())
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Waktu</th>
                                <th class="px-4 py-2 text-left">Kode</th>
                                <th class="px-4 py-2 text-left">Tipe</th>
                                <th class="px-4 py-2 text-left">Keterangan</th>
                                <th class="px-4 py-2 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($data['transaksi'] as $trx)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $trx->created_at->format('H:i') }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $trx->kode_transaksi }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
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
                                <td class="px-4 py-2">
                                    {{ $trx->keterangan }}
                                    @if($trx->kategori)
                                        <span class="text-xs text-gray-500 block mt-1">{{ $trx->kategori }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right font-medium
                                    @if($trx->tipe == 'pemasukan' || $trx->tipe == 'pembayaran') text-green-600 @else text-red-600 @endif">
                                    Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-gray-500 text-center py-4">Tidak ada transaksi pada hari ini</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dates = {!! json_encode(array_keys($grouped->toArray())) !!};
        const pemasukan = {!! json_encode(array_column($grouped->toArray(), 'pemasukan')) !!};
        const pengeluaran = {!! json_encode(array_column($grouped->toArray(), 'pengeluaran')) !!};
        const pembayaran = {!! json_encode(array_column($grouped->toArray(), 'pembayaran')) !!};

        const ctx = document.getElementById('cashFlowChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dates.map(date => new Date(date).toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'short'
                })),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: pemasukan,
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pembayaran',
                        data: pembayaran,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran',
                        data: pengeluaran.map(value => -value), // Negatif untuk tampilan
                        backgroundColor: 'rgba(239, 68, 68, 0.7)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + Math.abs(context.parsed.y).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
