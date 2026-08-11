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

            <!-- Customer Name -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Nama Customer <span class="text-red-500">*</span>
                </label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('customer_name') border-red-500 @enderror"
                    placeholder="Masukkan nama customer" required>

                @error('customer_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

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
                <select name="problem_type" id="problem_type_select"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('problem_type') border-red-500 @enderror"
                    onchange="toggleCustomProblem(this)" required>
                    <option value="">-- Pilih Jenis Masalah --</option>
                    @foreach($problemTypes as $type)
                        @if($type === 'Lainnya')
                            <option value="Lainnya" {{ (old('problem_type') === 'Lainnya' || old('problem_type_custom')) ? 'selected' : '' }}>
                                Lainnya 
                            </option>
                        @else
                            <option value="{{ $type }}" {{ old('problem_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('problem_type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                {{-- Input custom muncul saat pilih "Lainnya" --}}
                <div id="custom_problem_wrapper" class="mt-3 {{ (old('problem_type') === 'Lainnya' || old('problem_type_custom')) ? '' : 'hidden' }}">
                    <div class="flex items-center gap-2 bg-purple-50 border border-purple-200 rounded-lg px-4 py-3">
                        <i class="fas fa-pencil-alt text-purple-400 flex-shrink-0"></i>
                        <input type="text"
                            name="problem_type_custom"
                            id="problem_type_custom"
                            value="{{ old('problem_type_custom') }}"
                            class="flex-1 bg-transparent outline-none text-gray-700 placeholder-gray-400 text-sm"
                            placeholder="Tuliskan jenis masalah secara spesifik..."
                            maxlength="100">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Contoh: Tidak Bisa Dibuka, Warna Pudar, Tidak Berbuih, dll.</p>
                    @error('problem_type_custom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
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

            <!-- Photo Upload media -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Upload Bukti (Foto / Video)
                </label>

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50/50 hover:bg-gray-50 transition-colors">

                    <input type="file"
                        name="media[]"
                        id="media"
                        accept="image/*,video/*"
                        class="hidden"
                        multiple
                        onchange="previewMedia(event)">

                    <div id="preview-container" class="hidden mb-6">
                        <!-- Preview grid will be dynamically generated here -->
                    </div>

                    <label for="media" class="cursor-pointer block py-4">
                        <i class="fas fa-cloud-upload-alt text-4xl text-purple-500 mb-3 hover:scale-110 transition-transform duration-200"></i>
                        <p class="text-gray-700 font-medium">
                            Klik untuk upload foto atau video
                        </p>
                        <p class="text-xs text-gray-500 mt-1.5">
                            Bisa memilih lebih dari 1 file sekaligus
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            Format: JPG, PNG, MP4, MOV (Maksimal 10MB per file)
                        </p>
                    </label>

                </div>

                @error('media')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @if($errors->has('media.*'))
                    @foreach($errors->get('media.*') as $messages)
                        @foreach($messages as $message)
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @endforeach
                    @endforeach
                @endif
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
function toggleCustomProblem(select) {
    const wrapper = document.getElementById('custom_problem_wrapper');
    const input   = document.getElementById('problem_type_custom');
    if (select.value === 'Lainnya') {
        wrapper.classList.remove('hidden');
        input.required = true;
        input.focus();
    } else {
        wrapper.classList.add('hidden');
        input.required = false;
        input.value = '';
    }
}

// Pulihkan state saat halaman reload akibat validasi gagal
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('problem_type_select');
    if (select) toggleCustomProblem(select);
});

let selectedFiles = [];

function previewMedia(event) {
    const files = Array.from(event.target.files);
    
    // Check file size and type constraints
    const maxFileSize = 10 * 1024 * 1024; // 10MB
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'video/mp4', 'video/quicktime', 'video/x-matroska', 'video/avi', 'video/webm'];

    let validFiles = [];
    let rejectedCount = 0;

    files.forEach(file => {
        const extension = file.name.split('.').pop().toLowerCase();
        const isAllowedExtension = ['jpeg', 'jpg', 'png', 'mp4', 'mov', 'avi', 'mkv', 'webm'].includes(extension);
        
        if (!isAllowedExtension || (file.type && !file.type.startsWith('image/') && !file.type.startsWith('video/'))) {
            alert(`Format file "${file.name}" tidak didukung. Hanya JPG, PNG, MP4, dan MOV yang diperbolehkan.`);
            rejectedCount++;
            return;
        }
        
        if (file.size > maxFileSize) {
            alert(`File "${file.name}" terlalu besar. Ukuran maksimal adalah 10MB.`);
            rejectedCount++;
            return;
        }
        
        validFiles.push(file);
    });

    // Append valid files to our tracking list
    selectedFiles = [...selectedFiles, ...validFiles];
    
    // Sync to file input
    updateFileInput();
    
    // Display previews
    renderPreviews();
}

function updateFileInput() {
    const input = document.getElementById('media');
    const dataTransfer = new DataTransfer();
    
    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });
    
    input.files = dataTransfer.files;
}

