@extends('layouts.admin')

@section('title', 'Tambah Solusi')
@section('page-title', 'Tambah Solusi Baru')

@section('content')
<div class="max-w-4xl">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.solutions.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Knowledge Base
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Tambah Solusi ke Knowledge Base</h2>
            <p class="text-gray-600">Lengkapi form untuk menambahkan solusi baru yang dapat digunakan untuk mengatasi keluhan</p>
        </div>

        <form method="POST" action="{{ route('admin.solutions.store') }}">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Judul Solusi <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('title') border-red-500 @enderror"
                    placeholder="Contoh: Solusi Lem Tidak Merekat" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Problem Category -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Kategori Masalah <span class="text-red-500">*</span></label>
                <select name="problem_category" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('problem_category') border-red-500 @enderror" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($problemCategories as $category)
                        <option value="{{ $category }}" {{ old('problem_category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                @error('problem_category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Solution Description -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi Solusi <span class="text-red-500">*</span></label>
                <textarea name="solution_description" rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('solution_description') border-red-500 @enderror"
                    placeholder="Jelaskan solusi secara singkat dan jelas..." required>{{ old('solution_description') }}</textarea>
                @error('solution_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Technical Steps -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Langkah Teknis (Opsional)</label>
                <textarea name="technical_steps" rows="5" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('technical_steps') border-red-500 @enderror"
                    placeholder="1. Langkah pertama&#10;2. Langkah kedua&#10;3. Langkah ketiga&#10;...">{{ old('technical_steps') }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Pisahkan setiap langkah dengan enter (baris baru)</p>
                @error('technical_steps')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prevention Tips -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Tips Pencegahan (Opsional)</label>
                <textarea name="prevention_tips" rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('prevention_tips') border-red-500 @enderror"
                    placeholder="- Tip pertama&#10;- Tip kedua&#10;- Tip ketiga&#10;...">{{ old('prevention_tips') }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Berikan tips untuk mencegah masalah serupa di masa depan</p>
                @error('prevention_tips')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-3">
                    <span class="text-gray-700 font-semibold">Aktifkan solusi ini</span>
                </label>
                <p class="text-sm text-gray-500 mt-1 ml-7">Solusi aktif dapat langsung digunakan untuk mengatasi keluhan</p>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                    <div>
                        <h4 class="font-semibold text-blue-800 mb-1">Tips Membuat Solusi yang Baik</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Gunakan bahasa yang mudah dipahami</li>
                            <li>• Berikan langkah-langkah yang jelas dan berurutan</li>
                            <li>• Sertakan tips pencegahan untuk menghindari masalah serupa</li>
                            <li>• Update solusi jika ada perubahan atau perbaikan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between">
                <a href="{{ route('admin.solutions.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold transition shadow-lg">
                    <i class="fas fa-save mr-2"></i>Simpan Solusi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection