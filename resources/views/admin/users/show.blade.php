@extends('layouts.admin')

@section('title', 'Detail User - ' . $user->name)
@section('page-title', 'Detail User')

@section('content')
<div class="space-y-6">

    {{-- Back Button --}}
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 font-medium">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar User
    </a>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
        <i class="fas fa-check-circle text-green-500 text-xl"></i>
        <p class="text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid md:grid-cols-3 gap-6">

        {{-- Profile Card --}}
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold text-white
                    {{ $user->isPending() ? 'bg-yellow-400' : ($user->isApproved() ? 'bg-purple-500' : 'bg-red-400') }}">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                <p class="text-gray-500 text-sm mt-1">{{ $user->jabatan ?? '-' }} • {{ $user->departemen ?? '-' }}</p>

                <div class="mt-4 space-y-2">
                    {{-- Status Verifikasi --}}
                    @if($user->isPending())
                        <span class="inline-block px-4 py-2 bg-yellow-100 text-yellow-800 text-sm font-bold rounded-full border border-yellow-300">
                            <i class="fas fa-hourglass-half mr-1 animate-pulse"></i> Menunggu Verifikasi
                        </span>
                    @elseif($user->isApproved())
                        <span class="inline-block px-4 py-2 bg-green-100 text-green-800 text-sm font-bold rounded-full">
                            <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                        </span>
                    @else
                        <span class="inline-block px-4 py-2 bg-red-100 text-red-800 text-sm font-bold rounded-full">
                            <i class="fas fa-times-circle mr-1"></i> Ditolak
                        </span>
                    @endif
                </div>

                {{-- Action Buttons --}}
                <div class="mt-6 space-y-2">
                    @if($user->isPending())
                    <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                        @csrf @method('PUT')
                        <button type="submit"
                            onclick="return confirm('Setujui pendaftaran {{ $user->name }}?')"
                            class="w-full bg-green-500 hover:bg-green-600 text-white py-2.5 rounded-lg font-semibold transition">
                            <i class="fas fa-check mr-2"></i>Setujui Pendaftaran
                        </button>
                    </form>
                    <button onclick="document.getElementById('rejectSection').scrollIntoView({behavior:'smooth'})"
                        class="w-full bg-red-500 hover:bg-red-600 text-white py-2.5 rounded-lg font-semibold transition">
                        <i class="fas fa-times mr-2"></i>Tolak Pendaftaran
                    </button>
                    @endif

                    @if($user->isApproved())
                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                        @csrf @method('PUT')
                        <button type="submit"
                            class="w-full py-2.5 rounded-lg font-semibold transition border
                                {{ $user->is_active 
                                    ? 'border-red-300 text-red-600 hover:bg-red-50' 
                                    : 'border-green-300 text-green-600 hover:bg-green-50' }}">
                            @if($user->is_active)
                                <i class="fas fa-ban mr-2"></i>Nonaktifkan Akun
                            @else
                                <i class="fas fa-check mr-2"></i>Aktifkan Akun
                            @endif
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Detail Info --}}
        <div class="md:col-span-2 space-y-6">

            {{-- Data Karyawan --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-id-card text-purple-500"></i> Data Karyawan
                </h3>
                <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                    <div>
                        <p class="text-gray-500 font-medium">NIK Karyawan</p>
                        <p class="text-gray-800 font-mono font-semibold mt-0.5">{{ $user->nik ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium">Jabatan</p>
                        <p class="text-gray-800 font-semibold mt-0.5">{{ $user->jabatan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium">Departemen</p>
                        <p class="text-gray-800 font-semibold mt-0.5">{{ $user->departemen ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium">Nomor Telepon</p>
                        <p class="text-gray-800 font-semibold mt-0.5">{{ $user->phone ?? '-' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500 font-medium">Alamat</p>
                        <p class="text-gray-800 font-semibold mt-0.5">{{ $user->address ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Riwayat Verifikasi --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-history text-blue-500"></i> Riwayat Verifikasi
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal Daftar</span>
                        <span class="font-semibold">{{ $user->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($user->approved_at)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal Disetujui</span>
                        <span class="font-semibold text-green-600">{{ $user->approved_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                    @if($user->approvedBy)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Disetujui oleh</span>
                        <span class="font-semibold">{{ $user->approvedBy->name }}</span>
                    </div>
                    @endif
                    @if($user->rejection_reason)
                    <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-700 font-semibold text-xs uppercase tracking-wider mb-1">Alasan Penolakan:</p>
                        <p class="text-red-600">{{ $user->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Statistik Keluhan --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-indigo-500"></i> Statistik Keluhan
                </h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="bg-blue-50 rounded-lg p-3">
                        <p class="text-2xl font-bold text-blue-600">{{ $user->complaints->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Total</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3">
                        <p class="text-2xl font-bold text-green-600">{{ $user->complaints->where('status', 'resolved')->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Selesai</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-3">
                        <p class="text-2xl font-bold text-yellow-600">{{ $user->complaints->whereIn('status', ['pending', 'in_progress'])->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Proses</p>
                    </div>
                </div>
            </div>

            {{-- Form Tolak (jika pending) --}}
            @if($user->isPending())
            <div id="rejectSection" class="bg-red-50 border-2 border-red-200 rounded-xl p-6">
                <h3 class="text-lg font-bold text-red-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-times-circle text-red-500"></i> Tolak Pendaftaran
                </h3>
                <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alasan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="rejection_reason" rows="3" required
                            class="w-full px-4 py-3 border border-red-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-transparent resize-none"
                            placeholder="Jelaskan alasan penolakan pendaftaran ini...">{{ old('rejection_reason') }}</textarea>
                        @error('rejection_reason')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        onclick="return confirm('Yakin ingin menolak pendaftaran ini?')"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded-lg font-semibold transition">
                        <i class="fas fa-times mr-2"></i>Konfirmasi Penolakan
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