function renderPreviews() {
    const previewContainer = document.getElementById('preview-container');
    previewContainer.innerHTML = '';
    
    if (selectedFiles.length === 0) {
        previewContainer.classList.add('hidden');
        return;
    }
    
    previewContainer.classList.remove('hidden');
    
    // Create a beautiful grid for previews
    const grid = document.createElement('div');
    grid.className = 'grid grid-cols-2 sm:grid-cols-3 gap-4 p-2 bg-gray-100/50 rounded-lg border border-gray-200';
    
    selectedFiles.forEach((file, index) => {
        const fileUrl = URL.createObjectURL(file);
        
        const card = document.createElement('div');
        card.className = 'relative group bg-black rounded-lg overflow-hidden border border-gray-300 aspect-video shadow-md hover:shadow-lg transition duration-200';
        
        let mediaElement;
        const isVideo = file.type.startsWith('video/') || ['mp4', 'mov', 'avi', 'mkv', 'webm'].includes(file.name.split('.').pop().toLowerCase());
        
        if (!isVideo) {
            mediaElement = document.createElement('img');
            mediaElement.src = fileUrl;
            mediaElement.className = 'w-full h-full object-cover';
        } else {
            mediaElement = document.createElement('video');
            mediaElement.src = fileUrl;
            mediaElement.className = 'w-full h-full object-cover pointer-events-none';
            
            // Add a subtle play icon overlay for video
            const playOverlay = document.createElement('div');
            playOverlay.className = 'absolute inset-0 flex items-center justify-center bg-black/20';
            playOverlay.innerHTML = '<span class="w-8 h-8 flex items-center justify-center rounded-full bg-white/80 text-purple-600 shadow"><i class="fas fa-play text-xs ml-0.5"></i></span>';
            card.appendChild(playOverlay);
        }
        
        // Remove button
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'absolute top-1.5 right-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-lg focus:outline-none transition-all duration-200 hover:scale-110 z-10';
        removeBtn.innerHTML = '<i class="fas fa-times text-xs"></i>';
        removeBtn.title = 'Hapus file ini';
        removeBtn.onclick = (e) => {
            e.preventDefault();
            e.stopPropagation();
            removeFile(index);
        };
        
        // Label badge for file type (Foto/Video)
        const badge = document.createElement('div');
        badge.className = 'absolute bottom-1.5 left-1.5 bg-black/60 backdrop-blur-sm text-[10px] text-white font-semibold px-2 py-0.5 rounded shadow';
        badge.innerHTML = isVideo ? '<i class="fas fa-video mr-1"></i> Video' : '<i class="fas fa-image mr-1"></i> Foto';
        
        card.appendChild(mediaElement);
        card.appendChild(removeBtn);
        card.appendChild(badge);
        grid.appendChild(card);
    });
    
    previewContainer.appendChild(grid);
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    updateFileInput();
    renderPreviews();
}
</script>
@endpush
@endsection