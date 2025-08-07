@extends('layouts.layouts')

@section('title', 'Tambah User')

@section('content')
<div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah User Baru</h1>

    <form action="{{ route('users.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded shadow">
        @csrf

        {{-- Nama --}}
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200"
                   required>
            @error('nama')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200"
                   required>
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200"
                   required>
            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200"
                   required>
        </div>

        {{-- Role --}}
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="role"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200"
                    required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner</option>
            </select>
            @error('role')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between">
            <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
            <button type="submit"
                    class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 font-semibold">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
