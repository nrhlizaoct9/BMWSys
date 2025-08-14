<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $service->nomor_invoice }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        /* .logo {
            height: 60px;
            margin-bottom: 10px;
        } */
        .invoice-title {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .bengkel-info {
            font-size: 10pt;
            color: #555;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total {
            font-weight: bold;
            font-size: 14pt;
            text-align: right;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10pt;
            color: #555;
        }
        .signature {
            margin-top: 60px;
            text-align: center;
        }
        @font-face {
            font-family: 'CustomFont';
            src: url('path/to/font.ttf') format('truetype');
        }
        body {
            font-family: 'CustomFont', sans-serif;
        }
    </style>
</head>
<body>
    <div class="header">
        {{-- <img src="{{ public_path('img/bmw.jpg') }}" style="height: 80px;"> --}}
        <div class="invoice-title">INVOICE SERVICE</div>
        <div class="bengkel-info">
            BimmerWorks<br>
            Jl. Kerkof No.82, Leuwigajah, Kec. Cimahi Sel., Kota Cimahi<br>
            Telp: 0857-2041-8090
        </div>
    </div>

    <table>
        <tr>
            <td width="50%">
                <strong>No. Invoice:</strong> {{ $service->nomor_invoice }}<br>
                <strong>Tanggal:</strong> {{ $service->tanggal->format('d/m/Y') }}
            </td>
            <td width="50%">
                <strong>Pelanggan:</strong> {{ $service->nama_pelanggan }}<br>
                <strong>Plat Nomor:</strong> {{ $service->plat_nomor }}
            </td>
        </tr>
    </table>

    <h3>JASA SERVICE</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Jasa</th>
                <th class="text-right">Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($service->detailJasa as $jasa)
            <tr>
                <td>
                    {{ $jasa->serviceJob->nama_pekerjaan }}
                    @if($jasa->serviceJob->tipe_harga == 'per_jam')
                    <br><small>({{ $jasa->jumlah_jam }} jam)</small>
                    @endif
                </td>
                <td class="text-right">Rp {{ number_format($jasa->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($service->detailBarang->count() > 0)
    <h3>BARANG</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($service->detailBarang as $barang)
            <tr>
                <td>{{ $barang->barang->nama_barang }}</td>
                <td class="text-right">{{ $barang->jumlah }}</td>
                <td class="text-right">Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($barang->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="total">
        TOTAL: Rp {{ number_format($service->total, 0, ',', '.') }}
    </div>

    @if($service->keterangan)
    <div style="margin-top: 20px;">
        <strong>Keterangan:</strong><br>
        {{ $service->keterangan }}
    </div>
    @endif

    <div class="signature">
        <div style="border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px;">
            Hormat Kami,
        </div>
    </div>

    <div class="footer">
        Invoice ini sah dan diproses oleh komputer<br>
        Terima kasih telah menggunakan layanan kami
    </div>
</body>
</html>
