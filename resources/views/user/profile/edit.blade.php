@extends('layouts.user')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('content')
<div class="max-w-4xl">
    <div class="grid md:grid-cols-3 gap-6">
        <!-- Profile Info Card -->
        <div class="bg-white rounded-xl shadow-md p-6 text-center">
            <div class="mb-4">
                <div class="w-24 h-24 bg-purple-100 rounded-full mx-auto flex items-center justify-center">
                    <i class="fas fa-user text-purple-600 text-4xl"></i>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
            <p class="text-gray-500 text-sm">{{ $user->email }}</p>
            <div class="mt-4 pt-4 border-t border-gray-200 space-y-2">
                <div class="text-left">
                    <p class="text-xs text-gray-500">NIK</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $user->nik }}</p>
                </div>
                <div class="text-left">
                    <p class="text-xs text-gray-500">Jabatan</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $user->jabatan }}</p>
                </div>
                <div class="text-left">
                    <p class="text-xs text-gray-500">Departemen</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $user->departemen }}</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600 mb-1">Member sejak</p>
                <p class="text-sm font-semibold text-gray-800">{{ $user->created_at->format('d M Y') }}</p>
            </div>
            <div class="mt-4">
                <p class="text-sm text-gray-600 mb-1">Total Keluhan</p>
                <p class="text-2xl font-bold text-purple-600">{{ $user->complaints()->count() }}</p>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="md:col-span-2 space-y-6">
            <!-- Profile Information -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Informasi Profil</h3>
                
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('name') border-red-500 @enderror" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('email') border-red-500 @enderror" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">NIK Karyawan</label>
                        <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('nik') border-red-500 @enderror" required>
                        @error('nik')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jabatan -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('jabatan') border-red-500 @enderror" required>
                        @error('jabatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Departemen -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Departemen</label>
                        <input type="text" name="departemen" value="{{ old('departemen', $user->departemen) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('departemen') border-red-500 @enderror" required>
                        @error('departemen')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('phone') border-red-500 @enderror" required>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Alamat</label>
                        <textarea name="address" rows="3" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('address') border-red-500 @enderror" required>{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Ubah Password</h3>
                
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Hidden fields untuk profil -->
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="nik" value="{{ $user->nik }}">
                    <input type="hidden" name="jabatan" value="{{ $user->jabatan }}">
                    <input type="hidden" name="departemen" value="{{ $user->departemen }}">
                    <input type="hidden" name="phone" value="{{ $user->phone }}">
                    <input type="hidden" name="address" value="{{ $user->address }}">

                    <!-- Current Password -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Password Lama</label>
                        <input type="password" name="current_password" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Password Baru</label>
                        <input type="password" name="new_password" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('new_password') border-red-500 @enderror">
                        @error('new_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">Minimal 8 karakter</p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mr-3 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-yellow-800 mb-1">Perhatian</h4>
                                <p class="text-sm text-yellow-700">Pastikan Anda mengingat password baru. Password lama tidak dapat dikembalikan.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-key mr-2"></i>Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection