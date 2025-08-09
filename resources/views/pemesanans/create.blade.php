@extends('layouts.layouts')

@section('title', 'Input Barang Masuk')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white p-8 rounded-2xl border-[3px] border-black shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] hover:shadow-[0_15px_50px_-15px_rgba(0,0,0,0.25)] transition-shadow duration-300">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">
            <i class="fas fa-dolly" style="color: #2196F3;"></i> Input Barang Masuk
        </h1>

        <form action="{{ route('pemesanans.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Supplier --}}
                <div>
                    <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor Surat Jalan --}}
                <div>
                    <label for="nomor_surat_jalan" class="block text-sm font-medium text-gray-700">Nomor Surat Jalan</label>
                    <input type="text" name="nomor_surat_jalan" id="nomor_surat_jalan" value="{{ old('nomor_surat_jalan') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                        placeholder="Contoh: SJ/2025/001" required>
                    @error('nomor_surat_jalan')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Datang --}}
                <div>
                    <label for="tanggal_datang" class="block text-sm font-medium text-gray-700">Tanggal Datang</label>
                    <input type="date" name="tanggal_datang" id="tanggal_datang" value="{{ old('tanggal_datang', date('Y-m-d')) }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                        required>
                    @error('tanggal_datang')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Daftar Barang --}}
            <div class="pt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-boxes mr-2" style="color: #6D4C41;"></i> Daftar Barang
                </h3>

                <div id="items-container" class="space-y-4">
                    <!-- Baris Item Pertama -->
                    <div class="item-container">
                        <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            {{-- Barang --}}
                            <div class="md:col-span-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
                                <select name="items[0][barang_id]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Quantity --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                <input type="number" name="items[0][quantity]" min="1" value="1"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border" required>
                            </div>

                            {{-- Harga Beli --}}
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli (per satuan)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600">Rp</span>
                                    <input type="number" name="items[0][harga_beli]" min="0" step="1000"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border pl-10"
                                        required>
                                </div>
                            </div>

                            {{-- Tombol Hapus --}}
                            <div class="md:col-span-2 flex items-end">
                                <button type="button" class="remove-item w-full bg-red-600 text-white px-3 py-2 rounded-md hover:bg-red-700 font-semibold shadow text-sm">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Tambah Barang --}}
                <button type="button" id="add-item" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold shadow">
                    <i class="fas fa-plus mr-1"></i> Tambah Barang
                </button>
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('pemesanans.index') }}"
                   class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 font-semibold transition">
                    ← Kembali
                </a>
                <button type="submit"
                        class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 font-semibold transition">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tambah baris barang
    let itemIndex = 1;
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const newItem = document.createElement('div');
        newItem.className = 'item-container';
        newItem.innerHTML = `
            <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="md:col-span-5">
                    <select name="items[${itemIndex}][barang_id]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border" required>
                        <option value="">Pilih Barang</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <input type="number" name="items[${itemIndex}][quantity]" min="1" value="1"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border" required>
                </div>
                <div class="md:col-span-3">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600">Rp</span>
                        <input type="number" name="items[${itemIndex}][harga_beli]" min="0" step="1000"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2 border pl-10"
                            required>
                    </div>
                </div>
                <div class="md:col-span-2 flex items-end">
                    <button type="button" class="remove-item w-full bg-red-600 text-white px-3 py-2 rounded-md hover:bg-red-700 font-semibold shadow text-sm">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        itemIndex++;
    });

    // Hapus baris barang dengan animasi
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
            const itemContainer = e.target.closest('.item-container');

            if (document.querySelectorAll('.item-container').length > 1) {
                // Animasi fade out sebelum dihapus
                itemContainer.style.transition = 'opacity 0.3s ease';
                itemContainer.style.opacity = '0';

                setTimeout(() => {
                    itemContainer.remove();
                }, 300);
            } else {
                // Reset form jika hanya tersisa 1 baris
                const inputs = itemContainer.querySelectorAll('input, select');
                inputs.forEach(input => input.value = '');
            }
        }
    });
</script>

<style>
    .item-container {
        transition: all 0.3s ease;
    }

    /* Responsive untuk mobile */
    @media (max-width: 768px) {
        .item-row {
            grid-template-columns: 1fr !important;
        }

        .md\:col-span-2, .md\:col-span-3, .md\:col-span-5 {
            grid-column: span 1 !important;
        }
    }
</style>
@endsection
