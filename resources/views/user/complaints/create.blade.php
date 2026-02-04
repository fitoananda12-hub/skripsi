@extends('layouts.user')

@section('title', 'Ajukan Keluhan')
@section('page-title', 'Ajukan Keluhan Baru')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-md p-8">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Form Keluhan Produk</h2>
            <p class="text-gray-600">Lengkapi form di bawah ini dengan detail masalah produk yang Anda alami</p>
        </div>

        <!-- Form -->
        <form action="{{ route('user.complaints.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" name="product_name" value="{{ old('product_name') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('product_name') border-red-500 @enderror"
                    placeholder="Contoh: Super Glue 50ml" required>
                @error('product_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Problem Type -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Jenis Masalah <span class="text-red-500">*</span>
                </label>
                <select name="problem_type" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('problem_type') border-red-500 @enderror" required>
                    <option value="">-- Pilih Jenis Masalah --</option>
                    @foreach($problemTypes as $type)
                        <option value="{{ $type }}" {{ old('problem_type') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
                @error('problem_type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Deskripsi Keluhan <span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="5" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('description') border-red-500 @enderror"
                    placeholder="Jelaskan masalah yang Anda alami secara detail..." required>{{ old('description') }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Semakin detail informasi yang Anda berikan, semakin cepat kami dapat membantu</p>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo Upload -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Foto Produk (Opsional)
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <input type="file" name="photo" id="photo" accept="image/*" class="hidden" onchange="previewImage(event)">
                    <div id="preview-container" class="hidden mb-4">
                        <img id="preview" class="mx-auto max-h-48 rounded-lg">
                    </div>
                    <label for="photo" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Klik untuk upload foto atau drag & drop</p>
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Max 2MB)</p>
                    </label>
                </div>
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Incident Date -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Tanggal Kejadian <span class="text-red-500">*</span>
                </label>
                <input type="date" name="incident_date" value="{{ old('incident_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('incident_date') border-red-500 @enderror" required>
                @error('incident_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                    <div>
                        <h4 class="font-semibold text-blue-800 mb-1">Informasi Penting</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Keluhan akan mendapat nomor tiket otomatis</li>
                            <li>• Anda akan menerima update status melalui dashboard</li>
                            <li>• Tim kami akan merespon dalam 2 jam kerja</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center">
                <a href="{{ route('user.complaints.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Keluhan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview-container').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection