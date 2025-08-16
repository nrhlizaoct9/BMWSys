@extends('layouts.layouts')

@section('title', 'Login - BimmerWorks')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('img/bmw.jpg') }}'); background-size: cover; background-position: center;">
    <div class="w-full max-w-md px-8 py-10 bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-xl shadow-xl border border-white border-opacity-20 mx-4">
        <!-- Logo Header -->
        <div class="text-center mb-10">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('img/BMW3.png') }}" alt="BimmerWorks Logo" class="h-16">
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">BMW-SYS</h1>
            <p class="text-gray-300">Sistem Manajemen Penjualan dan Operasional BimmerWorks</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        class="w-full pl-10 pr-4 py-3 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        placeholder="your@email.com"
                    >
                </div>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full pl-10 pr-4 py-3 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        placeholder="••••••••"
                    >
                    <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-white" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-300">Ingat saya</label>
                </div>
                <a href="#" class="text-sm text-red-400 hover:text-red-300">Lupa password?</a>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-gradient-to-r from-red-600 to-red-800 text-white py-3 px-4 rounded-lg hover:opacity-90 transition duration-200 shadow-lg font-semibold flex items-center justify-center"
            >
                <i class="fas fa-sign-in-alt mr-2"></i> Masuk
            </button>
        </form>
    </div>
</div>

@section('scripts')
<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
</script>
@endsection
@endsection
