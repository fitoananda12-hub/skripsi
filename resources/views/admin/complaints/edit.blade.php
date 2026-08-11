@extends('layouts.admin')

@section('title', 'Edit Keluhan')
@section('page-title', 'Edit Keluhan')

@section('content')
<div class="max-w-4xl">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.complaints.show', $complaint) }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Detail
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Keluhan: {{ $complaint->complaint_number }}</h2>

        <form method="POST" action="{{ route('admin.complaints.update', $complaint) }}">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Status -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Update Status <span class="text-red-500">*</span></label>
                    <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('status') border-red-500 @enderror" required>
                        <option value="submitted" {{ $complaint->status == 'submitted' ? 'selected' : '' }}>Diajukan</option>
                        <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                        <option value="returned" {{ $complaint->status == 'returned' ? 'selected' : '' }}>Return </option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Prioritas <span class="text-red-500">*</span></label>
                    <select name="priority" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('priority') border-red-500 @enderror" required>
                        <option value="low" {{ $complaint->priority == 'low' ? 'selected' : '' }}>Rendah</option>
                        <option value="medium" {{ $complaint->priority == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="high" {{ $complaint->priority == 'high' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                    @error('priority')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Admin Response -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Respon Admin <span class="text-red-500">*</span></label>
                    <textarea name="admin_response" rows="5" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('admin_response') border-red-500 @enderror"
                        placeholder="Berikan respon dan solusi untuk keluhan ini...">{{ old('admin_response', $complaint->admin_response) }}</textarea>
                    @error('admin_response')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Knowledge Base Solutions -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Pilih Solusi dari Knowledge Base</label>
                    <div class="border border-gray-300 rounded-lg p-4 max-h-48 overflow-y-auto">
                        @forelse($solutions as $solution)
                        <label class="flex items-start p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="solution_ids[]" value="{{ $solution->id }}" 
                                {{ $complaint->solutions->contains($solution->id) ? 'checked' : '' }}
                                class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-800">{{ $solution->title }}</p>
                                <p class="text-xs text-gray-500">{{ $solution->problem_category }}</p>
                            </div>
                        </label>
                        @empty
                        <p class="text-sm text-gray-400 italic">Belum ada solusi di Knowledge Base</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 my-6">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                    <div>
                        <h4 class="font-semibold text-blue-800 mb-1">Informasi</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Status "Selesai" akan otomatis set waktu penyelesaian</li>
                            <li>• Pastikan respon admin sudah diisi sebelum menyelesaikan</li>
                            <li>• Pilih solusi dari Knowledge Base yang relevan dengan keluhan</li>
                            <li>• User akan menerima notifikasi update status</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between">
                <a href="{{ route('admin.complaints.show', $complaint) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold transition shadow-lg">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection