@extends('layouts.layouts')

@section('title', 'Edit User')

@section('content')
<div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white p-8 rounded-2xl border-[3px] border-black shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] hover:shadow-[0_15px_50px_-15px_rgba(0,0,0,0.25)] transition-shadow duration-300">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">
            <i class="fas fa-users-cog" style="color: #f3b38b;"></i> Edit User</h1>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    required>
                @error('nama')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    required>
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Telepon --}}
            <div>
                <label for="telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $users->telepon) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2">
                @error('telepon')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Optional --}}
            <div x-data="{ show: false }">
                <label for="password" class="block text-sm font-medium text-gray-700">Password (opsional)</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" name="password" id="password"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" @click="show = !show">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.973 9.973 0 012.203-3.362m2.397-2.397A9.973 9.973 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-1.334 2.592M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M3 3l18 18" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah password.</p>
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div x-data="{ show: false }">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" name="password_confirmation" id="password_confirmation"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" @click="show = !show">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.973 9.973 0 012.203-3.362m2.397-2.397A9.973 9.973 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-1.334 2.592M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M3 3l18 18" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 p-2"
                    required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="owner" {{ old('role', $user->role) == 'owner' ? 'selected' : '' }}>Owner</option>
                </select>
                @error('role')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('users.index') }}"
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
