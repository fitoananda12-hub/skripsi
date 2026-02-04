@extends('layouts.user')

@section('title', 'Keluhan Saya')
@section('page-title', 'Keluhan Saya')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Keluhan</h2>
            <p class="text-gray-600">Kelola dan pantau status keluhan Anda</p>
        </div>
        <a href="{{ route('user.complaints.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg">
            <i class="fas fa-plus-circle mr-2"></i>Buat Keluhan Baru
        </a>
    </div>

    <!-- Statistics -->
    <div class="grid md:grid-cols-4 gap-4">
        @php
            $total = auth()->user()->complaints()->count();
            $submitted = auth()->user()->complaints()->where('status', 'submitted')->count();
            $inProgress = auth()->user()->complaints()->where('status', 'in_progress')->count();
            $resolved = auth()->user()->complaints()->where('status', 'resolved')->count();
        @endphp

        <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-blue-500">
            <p class="text-gray-600 text-sm">Total</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $total }}</h3>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-yellow-500">
            <p class="text-gray-600 text-sm">Diajukan</p>
            <h3 class="text-2xl font-bold text-yellow-600">{{ $submitted }}</h3>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-blue-600">
            <p class="text-gray-600 text-sm">Diproses</p>
            <h3 class="text-2xl font-bold text-blue-600">{{ $inProgress }}</h3>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-green-500">
            <p class="text-gray-600 text-sm">Selesai</p>
            <h3 class="text-2xl font-bold text-green-600">{{ $resolved }}</h3>
        </div>
    </div>

    <!-- Complaints Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        @if($complaints->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Keluhan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Masalah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prioritas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($complaints as $complaint)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-800">{{ $complaint->complaint_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-800 font-medium">{{ $complaint->product_name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $complaint->problem_type }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $complaint->getStatusBadgeClass() }}">
                                {{ $complaint->getStatusLabel() }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $complaint->getPriorityBadgeClass() }}">
                                {{ $complaint->getPriorityLabel() }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $complaint->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $complaint->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('user.complaints.show', $complaint) }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $complaints->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Keluhan</h3>
            <p class="text-gray-500 mb-6">Anda belum pernah mengajukan keluhan</p>
            <a href="{{ route('user.complaints.create') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                <i class="fas fa-plus-circle mr-2"></i>Buat Keluhan Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection