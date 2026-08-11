@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - Menunggu Verifikasi')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-lg w-full">
        <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">

            {{-- Animated Icon --}}
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center animate-pulse">
                        <i class="fas fa-hourglass-half text-yellow-500 text-4xl"></i>
                    </div>
                    <div class="absolute -top-1 -right-1 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                </div>
            </div>

            {{-- Title --}}
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Pendaftaran Diterima!</h2>
            <p class="text-gray-500 text-sm mb-6">Akun Anda telah berhasil dibuat dan sedang menunggu verifikasi</p>

            {{-- Info Box --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-6 text-left">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-yellow-500 text-xl mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h3 class="font-semibold text-yellow-800 mb-1">Proses Verifikasi Akun</h3>
                        <p class="text-yellow-700 text-sm leading-relaxed">
                            Untuk menjaga keamanan sistem, pendaftaran akun baru harus diverifikasi terlebih dahulu 
                            oleh administrator untuk memastikan bahwa Anda adalah karyawan yang sah.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Email Info --}}
            @if(session('registered_email'))
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 mb-6">
                <p class="text-sm text-purple-700">
                    <i class="fas fa-envelope mr-2"></i>
                    Akun terdaftar untuk: <strong>{{ session('registered_email') }}</strong>
                </p>
            </div>
            @endif

            {{-- Steps --}}
            <div class="text-left mb-6">
                <p class="text-sm font-semibold text-gray-600 mb-3">Langkah selanjutnya:</p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <p class="text-sm text-gray-600">Formulir pendaftaran berhasil diisi</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 animate-pulse">
                            <span class="text-white text-xs font-bold">2</span>
                        </div>
                        <p class="text-sm text-gray-700 font-medium">Admin sedang memverifikasi data Anda</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 bg-gray-200 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-gray-400 text-xs font-bold">3</span>
                        </div>
                        <p class="text-sm text-gray-400">Akun diaktifkan → Anda bisa login</p>
                    </div>
                </div>
            </div>

            {{-- Contact Info --}}
            <div class="bg-gray-50 rounded-xl p-4 mb-6 text-sm text-gray-600">
                <i class="fas fa-headset text-purple-500 mr-2"></i>
                Butuh bantuan? Hubungi administrator IT di departemen Anda atau melalui email resmi perusahaan.
            </div>

            {{-- Actions --}}
            <div class="space-y-3">
                <a href="{{ route('login') }}" 
                   class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-purple-800 transition shadow-md">
                    <i class="fas fa-sign-in-alt mr-2"></i>Cek Status & Login
                </a>
                <a href="{{ route('landing') }}" 
                   class="block w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
