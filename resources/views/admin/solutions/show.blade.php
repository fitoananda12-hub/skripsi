@extends('layouts.admin')

@section('title', 'Detail Solusi')
@section('page-title', 'Detail Solusi')

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.solutions.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Knowledge Base
    </a>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-md p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $solution->title }}</h2>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $solution->problem_category }}
                        </span>
                    </div>
                    @if($solution->is_active)
                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                    @else
                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                            <i class="fas fa-times-circle mr-1"></i>Nonaktif
                        </span>
                    @endif
                </div>

                <div class="space-y-6">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Deskripsi Solusi</h3>
                        <p class="text-gray-800 leading-relaxed">{{ $solution->solution_description }}</p>
                    </div>

                    @if($solution->technical_steps)
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h3 class="font-semibold text-blue-800 mb-3">
                            <i class="fas fa-list-ol mr-2"></i>Langkah Teknis
                        </h3>
                        <p class="text-blue-700 whitespace-pre-line">{{ $solution->technical_steps }}</p>
                    </div>
                    @endif

                    @if($solution->prevention_tips)
                    <div class="bg-green-50 rounded-lg p-4">
                        <h3 class="font-semibold text-green-800 mb-3">
                            <i class="fas fa-shield-alt mr-2"></i>Tips Pencegahan
                        </h3>
                        <p class="text-green-700 whitespace-pre-line">{{ $solution->prevention_tips }}</p>
                    </div>
                    @endif
                </div>
            </div>

            @if($solution->complaints->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-link text-purple-600 mr-2"></i>Keluhan Terkait ({{ $solution->complaints->count() }})
                </h3>
                <div class="space-y-2">
                    @foreach($solution->complaints->take(10) as $complaint)
                    <a href="{{ route('admin.complaints.show', $complaint) }}" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $complaint->complaint_number }}</p>
                                <p class="text-sm text-gray-600">{{ $complaint->product_name }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded {{ $complaint->getStatusBadgeClass() }}">
                                {{ $complaint->getStatusLabel() }}
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">Statistik Penggunaan</h3>
                <div class="space-y-4">
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <p class="text-sm text-purple-700">Total Penggunaan</p>
                        <p class="text-4xl font-bold text-purple-600">{{ $solution->usage_count }}x</p>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-700">Keluhan Terkait</p>
                        <p class="text-4xl font-bold text-blue-600">{{ $solution->complaints->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">Informasi</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-500">Dibuat oleh</p>
                        <p class="text-gray-800 font-medium">{{ $solution->creator->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Dibuat pada</p>
                        <p class="text-gray-800">{{ $solution->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Terakhir diupdate</p>
                        <p class="text-gray-800">{{ $solution->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">Aksi</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.solutions.edit', $solution) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition text-center">
                        <i class="fas fa-edit mr-2"></i>Edit Solusi
                    </a>
                    <form method="POST" action="{{ route('admin.solutions.destroy', $solution) }}" onsubmit="return confirm('Yakin ingin menghapus solusi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                            <i class="fas fa-trash mr-2"></i>Hapus Solusi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection