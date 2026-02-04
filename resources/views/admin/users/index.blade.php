@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar User</h2>
            <p class="text-gray-600">Kelola akun user yang terdaftar di sistem</p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total User</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</h3>
                </div>
                <i class="fas fa-users text-blue-500 text-4xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">User Aktif</p>
                    <h3 class="text-3xl font-bold text-green-600">{{ $activeUsers }}</h3>
                </div>
                <i class="fas fa-check-circle text-green-500 text-4xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">User Nonaktif</p>
                    <h3 class="text-3xl font-bold text-red-600">{{ $inactiveUsers }}</h3>
                </div>
                <i class="fas fa-ban text-red-500 text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cari User</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                    placeholder="Nama, email, telepon...">
            </div>

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
                <a href="{{ route('admin.users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Telepon</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Total Keluhan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Terdaftar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-700">{{ $user->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-700">{{ $user->phone }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $user->complaints_count }} keluhan
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->is_active)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-ban mr-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-sm font-medium {{ $user->is_active ? 'text-red-600 hover:text-red-700' : 'text-green-600 hover:text-green-700' }}">
                                    @if($user->is_active)
                                        <i class="fas fa-ban mr-1"></i>Nonaktifkan
                                    @else
                                        <i class="fas fa-check mr-1"></i>Aktifkan
                                    @endif
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $users->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak Ada User</h3>
            <p class="text-gray-500">Belum ada user yang terdaftar</p>
        </div>
        @endif
    </div>
</div>
@endsection