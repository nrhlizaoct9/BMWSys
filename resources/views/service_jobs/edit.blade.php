@extends('layouts.layouts')

@section('title', 'Edit Layanan Servis')

@section('content')
<div class="max-w-2xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white p-8 rounded-2xl border-[3px] border-black shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] hover:shadow-[0_15px_50px_-15px_rgba(0,0,0,0.25)] transition-shadow duration-300">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">
            <i class="fas fa-wrench mr-2" style="color: #ef4444;"></i> Edit Layanan Servis
        </h1>

        <form action="{{ route('service_jobs.update', $serviceJob->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Pekerjaan -->
            <div>
                <label for="nama_pekerjaan" class="block text-sm font-medium text-gray-700">Nama Pekerjaan</label>
                <input type="text" name="nama_pekerjaan" id="nama_pekerjaan" 
                    value="{{ old('nama_pekerjaan', $serviceJob->nama_pekerjaan) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    placeholder="Contoh: Ganti Oli Mesin" required>
                @error('nama_pekerjaan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Estimasi Waktu --}}
            <div>
                <label for="estimasi_waktu" class="block text-sm font-medium text-gray-700">Estimasi Waktu</label>
                <input type="text" name="estimasi_waktu" id="estimasi_waktu"
                    value="{{ old('estimasi_waktu', $serviceJob->estimasi_waktu) }}"
                    placeholder="Contoh: 30 menit / 2 jam"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2">
                @error('estimasi_waktu')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipe Harga --}}
            <div>
                <label for="tipe_harga" class="block text-sm font-medium text-gray-700">Tipe Harga</label>
                <select name="tipe_harga" id="tipe_harga"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2">
                    <option value="tetap" {{ old('tipe_harga', $serviceJob->tipe_harga) == 'tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="per_jam" {{ old('tipe_harga', $serviceJob->tipe_harga) == 'per_jam' ? 'selected' : '' }}>Per Jam</option>
                </select>
                @error('tipe_harga')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga Jual --}}
            <div>
                <label for="harga_jual" class="block text-sm font-medium text-gray-700">Harga Jual</label>
                <input type="number" name="harga_jual" id="harga_jual"
                    value="{{ old('harga_jual', $serviceJob->harga_jual) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2">
                @error('harga_jual')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- HPP Jasa --}}
            <div>
                <label for="hpp_jasa" class="block text-sm font-medium text-gray-700">HPP Jasa</label>
                <input type="number" name="hpp_jasa" id="hpp_jasa"
                    value="{{ old('hpp_jasa', $serviceJob->hpp_jasa) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2">
                @error('hpp_jasa')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    placeholder="Detail pekerjaan yang akan dilakukan">{{ old('deskripsi', $serviceJob->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('service_jobs.index') }}"
                   class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 font-semibold transition">
                    ← Kembali
                </a>
                <button type="submit"
                        class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 font-semibold">
                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection