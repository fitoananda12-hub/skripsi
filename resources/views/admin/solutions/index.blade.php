@extends('layouts.admin')

@section('title', 'Knowledge Base')
@section('page-title', 'Knowledge Base Solusi')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Solusi</h2>
            <p class="text-gray-600">Kelola database solusi untuk keluhan produk</p>
        </div>
        <a href="{{ route('admin.solutions.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg">
            <i class="fas fa-plus-circle mr-2"></i>Tambah Solusi Baru
        </a>
    </div>

    <!-- Statistics -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Solusi</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalSolutions }}</h3>
                </div>
                <i class="fas fa-lightbulb text-green-500 text-4xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Solusi Aktif</p>
                    <h3 class="text-3xl font-bold text-blue-600">{{ $activeSolutions }}</h3>
                </div>
                <i class="fas fa-check-circle text-blue-500 text-4xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Penggunaan</p>
                    <h3 class="text-3xl font-bold text-purple-600">{{ $totalUsage }}</h3>
                </div>
                <i class="fas fa-chart-line text-purple-500 text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <form method="GET" action="{{ route('admin.solutions.index') }}" class="grid md:grid-cols-3 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Solusi</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                    placeholder="Judul, kategori, deskripsi...">
            </div>

            <!-- Status Filter -->
            <div class="flex items-end gap-2">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="is_active" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-search"></i>
                </button>
                <a href="{{ route('admin.solutions.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Solutions Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        @if($solutions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Judul Solusi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Penggunaan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Dibuat Oleh</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($solutions as $solution)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-800">{{ $solution->title }}</p>
                            <p class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($solution->solution_description, 80) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $solution->problem_category }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <i class="fas fa-chart-bar text-purple-500 mr-2"></i>
                                <span class="font-semibold text-gray-800">{{ $solution->usage_count }}x</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($solution->is_active)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-700">{{ $solution->creator->name }}</p>
                            <p class="text-xs text-gray-500">{{ $solution->created_at->format('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.solutions.show', $solution) }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.solutions.edit', $solution) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.solutions.destroy', $solution) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus solusi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $solutions->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <i class="fas fa-lightbulb text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Solusi</h3>
            <p class="text-gray-500 mb-6">Mulai membangun knowledge base dengan menambahkan solusi</p>
            <a href="{{ route('admin.solutions.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                <i class="fas fa-plus-circle mr-2"></i>Tambah Solusi Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection