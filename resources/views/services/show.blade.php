@extends('layouts.layouts')

@section('title', 'Detail Service')

@section('content')
<div class="max-w-2xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white p-8 rounded-2xl border-[3px] border-black shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] hover:shadow-[0_15px_50px_-15px_rgba(0,0,0,0.25)] transition-shadow duration-300">
        <!-- Tombol Cetak -->
        <div class="flex justify-between items-center mb-6 print:hidden">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-car mr-2" style="color: #05325f;"></i> Detail Service
            </h1>
            <div class="space-x-2">
                {{-- <a href="{{ route('services.exportPdf', $service->id) }}"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-semibold">
                    <i class="fas fa-file-pdf mr-1"></i> PDF
                </a> --}}
                <button onclick="window.open('{{ route('services.exportPdf', $service->id) }}', '_blank')"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-semibold">
                    <i class="fas fa-print mr-1"></i> Cetak
                </button>
            </div>
        </div>

        <!-- Konten Utama -->
        <div id="invoice-content">
            <!-- Header Invoice -->
            <div class="text-center mb-8 print:mb-4">
                <h1 class="text-2xl font-bold text-gray-800 print:text-xl">INVOICE SERVICE</h1>
                <p class="text-gray-600">BimmerWorks</p>
                <p class="text-gray-600">Jl. Kerkof No.82, Leuwigajah, Kec. Cimahi Sel., Kota Cimahi</p>
                <p class="text-gray-600">Telp: 0857-2041-8090</p>
            </div>

            <!-- Informasi Service -->
            <div class="grid grid-cols-2 gap-4 mb-6 print:grid-cols-3 print:gap-2 print:text-sm">
                <div>
                    <p class="font-medium text-gray-700">No. Invoice</p>
                    <p>{{ $service->nomor_invoice }}</p>
                </div>
                <div>
                    <p class="font-medium text-gray-700">Tanggal</p>
                    <p>{{ $service->tanggal->format('d/m/Y') }}</p>
                </div>
                <div class="print:col-span-1">
                    <p class="font-medium text-gray-700">Pelanggan</p>
                    <p>{{ $service->nama_pelanggan }}</p>
                </div>
                <div>
                    <p class="font-medium text-gray-700">Plat Nomor</p>
                    <p class="uppercase">{{ $service->plat_nomor }}</p>
                </div>
            </div>

            <!-- Detail Jasa -->
            <div class="mb-6 print:mb-4">
                <h3 class="font-bold text-lg border-b border-gray-300 pb-1 mb-3 print:text-base">JASA SERVICE</h3>
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-300">
                            <th class="text-left py-2 print:py-1">Nama Jasa</th>
                            <th class="text-right py-2 print:py-1">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($service->detailJasa as $jasa)
                        <tr class="border-b border-gray-200">
                            <td class="py-2 print:py-1">
                                {{ $jasa->serviceJob->nama_pekerjaan }}
                                @if($jasa->serviceJob->tipe_harga == 'per_jam')
                                <span class="text-sm text-gray-500 block">({{ $jasa->jumlah_jam }} jam)</span>
                                @endif
                            </td>
                            <td class="text-right py-2 print:py-1">
                                Rp {{ number_format($jasa->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Detail Barang -->
            @if($service->detailBarang->count() > 0)
            <div class="mb-6 print:mb-4">
                <h3 class="font-bold text-lg border-b border-gray-300 pb-1 mb-3 print:text-base">BARANG</h3>
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-300">
                            <th class="text-left py-2 print:py-1">Nama Barang</th>
                            <th class="text-right py-2 print:py-1">Qty</th>
                            <th class="text-right py-2 print:py-1">Harga</th>
                            <th class="text-right py-2 print:py-1">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($service->detailBarang as $barang)
                        <tr class="border-b border-gray-200">
                            <td class="py-2 print:py-1">{{ $barang->barang->nama_barang }}</td>
                            <td class="text-right py-2 print:py-1">{{ $barang->jumlah }}</td>
                            <td class="text-right py-2 print:py-1">Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-right py-2 print:py-1">Rp {{ number_format($barang->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Total dan Keterangan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 print:grid-cols-2 print:gap-4">
                @if($service->keterangan)
                <div>
                    <h3 class="font-bold text-lg border-b border-gray-300 pb-1 mb-3 print:text-base">KETERANGAN</h3>
                    <p class="whitespace-pre-line">{{ $service->keterangan }}</p>
                </div>
                @endif
                <div class="@if(!$service->keterangan) md:col-span-2 @endif">
                    <h3 class="font-bold text-lg border-b border-gray-300 pb-1 mb-3 print:text-base">TOTAL</h3>
                    <p class="text-right text-2xl font-bold print:text-xl">Rp {{ number_format($service->total, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Tanda Tangan -->
            {{-- <div class="mt-12 print:mt-8 text-center">
                <div class="inline-block border-t border-gray-400 pt-2 px-8">
                    <p>Hormat Kami,</p>
                    <p class="mt-8">(___________________)</p>
                </div>
            </div> --}}
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-between items-center pt-4 print:hidden">
            <a href="{{ route('services.index') }}"
               class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 font-semibold transition">
                ← Kembali
            </a>
            <div class="space-x-2">
                <a href="{{ route('services.edit', $service->id) }}"
                   class="bg-yellow-500 text-white px-5 py-2 rounded-lg hover:bg-yellow-600 font-semibold">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus service ini?')"
                            class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 font-semibold">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Style untuk cetak -->
{{-- <style>
    @media print {
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            font-size: 12pt;
            color: #000;
            background: #fff;
        }
        .print-hidden {
            display: none !important;
        }
        #invoice-content {
            width: 100%;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 4px 0;
        }
    }
</style> --}}

{{-- <script>
    function printInvoice() {
        // Dapatkan HTML dari konten invoice
        const invoiceContent = document.getElementById('invoice-content').innerHTML;

        // Buka window baru untuk cetak
        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Cetak Invoice #${'{{ $service->nomor_invoice }}'}</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        padding: 8px;
                        text-align: left;
                        border-bottom: 1px solid #ddd;
                    }
                    .text-right {
                        text-align: right;
                    }
                    .total {
                        font-weight: bold;
                        font-size: 1.2em;
                    }
                </style>
            </head>
            <body>
                ${invoiceContent}
                <script>
                    window.onload = function() {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 1000);
                    };
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }
</script> --}}
@endsection
