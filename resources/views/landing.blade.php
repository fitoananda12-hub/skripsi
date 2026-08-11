<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Service - PT. ESABUMINDO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .slide-in {
            animation: slideIn 1s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <i class="fas fa-cog text-purple-600 text-3xl mr-3"></i>
                    <div>
                        <h1 class="text-2xl font-bold gradient-text">CS ESABUMINDO</h1>
                        <p class="text-xs text-gray-500">Customer Service Portal</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/login" onclick="console.log('Login clicked'); return true;" class="text-gray-700 hover:text-purple-600 px-4 py-2 rounded-lg font-medium transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                    </a>
                    <a href="/register" onclick="console.log('Register clicked'); return true;" class="gradient-bg text-white px-6 py-2 rounded-lg font-medium hover:opacity-90 transition shadow-md">
                        <i class="fas fa-user-plus mr-2"></i>Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 gradient-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white slide-in">
                    <h1 class="text-5xl font-bold mb-6 leading-tight">
                        Solusi Cepat untuk<br>
                        <span class="text-yellow-300">Keluhan Produk Anda</span>
                    </h1>
                    <p class="text-xl mb-8 text-purple-100">
                        Sistem layanan customer service terpadu untuk mengelola keluhan produk lem dengan respon cepat dan solusi profesional.
                    </p>
                    <div class="flex space-x-4">
                        <a href="{{ route('register') }}" class="bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition shadow-xl">
                            Mulai Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="floating hidden md:block">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-gray-800">Keluhan Terselesaikan</h3>
                                <p class="text-gray-500">Dalam 24 Jam</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Tingkat Kepuasan</span>
                                    <span class="text-sm font-bold text-purple-600">98%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 h-2 rounded-full" style="width: 98%"></div>
                                </div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Respon Time</span>
                                    <span class="text-sm font-bold text-purple-600">2 Jam</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    Fitur <span class="gradient-text">Unggulan</span>
                </h2>
                <p class="text-gray-600 text-lg">Solusi lengkap untuk manajemen keluhan produk Anda</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-gradient-to-br from-purple-50 to-white p-8 rounded-2xl shadow-lg border border-purple-100">
                    <div class="bg-purple-100 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-edit text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Ajukan Keluhan</h3>
                    <p class="text-gray-600 mb-4">Laporkan masalah produk dengan mudah melalui form yang terstruktur dan lengkap dengan upload foto.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Form terstruktur
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Upload foto produk
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Nomor tiket otomatis
                        </li>
                    </ul>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-gradient-to-br from-blue-50 to-white p-8 rounded-2xl shadow-lg border border-blue-100">
                    <div class="bg-blue-100 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-search text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Tracking Real-time</h3>
                    <p class="text-gray-600 mb-4">Pantau status keluhan Anda secara real-time dari pengajuan hingga penyelesaian.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Update status otomatis
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Notifikasi langsung
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Dashboard transparan
                        </li>
                    </ul>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-gradient-to-br from-green-50 to-white p-8 rounded-2xl shadow-lg border border-green-100">
                    <div class="bg-green-100 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-lightbulb text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Solusi Cerdas</h3>
                    <p class="text-gray-600 mb-4">Dapatkan solusi teknis dari knowledge base yang terus diperbarui oleh tim ahli kami.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Database solusi lengkap
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Tips pencegahan
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Panduan teknis detail
                        </li>
                    </ul>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-gradient-to-br from-yellow-50 to-white p-8 rounded-2xl shadow-lg border border-yellow-100">
                    <div class="bg-yellow-100 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-history text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Riwayat Lengkap</h3>
                    <p class="text-gray-600 mb-4">Akses semua riwayat keluhan dan solusi yang pernah Anda ajukan kapan saja.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Arsip permanen
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Filter pencarian
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Export data
                        </li>
                    </ul>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-gradient-to-br from-red-50 to-white p-8 rounded-2xl shadow-lg border border-red-100">
                    <div class="bg-red-100 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-user-shield text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Admin Profesional</h3>
                    <p class="text-gray-600 mb-4">Tim customer service yang berpengalaman siap membantu menyelesaikan keluhan Anda.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Respon cepat
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Prioritas handling
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Follow-up berkala
                        </li>
                    </ul>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-gradient-to-br from-indigo-50 to-white p-8 rounded-2xl shadow-lg border border-indigo-100">
                    <div class="bg-indigo-100 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Laporan & Analisis</h3>
                    <p class="text-gray-600 mb-4">Dashboard analitik untuk monitoring performa dan tren keluhan produk.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Grafik visual
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Statistik lengkap
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Export laporan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    Cara <span class="gradient-text">Kerja</span>
                </h2>
                <p class="text-gray-600 text-lg">Proses sederhana dalam 4 langkah</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-3xl font-bold">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Daftar Akun</h3>
                    <p class="text-gray-600">Buat akun gratis dengan mengisi form registrasi</p>
                </div>

                <div class="text-center">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-3xl font-bold">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Ajukan Keluhan</h3>
                    <p class="text-gray-600">Isi form keluhan dengan detail masalah produk</p>
                </div>

                <div class="text-center">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-3xl font-bold">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Tim Memproses</h3>
                    <p class="text-gray-600">Admin kami akan review dan memberikan solusi</p>
                </div>

                <div class="text-center">
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-3xl font-bold">4</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Masalah Selesai</h3>
                    <p class="text-gray-600">Dapatkan solusi dan keluhan terselesaikan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl font-bold text-white mb-6">
                Siap Menyelesaikan Masalah Produk Anda?
            </h2>
            <p class="text-xl text-purple-100 mb-8">
                Bergabunglah dengan ribuan pelanggan yang telah mempercayai layanan kami
            </p>
            <a href="{{ route('register') }}" class="inline-block bg-white text-purple-600 px-10 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-2xl">
                Daftar Sekarang Gratis <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-cog text-purple-400 text-2xl mr-2"></i>
                        <h3 class="text-xl font-bold">CS ESABUMINDO</h3>
                    </div>
                    <p class="text-gray-400">Solusi terpadu untuk layanan customer service produk lem berkualitas.</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-purple-400 transition">Keluhan Produk</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition">Knowledge Base</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-purple-400 transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition">Kontak</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition">Karir</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i>cs@esabumindo.com</li>
                        <li><i class="fas fa-phone mr-2"></i>(021) 1234-5678</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 PT. ESABUMINDO. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Debug: Check if navbar links exist and are clickable
        console.log('Landing page loaded');
        console.log('Navbar links found:', document.querySelectorAll('a[href="/login"], a[href="/register"]').length);
        
        // Make sure smooth scroll only affects hash links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                // Pastikan ini adalah internal link, bukan eksternal
                if (href && href !== '#' && href.startsWith('#')) {
                    e.preventDefault();
                    console.log('Smooth scrolling to:', href);
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            });
        });
        
        // Ensure navbar links work properly
        document.querySelectorAll('a[href="/login"], a[href="/register"]').forEach(link => {
            link.addEventListener('click', function(e) {
                console.log('Navigation link clicked:', this.href);
                // Allow normal navigation
            });
        });
    </script>
</body>
</html>