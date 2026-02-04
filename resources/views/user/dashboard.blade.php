@extends('layouts.user')

@section('title', 'Dashboard User')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-2xl p-8 text-white shadow-xl">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p class="text-purple-100">Kelola keluhan produk Anda dengan mudah melalui dashboard ini</p>
    </div>

    <!-- Statistics -->
    <div class="grid md:grid-cols-4 gap-6">
        @php
            $totalComplaints = auth()->user()->complaints()->count();
            $submittedComplaints = auth()->user()->complaints()->where('status', 'submitted')->count();
            $inProgressComplaints = auth()->user()->complaints()->where('status', 'in_progress')->count();
            $resolvedComplaints = auth()->user()->complaints()->where('status', 'resolved')->count();
        @endphp

        <div class="bg-white rounded-xl p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Keluhan</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalComplaints }}</h3>
                </div>
                <div class="bg-blue-100 p-4 rounded-lg">
                    <i class="fas fa-file-alt text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Diajukan</p>
                    <h3 class="text-3xl font-bold text-yellow-600 mt-1">{{ $submittedComplaints }}</h3>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Diproses</p>
                    <h3 class="text-3xl font-bold text-blue-600 mt-1">{{ $inProgressComplaints }}</h3>
                </div>
                <div class="bg-blue-100 p-4 rounded-lg">
                    <i class="fas fa-spinner text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Selesai</p>
                    <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $resolvedComplaints }}</h3>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-plus-circle text-purple-600 mr-2"></i>Ajukan Keluhan Baru
            </h3>
            <p class="text-gray-600 mb-4">Laporkan masalah produk yang Anda alami dengan mengisi form keluhan</p>
            <a href="{{ route('user.complaints.create') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                <i class="fas fa-edit mr-2"></i>Buat Keluhan
            </a>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-history text-blue-600 mr-2"></i>Lihat Riwayat
            </h3>
            <p class="text-gray-600 mb-4">Akses semua keluhan yang pernah Anda ajukan beserta statusnya</p>
            <a href="{{ route('user.history') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                <i class="fas fa-list mr-2"></i>Lihat Riwayat
            </a>
        </div>
    </div>

    <!-- Recent Complaints -->
    <div class="bg-white rounded-xl p-6 shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-clock text-gray-600 mr-2"></i>Keluhan Terbaru
        </h3>

        @php
            $recentComplaints = auth()->user()->complaints()->latest()->limit(5)->get();
        @endphp

        @if($recentComplaints->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No. Keluhan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Masalah</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentComplaints as $complaint)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $complaint->complaint_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $complaint->product_name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $complaint->problem_type }}</td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $complaint->getStatusBadgeClass() }}">
                                    {{ $complaint->getStatusLabel() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $complaint->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('user.complaints.show', $complaint) }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                    <i class="fas fa-eye mr-1"></i>Lihat
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500">Belum ada keluhan yang diajukan</p>
                <a href="{{ route('user.complaints.create') }}" class="inline-block mt-4 text-purple-600 hover:text-purple-700 font-semibold">
                    Buat keluhan pertama Anda <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @endif
    </div>

    <!-- Info Cards -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 text-2xl mr-4 mt-1"></i>
                <div>
                    <h4 class="font-bold text-blue-800 mb-2">Cara Mengajukan Keluhan</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>1. Klik "Buat Keluhan" di menu Keluhan Saya</li>
                        <li>2. Isi form dengan detail lengkap</li>
                        <li>3. Upload foto produk (opsional)</li>
                        <li>4. Submit dan tunggu respon dari admin</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6">
            <div class="flex items-start">
                <i class="fas fa-clock text-green-500 text-2xl mr-4 mt-1"></i>
                <div>
                    <h4 class="font-bold text-green-800 mb-2">Waktu Respon</h4>
                    <p class="text-sm text-green-700 mb-2">Tim kami berkomitmen untuk:</p>
                    <ul class="text-sm text-green-700 space-y-1">
                        <li>• Respon awal dalam 2 jam</li>
                        <li>• Penyelesaian dalam 24-48 jam</li>
                        <li>• Update status secara berkala</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection