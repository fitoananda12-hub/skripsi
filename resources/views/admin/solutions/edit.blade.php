@extends('layouts.admin')

@section('title', 'Edit Solusi')
@section('page-title', 'Edit Solusi')

@section('content')
<div class="max-w-4xl">
    <div class="mb-4">
        <a href="{{ route('admin.solutions.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Knowledge Base
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Solusi</h2>

        <form method="POST" action="{{ route('admin.solutions.update', $solution) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Judul Solusi <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $solution->title) }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('title') border-red-500 @enderror" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Kategori Masalah <span class="text-red-500">*</span></label>
                <select name="problem_category" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($problemCategories as $category)
                        <option value="{{ $category }}" {{ old('problem_category', $solution->problem_category) == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi Solusi <span class="text-red-500">*</span></label>
                <textarea name="solution_description" rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent" required>{{ old('solution_description', $solution->solution_description) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Langkah Teknis</label>
                <textarea name="technical_steps" rows="5" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">{{ old('technical_steps', $solution->technical_steps) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Tips Pencegahan</label>
                <textarea name="prevention_tips" rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">{{ old('prevention_tips', $solution->prevention_tips) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $solution->is_active) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-3">
                    <span class="text-gray-700 font-semibold">Aktifkan solusi ini</span>
                </label>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4 mb-6">
                <p class="text-sm text-yellow-700">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Solusi ini telah digunakan <strong>{{ $solution->usage_count }}x</strong> untuk mengatasi keluhan
                </p>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.solutions.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
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