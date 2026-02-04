@extends('layouts.admin')

@section('title', 'Detail Keluhan')
@section('page-title', 'Detail Keluhan')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <a href="{{ route('admin.complaints.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Keluhan
    </a>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Complaint Details -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $complaint->complaint_number }}</h2>
                        <p class="text-gray-500 text-sm">Diajukan pada {{ $complaint->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $complaint->getStatusBadgeClass() }}">
                            {{ $complaint->getStatusLabel() }}
                        </span>
                        <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $complaint->getPriorityBadgeClass() }}">
                            {{ $complaint->getPriorityLabel() }}
                        </span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Nama Produk</label>
                        <p class="text-gray-800 font-medium">{{ $complaint->product_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Jenis Masalah</label>
                        <p class="text-gray-800 font-medium">{{ $complaint->problem_type }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Tanggal Kejadian</label>
                        <p class="text-gray-800">{{ $complaint->incident_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Ditugaskan Ke</label>
                        <p class="text-gray-800">
                            @if($complaint->assignedAdmin)
                                {{ $complaint->assignedAdmin->name }}
                            @else
                                <span class="text-gray-400 italic">Belum ditugaskan</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="text-sm font-semibold text-gray-600 block mb-2">Deskripsi Keluhan</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800 whitespace-pre-line">{{ $complaint->description }}</p>
                    </div>
                </div>

                @if($complaint->photo)
                <div>
                    <label class="text-sm font-semibold text-gray-600 block mb-2">Foto Produk</label>
                    <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Foto Produk" class="rounded-lg max-h-96 object-cover shadow-md">
                </div>
                @endif
            </div>

            <!-- Admin Response Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-reply text-indigo-600 mr-2"></i>Respon Admin
                </h3>

                @if($complaint->admin_response)
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6">
                    <p class="text-sm font-semibold text-green-800 mb-2">Respon Sebelumnya:</p>
                    <p class="text-green-700 whitespace-pre-line">{{ $complaint->admin_response }}</p>
                    @if($complaint->resolved_at)
                    <p class="text-xs text-green-600 mt-2">
                        <i class="fas fa-clock mr-1"></i>Diselesaikan pada {{ $complaint->resolved_at->format('d M Y H:i') }}
                    </p>
                    @endif
                </div>
                @endif

                <form method="POST" action="{{ route('admin.complaints.respond', $complaint) }}">
                    @csrf
                    @method('PUT')

                    <!-- Admin Response -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Respon / Solusi <span class="text-red-500">*</span></label>
                        <textarea name="admin_response" rows="5" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('admin_response') border-red-500 @enderror"
                            placeholder="Berikan respon dan solusi untuk keluhan ini..." required>{{ old('admin_response', $complaint->admin_response) }}</textarea>
                        @error('admin_response')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Select Solutions -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Pilih Solusi dari Knowledge Base</label>
                        <div class="border border-gray-300 rounded-lg p-4 max-h-48 overflow-y-auto">
                            @foreach($solutions as $solution)
                            <label class="flex items-start p-2 hover:bg-gray-50 rounded cursor-pointer">
                                <input type="checkbox" name="solution_ids[]" value="{{ $solution->id }}" 
                                    {{ $complaint->solutions->contains($solution->id) ? 'checked' : '' }}
                                    class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-800">{{ $solution->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $solution->problem_category }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Status Update -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Update Status <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent" required>
                            <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="resolved">Selesai</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Respon
                    </button>
                </form>
            </div>

            <!-- Assigned Solutions -->
            @if($complaint->solutions->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>Solusi yang Diterapkan
                </h3>
                <div class="space-y-4">
                    @foreach($complaint->solutions as $solution)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">{{ $solution->title }}</h4>
                        <p class="text-sm text-gray-600 mb-3">{{ $solution->solution_description }}</p>
                        
                        @if($solution->technical_steps)
                        <div class="bg-blue-50 rounded p-3 mb-3">
                            <p class="text-xs font-semibold text-blue-800 mb-1">Langkah Teknis:</p>
                            <p class="text-sm text-blue-700 whitespace-pre-line">{{ $solution->technical_steps }}</p>
                        </div>
                        @endif

                        @if($solution->prevention_tips)
                        <div class="bg-green-50 rounded p-3">
                            <p class="text-xs font-semibold text-green-800 mb-1">Tips Pencegahan:</p>
                            <p class="text-sm text-green-700 whitespace-pre-line">{{ $solution->prevention_tips }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- User Info -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">
                    <i class="fas fa-user text-indigo-600 mr-2"></i>Informasi Pelapor
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-semibold text-gray-500">Nama</label>
                        <p class="text-sm text-gray-800 font-medium">{{ $complaint->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500">Email</label>
                        <p class="text-sm text-gray-800">{{ $complaint->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500">Telepon</label>
                        <p class="text-sm text-gray-800">{{ $complaint->user->phone }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500">Alamat</label>
                        <p class="text-sm text-gray-800">{{ $complaint->user->address }}</p>
                    </div>
                </div>
            </div>

            <!-- Assign Admin -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">
                    <i class="fas fa-user-tag text-blue-600 mr-2"></i>Tugaskan ke Admin
                </h3>
                <form method="POST" action="{{ route('admin.complaints.assign', $complaint) }}">
                    @csrf
                    @method('PUT')

                    <select name="assigned_to" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 mb-3" required>
                        <option value="">-- Pilih Admin --</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ $complaint->assigned_to == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                        <i class="fas fa-user-check mr-2"></i>Tugaskan
                    </button>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">
                    <i class="fas fa-bolt text-yellow-600 mr-2"></i>Aksi Cepat
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.complaints.edit', $complaint) }}" class="block w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                        <i class="fas fa-edit mr-2"></i>Edit Keluhan
                    </a>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">Timeline Status</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-500 flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-800">Diajukan</p>
                            <p class="text-xs text-gray-500">{{ $complaint->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $complaint->status == 'in_progress' || $complaint->status == 'resolved' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-800">Diproses</p>
                            <p class="text-xs text-gray-500">
                                @if($complaint->status == 'in_progress' || $complaint->status == 'resolved')
                                    Sedang ditangani oleh {{ $complaint->assignedAdmin->name ?? 'Admin' }}
                                @else
                                    Menunggu
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $complaint->status == 'resolved' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-800">Selesai</p>
                            <p class="text-xs text-gray-500">
                                @if($complaint->resolved_at)
                                    {{ $complaint->resolved_at->format('d M Y H:i') }}
                                @else
                                    Menunggu
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- User Info -->
            <div class="bg-gradient-to-br from-indigo-50 to-white rounded-xl shadow-md p-6 border border-indigo-100">
                <h3 class="font-bold text-gray-800 mb-4">
                    <i class="fas fa-user text-indigo-600 mr-2"></i>Informasi Pelapor
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-user text-gray-400 w-5"></i>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Nama</p>
                            <p class="text-sm text-gray-800 font-medium">{{ $complaint->user->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-gray-400 w-5"></i>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="text-sm text-gray-800">{{ $complaint->user->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone text-gray-400 w-5"></i>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Telepon</p>
                            <p class="text-sm text-gray-800">{{ $complaint->user->phone }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-gray-400 w-5 mt-1"></i>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Alamat</p>
                            <p class="text-sm text-gray-800">{{ $complaint->user->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection