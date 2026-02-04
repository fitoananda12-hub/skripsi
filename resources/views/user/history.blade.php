@extends('layouts.user')

@section('title', 'Riwayat Keluhan')
@section('page-title', 'Riwayat Keluhan')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid md:grid-cols-5 gap-4">
        <div class="bg-white rounded-lg p-4 shadow-md {{ !request('status') ? 'ring-2 ring-purple-500' : '' }}">
            <a href="{{ route('user.history') }}" class="block">
                <p class="text-gray-600 text-sm">Semua</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $statusCounts['all'] }}</h3>
            </a>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md {{ request('status') == 'submitted' ? 'ring-2 ring-yellow-500' : '' }}">
            <a href="{{ route('user.history', ['status' => 'submitted']) }}" class="block">
                <p class="text-gray-600 text-sm">Diajukan</p>
                <h3 class="text-2xl font-bold text-yellow-600">{{ $statusCounts['submitted'] }}</h3>
            </a>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md {{ request('status') == 'in_progress' ? 'ring-2 ring-blue-500' : '' }}">
            <a href="{{ route('user.history', ['status' => 'in_progress']) }}" class="block">
                <p class="text-gray-600 text-sm">Diproses</p>
                <h3 class="text-2xl font-bold text-blue-600">{{ $statusCounts['in_progress'] }}</h3>
            </a>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md {{ request('status') == 'resolved' ? 'ring-2 ring-green-500' : '' }}">
            <a href="{{ route('user.history', ['status' => 'resolved']) }}" class="block">
                <p class="text-gray-600 text-sm">Selesai</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $statusCounts['resolved'] }}</h3>
            </a>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md {{ request('status') == 'closed' ? 'ring-2 ring-gray-500' : '' }}">
            <a href="{{ route('user.history', ['status' => 'closed']) }}" class="block">
                <p class="text-gray-600 text-sm">Ditutup</p>
                <h3 class="text-2xl font-bold text-gray-600">{{ $statusCounts['closed'] }}</h3>
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <form method="GET" action="{{ route('user.history') }}" class="grid md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                    placeholder="No. keluhan, produk...">
            </div>

            <!-- Date From -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
            </div>

            <!-- Date To -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
            </div>

            <!-- Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('user.history') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- History Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        @if($complaints->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No. Keluhan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Masalah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Diselesaikan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
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
                            <p class="text-sm text-gray-600">{{ $complaint->created_at->format('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($complaint->resolved_at)
                                <p class="text-sm text-green-600 font-medium">{{ $complaint->resolved_at->format('d M Y') }}</p>
                            @else
                                <p class="text-sm text-gray-400">-</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('user.complaints.show', $complaint) }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                <i class="fas fa-eye mr-1"></i>Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $complaints->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak Ada Hasil</h3>
            <p class="text-gray-500 mb-6">Tidak ditemukan riwayat keluhan dengan filter yang dipilih</p>
            <a href="{{ route('user.history') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                Reset Filter
            </a>
        </div>
        @endif
    </div>
</div>
@endsection