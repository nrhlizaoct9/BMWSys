@extends('layouts.layouts')

@section('title', 'Tambah Jenis Barang')

@section('content')
<div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white p-8 rounded-2xl border-[3px] border-black shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] hover:shadow-[0_15px_50px_-15px_rgba(0,0,0,0.25)] transition-shadow duration-300">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">
            <i class="fas fa-boxes" style="color: #A0522D;"></i> Tambah Jenis Barang
        </h1>

        <form action="{{ route('jenis-barang.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Nama Jenis Barang --}}
            <div>
                <label for="nama_jenis" class="block text-sm font-medium text-gray-700">Nama Jenis Barang</label>
                <input type="text" name="nama_jenis" id="nama_jenis" value="{{ old('nama_jenis') }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    required>
                @error('nama_jenis')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('jenis-barang.index') }}"
                   class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 font-semibold transition">
                    ← Kembali
                </a>
                <button type="submit"
                        class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 font-semibold transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
