@extends('layouts.user')

@section('title', 'Detail Keluhan')
@section('page-title', 'Detail Keluhan')

@section('content')
<div class="max-w-5xl">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('user.complaints.index') }}" class="text-purple-600 hover:text-purple-700 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Keluhan
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="md:col-span-2 space-y-6">
            <!-- Complaint Details -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-6">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $complaint->complaint_number }}</h2>
                        <p class="text-gray-500 text-sm">Diajukan pada {{ $complaint->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $complaint->getStatusBadgeClass() }}">
                            {{ $complaint->getStatusLabel() }}
                        </span>
                        <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $complaint->getPriorityBadgeClass() }}">
                            {{ $complaint->getPriorityLabel() }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Customer Name -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Nama Customer</label>
                        <p class="text-gray-800 font-medium">{{ $complaint->customer_name ?? '-' }}</p>
                    </div>

                    <!-- Product Name -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Nama Produk</label>
                        <p class="text-gray-800 font-medium">{{ $complaint->product_name }}</p>
                    </div>

                    <!-- Problem Type -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Jenis Masalah</label>
                        <p class="text-gray-800 font-medium">{{ $complaint->problem_type }}</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Deskripsi Keluhan</label>
                        <p class="text-gray-800 whitespace-pre-line">{{ $complaint->description }}</p>
                    </div>

                    <!-- Incident Date -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Tanggal Kejadian</label>
                        <p class="text-gray-800">{{ $complaint->incident_date->format('d M Y') }}</p>
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
                                            <span class="w-10 h-10 flex items-center justify-center rounded-full bg-white/90 text-purple-600 shadow-md transform group-hover:scale-115 transition-all duration-300">
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
                                    <div class="absolute inset-0 bg-purple-950/20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300 pointer-events-none">
                                        <i class="fas fa-search-plus text-white text-2xl drop-shadow-md transform scale-75 group-hover:scale-100 transition-transform duration-300"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Admin Response -->
            @if($complaint->admin_response)
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6">
                <h3 class="font-bold text-green-800 mb-3 flex items-center">
                    <i class="fas fa-reply mr-2"></i>Respon dari Admin
                </h3>
                <div class="bg-white rounded-lg p-4 mb-3">
                    <p class="text-gray-800 whitespace-pre-line">{{ $complaint->admin_response }}</p>
                </div>
                @if($complaint->assignedAdmin)
                <p class="text-sm text-green-700">
                    <i class="fas fa-user mr-1"></i>
                    Ditangani oleh: <strong>{{ $complaint->assignedAdmin->name }}</strong>
                </p>
                @endif
                @if($complaint->resolved_at)
                <p class="text-sm text-green-700">
                    <i class="fas fa-check-circle mr-1"></i>
                    Diselesaikan pada: <strong>{{ $complaint->resolved_at->format('d M Y H:i') }}</strong>
                </p>
                @endif
            </div>
            @endif

            <!-- Solutions -->
            @if($complaint->solutions->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>Solusi yang Diberikan
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
            <!-- Status Timeline -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">Status Timeline</h3>
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
                                    Sedang ditangani
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

            <!-- Info Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <h4 class="font-bold text-blue-800 mb-3">
                    <i class="fas fa-info-circle mr-2"></i>Informasi
                </h4>
                <ul class="space-y-2 text-sm text-blue-700">
                    <li>• Status keluhan akan diupdate secara berkala</li>
                    <li>• Anda akan menerima notifikasi untuk setiap perubahan</li>
                    <li>• Tim kami bekerja untuk menyelesaikan keluhan Anda</li>
                </ul>
            </div>

            <!-- Contact Support -->
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                <h4 class="font-bold text-purple-800 mb-3">
                    <i class="fas fa-headset mr-2"></i>Butuh Bantuan?
                </h4>
                <p class="text-sm text-purple-700 mb-3">Hubungi tim customer service kami</p>
                <div class="space-y-2 text-sm text-purple-700">
                    <p><i class="fas fa-envelope mr-2"></i>cs@esabumindo.com</p>
                    <p><i class="fas fa-phone mr-2"></i>(021) 1234-5678</p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.lightbox')
@endsection