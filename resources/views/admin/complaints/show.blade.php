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
                        <label class="text-sm font-semibold text-gray-600">Nama Customer</label>
                        <p class="text-gray-800 font-medium">{{ $complaint->customer_name ?? '-' }}</p>
                    </div>
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
                </div>

                <div class="mb-6">
                    <label class="text-sm font-semibold text-gray-600 block mb-2">Deskripsi Keluhan</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800 whitespace-pre-line">{{ $complaint->description }}</p>
                    </div>
                </div>

                <!-- Bukti Keluhan (Multiple Photos / Videos) -->
                @php
                    $photos = [];
                    if ($complaint->photo) {
                        if (is_array($complaint->photo)) {
                            $photos = $complaint->photo;
                        } else {
                            $decoded = json_decode($complaint->photo, true);
                            if (is_array($decoded)) {
                                $photos = $decoded;
                            } else {
                                $photos = [$complaint->photo];
                            }
                        }
                    }
                @endphp

                @if(count($photos) > 0)
                <div>
                    <label class="text-sm font-semibold text-gray-600 block mb-3">
                        Bukti Keluhan ({{ count($photos) }} file)
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($photos as $path)
                            @php
                                $is_video = in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['mp4', 'mov', 'avi', 'mkv', 'webm']);
                                $file_url = \Illuminate\Support\Facades\Storage::url($path);
                            @endphp
                            <div class="relative rounded-xl overflow-hidden border border-gray-200 aspect-video shadow-md bg-black cursor-pointer group hover:scale-[1.03] hover:shadow-lg transition-all duration-300"
                                 onclick="openLightbox('{{ $file_url }}', {{ $is_video ? 'true' : 'false' }})">
                                
                                @if($is_video)
                                    <video src="{{ $file_url }}" class="w-full h-full object-cover opacity-80 pointer-events-none"></video>
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition-colors">
                                        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-white/90 text-indigo-600 shadow-md transform group-hover:scale-115 transition-all duration-300">
                                            <i class="fas fa-play text-xs ml-0.5"></i>
                                        </span>
                                    </div>
                                @else
                                    <img src="{{ $file_url }}" alt="Bukti" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @endif
                                
                                <div class="absolute bottom-2 left-2 bg-black/60 backdrop-blur-sm text-[10px] text-white font-medium px-2 py-0.5 rounded shadow">
                                    @if($is_video)
                                        <i class="fas fa-video mr-1"></i> Video
                                    @else
                                        <i class="fas fa-image mr-1"></i> Foto
                                    @endif
                                </div>
                                
                                <!-- Hover Overlay with Zoom Icon -->
                                <div class="absolute inset-0 bg-indigo-950/20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300 pointer-events-none">
                                    <i class="fas fa-search-plus text-white text-2xl drop-shadow-md transform scale-75 group-hover:scale-100 transition-transform duration-300"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Admin Response (Read-Only) -->
            @if($complaint->admin_response)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-reply text-indigo-600 mr-2"></i>Respon Admin
                </h3>
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
                    <p class="text-green-700 whitespace-pre-line">{{ $complaint->admin_response }}</p>
                    @if($complaint->resolved_at)
                    <p class="text-xs text-green-600 mt-2">
                        <i class="fas fa-clock mr-1"></i>Diselesaikan pada {{ $complaint->resolved_at->format('d M Y H:i') }}
                    </p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Assigned Solutions (Read-Only) -->
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
                        <i class="fas fa-id-card text-gray-400 w-5"></i>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">NIK Karyawan</p>
                            <p class="text-sm text-gray-800">{{ $complaint->user->nik }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-briefcase text-gray-400 w-5"></i>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Jabatan</p>
                            <p class="text-sm text-gray-800">{{ $complaint->user->jabatan }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-building text-gray-400 w-5"></i>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Departemen</p>
                            <p class="text-sm text-gray-800">{{ $complaint->user->departemen }}</p>
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

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">
                    <i class="fas fa-bolt text-yellow-600 mr-2"></i>Aksi Cepat
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.complaints.edit', $complaint) }}" class="block w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                        <i class="fas fa-edit mr-2"></i>Edit / Proses Keluhan
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
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $complaint->status == 'in_progress' || $complaint->status == 'resolved' || $complaint->status == 'returned' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-800">Diproses</p>
                            <p class="text-xs text-gray-500">
                                @if($complaint->status == 'in_progress' || $complaint->status == 'resolved' || $complaint->status == 'returned')
                                    Sedang ditangani oleh {{ $complaint->assignedAdmin->name ?? 'Admin' }}
                                @else
                                    Menunggu
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $complaint->status == 'resolved' || $complaint->status == 'returned' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
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

                    @if($complaint->returned_at || $complaint->status == 'returned')
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-500 flex items-center justify-center">
                            <i class="fas fa-undo text-white text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-800 text-red-600">Return</p>
                            <p class="text-xs text-gray-500">
                                @if($complaint->returned_at)
                                    {{ $complaint->returned_at->format('d M Y H:i') }}
                                @else
                                    {{ $complaint->updated_at->format('d M Y H:i') }}
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.lightbox')
@endsection