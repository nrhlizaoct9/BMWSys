@extends('layouts.layouts')

@section('title', 'Tambah Supplier')

@section('content')
<div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white p-8 rounded-2xl border-[3px] border-black shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] hover:shadow-[0_15px_50px_-15px_rgba(0,0,0,0.25)] transition-shadow duration-300">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">Tambah Supplier</h1>

        <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Nama --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Supplier</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 pl-2"
                    required>
                @error('nama')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 pl-2">
                @error('alamat')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Telepon --}}
            <div>
                <label for="telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 pl-2">
                @error('telepon')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('suppliers.index') }}"
                   class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 font-semibold transition">
                    ← Kembali
                </a>
                <button type="submit"
                        class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 font-semibold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
