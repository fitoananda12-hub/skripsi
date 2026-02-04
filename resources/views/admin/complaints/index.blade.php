@extends('layouts.admin')

@section('title', 'Manajemen Keluhan')
@section('page-title', 'Manajemen Keluhan')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid md:grid-cols-5 gap-4">
        <div class="bg-white rounded-lg p-4 shadow-md {{ !request('status') ? 'ring-2 ring-indigo-500' : '' }}">
            <a href="{{ route('admin.complaints.index') }}" class="block">
                <p class="text-gray-600 text-sm">Semua</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $statusCounts['all'] }}</h3>
            </a>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md {{ request('status') == 'submitted' ? 'ring-2 ring-yellow-500' : '' }}">
            <a href="{{ route('admin.complaints.index', ['status' => 'submitted']) }}" class="block">
                <p class="text-gray-600 text-sm">Diajukan</p>
                <h3 class="text-2xl font-bold text-yellow-600">{{ $statusCounts['submitted'] }}</h3>
            </a>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md {{ request('status') == 'in_progress' ? 'ring-2 ring-blue-500' : '' }}">
            <a href="{{ route('admin.complaints.index', ['status' => 'in_progress']) }}" class="block">
                <p class="text-gray-600 text-sm">Diproses</p>
                <h3 class="text-2xl font-bold text-blue-600">{{ $statusCounts['in_progress'] }}</h3>
            </a>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md {{ request('status') == 'resolved' ? 'ring-2 ring-green-500' : '' }}">
            <a href="{{ route('admin.complaints.index', ['status' => 'resolved']) }}" class="block">
                <p class="text-gray-600 text-sm">Selesai</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $statusCounts['resolved'] }}</h3>
            </a>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-md {{ request('status') == 'closed' ? 'ring-2 ring-gray-500' : '' }}">
            <a href="{{ route('admin.complaints.index', ['status' => 'closed']) }}" class="block">
                <p class="text-gray-600 text-sm">Ditutup</p>
                <h3 class="text-2xl font-bold text-gray-600">{{ $statusCounts['closed'] }}</h3>
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <form method="GET" action="{{ route('admin.complaints.index') }}" class="grid md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                    placeholder="No. keluhan, produk, user...">
            </div>

            <!-- Priority Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Prioritas</label>
                <select name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                    <option value="">Semua Prioritas</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                </select>
            </div>

            <!-- Assigned Admin Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ditugaskan Ke</label>
                <select name="assigned_to" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                    <option value="">Semua Admin</option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}" {{ request('assigned_to') == $admin->id ? 'selected' : '' }}>
                            {{ $admin->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.complaints.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Complaints Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        @if($complaints->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No. Keluhan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Masalah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Prioritas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Ditugaskan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
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
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $complaint->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $complaint->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-800">{{ $complaint->product_name }}</p>
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
                            @if($complaint->assignedAdmin)
                                <p class="text-sm text-gray-700">{{ $complaint->assignedAdmin->name }}</p>
                            @else
                                <p class="text-sm text-gray-400 italic">Belum ditugaskan</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $complaint->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $complaint->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.complaints.show', $complaint) }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.complaints.edit', $complaint) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
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
            <p class="text-gray-500">Tidak ditemukan keluhan dengan filter yang dipilih</p>
        </div>
        @endif
    </div>
</div>
@endsection