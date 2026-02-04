@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="bg-purple-100 p-4 rounded-full">
                        <i class="fas fa-user-circle text-purple-600 text-4xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Selamat Datang!</h2>
                <p class="text-gray-600 mt-2">Silakan login ke akun Anda</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('email') border-red-500 @enderror"
                            placeholder="email@example.com" required autofocus>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password" required>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-purple-800 transition shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </button>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:text-purple-700">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>

                <!-- Back to Landing -->
                <div class="text-center mt-4">
                    <a href="{{ route('landing') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </form>

            <!-- Demo Credentials -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <p class="text-xs text-blue-800 font-medium mb-2">Demo Credentials:</p>
                <p class="text-xs text-blue-700">Admin: admin@esabumindo.com / admin123</p>
                <p class="text-xs text-blue-700">User: budi@example.com / password123</p>
            </div>
        </div>
    </div>
</div>
@endsection