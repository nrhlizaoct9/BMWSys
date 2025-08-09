@extends('layouts.layouts')

@section('title', 'Edit Barang')

@section('content')
<div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white p-8 rounded-2xl border-[3px] border-black shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] hover:shadow-[0_15px_50px_-15px_rgba(0,0,0,0.25)] transition-shadow duration-300">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">
            <i class="fas fa-box-open" style="color: #8B4513;"></i> Edit Barang
        </h1>

        <form action="{{ route('barangs.update', $barang->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Kode Barang (Readonly) --}}
            <div>
                <label for="kode_barang" class="block text-sm font-medium text-gray-700">Kode Barang</label>
                <input type="text" name="kode_barang" id="kode_barang"
                    value="{{ old('kode_barang', $barang->kode_barang) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 bg-gray-100"
                    readonly>
                @error('kode_barang')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Barang --}}
            <div>
                <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang"
                    value="{{ old('nama_barang', $barang->nama_barang) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    required>
                @error('nama_barang')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jenis Barang --}}
            <div>
                <label for="jenis_barang_id" class="block text-sm font-medium text-gray-700">Jenis Barang</label>
                <select name="jenis_barang_id" id="jenis_barang_id"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    required>
                    <option value="">Pilih Jenis Barang</option>
                    @foreach($jenisBarangs as $jenis)
                        <option value="{{ $jenis->id }}"
                            {{ (old('jenis_barang_id', $barang->jenis_barang_id) == $jenis->id) ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_barang_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Stok --}}
            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stok" id="stok"
                    value="{{ old('stok', $barang->stok) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    min="0" required>
                @error('stok')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Stok Minimum --}}
            <div>
                <label for="stok_min" class="block text-sm font-medium text-gray-700">Stok Minimum</label>
                <input type="number" name="stok_min" id="stok_min"
                    value="{{ old('stok_min', $barang->stok_min) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    min="0" required>
                @error('stok_min')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Satuan --}}
            <div>
                <label for="satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
                <input type="text" name="satuan" id="satuan"
                    value="{{ old('satuan', $barang->satuan) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    placeholder="Contoh: pcs, kg, liter"
                    required>
                @error('satuan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga Beli --}}
            <div>
                <label for="harga_beli" class="block text-sm font-medium text-gray-700">Harga Beli (Rp)</label>
                <input type="text" name="harga_beli" id="harga_beli"
                    value="{{ old('harga_beli', number_format($barang->harga_beli, 0, ',', '.')) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    required>
                @error('harga_beli')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga Jual --}}
            <div>
                <label for="harga_jual" class="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                <input type="text" name="harga_jual" id="harga_jual"
                    value="{{ old('harga_jual', number_format($barang->harga_jual, 0, ',', '.')) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    required>
                @error('harga_jual')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('barangs.index') }}"
                   class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 font-semibold transition">
                    ← Kembali
                </a>
                <button type="submit"
                        class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 font-semibold transition">
                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Format input harga
    function formatRupiah(input) {
        input.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            if(value.length > 0) {
                value = parseInt(value, 10).toLocaleString('id-ID');
            }
            this.value = value;
        });
    }

    // Terapkan format ke semua input harga
    formatRupiah(document.getElementById('harga_beli'));
    formatRupiah(document.getElementById('harga_jual'));

    // Handle form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        const hargaBeliInput = document.getElementById('harga_beli');
        const hargaJualInput = document.getElementById('harga_jual');

        hargaBeliInput.value = hargaBeliInput.value.replace(/\./g, '');
        hargaJualInput.value = hargaJualInput.value.replace(/\./g, '');
    });
</script>
@endsection
