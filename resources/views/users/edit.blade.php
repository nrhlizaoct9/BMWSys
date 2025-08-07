@extends('layouts.layouts')

@section('title', 'Edit User')

@section('content')
<div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Data User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200"
                   required>
            @error('nama')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200"
                   required>
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role --}}
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="role"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200"
                    required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="owner" {{ old('role', $user->role) == 'owner' ? 'selected' : '' }}>Owner</option>
            </select>
            @error('role')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password Optional --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password (opsional)</label>
            <input type="password" name="password" id="password"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200">
            <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah password.</p>
            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200">
        </div>

        <div class="flex justify-between">
            <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
            <button type="submit"
                    class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 font-semibold">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
