@extends('layouts.layouts')

@section('title', 'Pembayaran Cicilan')

@section('content')
<div class="max-w-md mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            <i class="fas fa-money-bill-wave mr-2"></i> Pembayaran Cicilan
        </h2>

        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h3 class="font-medium text-gray-700 mb-2">Informasi Pemesanan</h3>
            <div class="grid grid-cols-2 gap-2 text-sm">
                <div>No. Surat Jalan:</div>
                <div class="font-medium">{{ $pemesanan->nomor_surat_jalan }}</div>

                <div>Supplier:</div>
                <div class="font-medium">{{ $pemesanan->supplier->nama }}</div>

                <div>Total Tagihan:</div>
                <div class="font-medium">Rp {{ number_format($pemesanan->total_akhir, 0, ',', '.') }}</div>

                <div>Sisa Pembayaran:</div>
                <div class="font-medium text-red-600">Rp {{ number_format($sisa, 0, ',', '.') }}</div>
            </div>
        </div>

        <form action="{{ route('keuangan.store-cicilan', $pemesanan->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="jumlah" id="jumlah" min="1" max="{{ $sisa }}"
                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md"
                        placeholder="0" required>
                </div>
                <p class="mt-1 text-xs text-gray-500">Maksimal: Rp {{ number_format($sisa, 0, ',', '.') }}</p>
            </div>

            <div class="mb-4">
                <label for="tanggal_bayar" class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                <input type="date" name="tanggal_bayar" id="tanggal_bayar"
                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ now()->format('Y-m-d') }}" required>
            </div>

            <div class="mb-4">
                <label for="metode_bayar" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                <select name="metode_bayar" id="metode_bayar"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="tunai">Tunai</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="cek">Cek/Giro</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="bukti_bayar" class="block text-sm font-medium text-gray-700">Bukti Pembayaran</label>
                <input type="file" name="bukti_bayar" id="bukti_bayar"
                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                <textarea name="catatan" id="catatan" rows="2"
                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('keuangan.index') }}"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 font-medium">
                    Batal
                </a>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium">
                    <i class="fas fa-save mr-1"></i> Simpan Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Validasi jumlah tidak melebihi sisa
    document.getElementById('jumlah').addEventListener('change', function() {
        const max = parseFloat("{{ $sisa }}");
        const value = parseFloat(this.value);

        if (value > max) {
            alert('Jumlah pembayaran tidak boleh melebihi sisa tagihan');
            this.value = max;
        }
    });
</script>
@endsection
