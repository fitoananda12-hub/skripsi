@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="bg-purple-100 p-4 rounded-full">
                        <i class="fas fa-user-plus text-purple-600 text-4xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Daftar Akun Baru</h2>
                <p class="text-gray-600 mt-2">Lengkapi data diri Anda untuk membuat akun</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('email') border-red-500 @enderror"
                            placeholder="email@example.com" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">NIK Karyawan <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('nik') border-red-500 @enderror"
                            placeholder="Contoh: NIK12345" required>
                        @error('nik')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jabatan -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('jabatan') border-red-500 @enderror"
                            placeholder="Contoh: Staff Marketing" required>
                        @error('jabatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Departemen -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Departemen <span class="text-red-500">*</span></label>
                        <input type="text" name="departemen" value="{{ old('departemen') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('departemen') border-red-500 @enderror"
                            placeholder="Contoh: Marketing" required>
                        @error('departemen')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('phone') border-red-500 @enderror"
                            placeholder="08xxxxxxxxxx" required>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">Alamat <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="3" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('address') border-red-500 @enderror"
                            placeholder="Masukkan alamat lengkap" required>{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('password') border-red-500 @enderror"
                            placeholder="Min. 8 karakter" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            placeholder="Ulangi password" required>
                    </div>
                </div>

                <!-- Cloudflare Turnstile -->
                <div class="mt-4">
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"></div>
                    @error('cf-turnstile-response')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full mt-6 bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-purple-800 transition shadow-lg">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </button>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:text-purple-700">
                            Login di sini
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
        </div>
    </div>
</div>

<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endsection