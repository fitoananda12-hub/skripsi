<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Customer Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-indigo-600 to-indigo-800 text-white flex-shrink-0">
            <div class="p-6">
                <div class="flex items-center mb-8">
                    <i class="fas fa-user-shield text-3xl mr-3"></i>
                    <div>
                        <h1 class="text-xl font-bold">Admin Laboratorium</h1>
                        <p class="text-xs text-indigo-200">Management System</p>
                    </div>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white text-indigo-600' : 'hover:bg-indigo-700' }} transition">
                        <i class="fas fa-chart-line w-5"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.complaints.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.complaints.*') ? 'bg-white text-indigo-600' : 'hover:bg-indigo-700' }} transition">
                        <i class="fas fa-file-alt w-5"></i>
                        <span class="ml-3">Keluhan</span>
                    </a>
                    <a href="{{ route('admin.solutions.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.solutions.*') ? 'bg-white text-indigo-600' : 'hover:bg-indigo-700' }} transition">
                        <i class="fas fa-lightbulb w-5"></i>
                        <span class="ml-3">Solusi</span>
                    </a>
                    @php $pendingCount = \App\Models\User::where('role','user')->where('registration_status','pending')->count(); @endphp
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-white text-indigo-600' : 'hover:bg-indigo-700' }} transition">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3">User</span>
                        @if($pendingCount > 0)
                        <span class="ml-auto bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">
                            {{ $pendingCount }}
                        </span>
                        @endif
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-white text-indigo-600' : 'hover:bg-indigo-700' }} transition">
                        <i class="fas fa-chart-bar w-5"></i>
                        <span class="ml-3">Laporan</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div id="flash-message" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-3"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div id="flash-message" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-3"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <script>
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.style.opacity = '0';
                flashMessage.style.transition = 'opacity 0.5s';
                setTimeout(() => flashMessage.remove(), 500);
            }, 3000);
        }
    </script>

    @stack('scripts')
</body>
</html>