<!-- Lightbox Modal -->
<div id="lightbox-modal" class="fixed inset-0 z-50 hidden flex flex-col items-center justify-center bg-black/95 backdrop-blur-md select-none transition-opacity duration-300">
    <!-- Top Bar with Actions -->
    <div class="absolute top-0 left-0 right-0 p-4 flex justify-between items-center z-50 bg-gradient-to-b from-black/80 to-transparent">
        <div class="text-white/90 text-sm font-medium pl-4 tracking-wide flex items-center gap-2">
            <i class="fas fa-images text-purple-400"></i>
            <span id="lightbox-title">Detail Bukti Keluhan</span>
        </div>
        <div class="flex items-center gap-3 pr-4">
            <!-- Zoom Out Button -->
            <button onclick="zoomLightbox(0.8)" class="text-white hover:text-purple-400 bg-white/10 hover:bg-white/20 p-2.5 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500" title="Perkecil">
                <i class="fas fa-search-minus text-base"></i>
            </button>
            <!-- Zoom Indicator -->
            <span id="zoom-indicator" class="text-white text-xs bg-purple-600/80 px-3 py-1.5 rounded-full font-mono font-bold tracking-wider shadow-md border border-purple-500/30">100%</span>
            <!-- Zoom In Button -->
            <button onclick="zoomLightbox(1.25)" class="text-white hover:text-purple-400 bg-white/10 hover:bg-white/20 p-2.5 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500" title="Perbesar">
                <i class="fas fa-search-plus text-base"></i>
            </button>
            <!-- Reset Zoom Button -->
            <button onclick="resetLightboxZoom()" class="text-white hover:text-purple-400 bg-white/10 hover:bg-white/20 p-2.5 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500" title="Reset Zoom">
                <i class="fas fa-sync-alt text-sm"></i>
            </button>
            <!-- Close Button -->
            <button onclick="closeLightbox()" class="text-white hover:text-red-400 bg-white/10 hover:bg-red-500/20 p-2.5 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 ml-2" title="Tutup">
                <i class="fas fa-times text-base"></i>
            </button>
        </div>
    </div>

    <!-- Main Content Frame -->
    <div class="relative w-full h-full flex items-center justify-center overflow-hidden p-8" id="lightbox-viewport" style="cursor: grab;">
        <div id="lightbox-frame" class="relative transition-transform duration-100 ease-out max-w-full max-h-full flex items-center justify-center select-none" style="transform: translate(0px, 0px) scale(1);">
            <!-- Image Content -->
            <img id="lightbox-img" src="" alt="Detail Bukti" class="max-w-[90vw] max-h-[80vh] rounded-xl shadow-2xl border border-white/10 object-contain hidden pointer-events-none transition-shadow duration-300">
            
            <!-- Video Content -->
            <video id="lightbox-video" src="" controls class="max-w-[90vw] max-h-[80vh] rounded-xl shadow-2xl border border-white/10 hidden transition-shadow duration-300"></video>
        </div>
    </div>

    <!-- Bottom Instruction -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/70 text-xs bg-black/60 backdrop-blur-md border border-white/10 px-5 py-2.5 rounded-full pointer-events-none shadow-lg tracking-wide flex items-center gap-2">
        <i class="fas fa-info-circle text-purple-400"></i>
        <span>Gunakan scroll mouse atau tombol di atas untuk zoom. Drag media untuk menggeser.</span>
    </div>
</div>

<style>
#lightbox-viewport:active {
    cursor: grabbing !important;
}
</style>

<script>
let zoomScale = 1;
let translateX = 0;
let translateY = 0;
let isDragging = false;
let startX = 0;
let startY = 0;

function openLightbox(url, isVideo) {
    const modal = document.getElementById('lightbox-modal');
    const img = document.getElementById('lightbox-img');
    const video = document.getElementById('lightbox-video');
    
    // Reset transform states
    zoomScale = 1;
    translateX = 0;
    translateY = 0;
    updateFrameTransform();
    
    if (isVideo) {
        img.classList.add('hidden');
        img.src = '';
        
        video.src = url;
        video.classList.remove('hidden');
    } else {
        video.classList.add('hidden');
        video.src = '';
        
        img.src = url;
        img.classList.remove('hidden');
    }
    
    // Show modal with a smooth fade-in
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden'; // prevent scrolling behind
}

function closeLightbox() {
    const modal = document.getElementById('lightbox-modal');
    const img = document.getElementById('lightbox-img');
    const video = document.getElementById('lightbox-video');
    
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    img.src = '';
    video.src = '';
    video.pause();
    
    document.body.style.overflow = ''; // restore scrolling
}

function zoomLightbox(factor) {
    zoomScale *= factor;
    // Set boundaries for zoom (25% to 800%)
    if (zoomScale < 0.25) zoomScale = 0.25;
    if (zoomScale > 8) zoomScale = 8;
    
    updateFrameTransform();
}

function resetLightboxZoom() {
    zoomScale = 1;
    translateX = 0;
    translateY = 0;
    updateFrameTransform();
}

function updateFrameTransform() {
    const frame = document.getElementById('lightbox-frame');
    const indicator = document.getElementById('zoom-indicator');
    
    frame.style.transform = `translate(${translateX}px, ${translateY}px) scale(${zoomScale})`;
    indicator.textContent = `${Math.round(zoomScale * 100)}%`;
}

// Drag and pan logic
const viewport = document.getElementById('lightbox-viewport');

viewport.addEventListener('mousedown', (e) => {
    // Only drag on left click
    if (e.button !== 0) return;
    
    // If clicking video controls, don't drag
    if (e.target.tagName === 'VIDEO' && e.offsetY > e.target.clientHeight - 60) return;
    
    isDragging = true;
    startX = e.clientX - translateX;
    startY = e.clientY - translateY;
    e.preventDefault();
});

window.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    translateX = e.clientX - startX;
    translateY = e.clientY - startY;
    updateFrameTransform();
});

window.addEventListener('mouseup', () => {
    isDragging = false;
});

// Wheel zoom
viewport.addEventListener('wheel', (e) => {
    e.preventDefault();
    const zoomFactor = e.deltaY < 0 ? 1.15 : 0.85;
    zoomLightbox(zoomFactor);
}, { passive: false });

// Keyboard controls
window.addEventListener('keydown', (e) => {
    const modal = document.getElementById('lightbox-modal');
    if (modal.classList.contains('hidden')) return;
    
    if (e.key === 'Escape') {
        closeLightbox();
    } else if (e.key === '=' || e.key === '+') {
        zoomLightbox(1.15);
    } else if (e.key === '-') {
        zoomLightbox(0.85);
    } else if (e.key === '0') {
        resetLightboxZoom();
    }
});
</script>
