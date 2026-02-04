@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-2xl p-8 text-white shadow-xl">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p class="text-indigo-100">Dashboard monitoring sistem customer service PT. ESABUMINDO</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-blue-500">
            <p class="text-gray-500 text-sm mb-1">Total Keluhan</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalComplaints }}</h3>
            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-file-alt"></i> Semua status</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-yellow-500">
            <p class="text-gray-500 text-sm mb-1">Diajukan</p>
            <h3 class="text-3xl font-bold text-yellow-600">{{ $pendingComplaints }}</h3>
            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-clock"></i> Butuh perhatian</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-blue-500">
            <p class="text-gray-500 text-sm mb-1">Diproses</p>
            <h3 class="text-3xl font-bold text-blue-600">{{ $inProgressComplaints }}</h3>
            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-spinner"></i> Sedang ditangani</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-green-500">
            <p class="text-gray-500 text-sm mb-1">Selesai</p>
            <h3 class="text-3xl font-bold text-green-600">{{ $resolvedComplaints }}</h3>
            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-check-circle"></i> Terselesaikan</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-purple-500">
            <p class="text-gray-500 text-sm mb-1">Total User</p>
            <h3 class="text-3xl font-bold text-purple-600">{{ $totalUsers }}</h3>
            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-users"></i> Terdaftar</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-orange-500">
            <p class="text-gray-500 text-sm mb-1">Solusi KB</p>
            <h3 class="text-3xl font-bold text-orange-600">{{ $totalSolutions }}</h3>
            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-lightbulb"></i> Knowledge Base</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Complaints by Status -->
        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Keluhan Berdasarkan Status</h3>
            <canvas id="statusChart" height="200"></canvas>
        </div>

        <!-- Complaints by Priority -->
        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Keluhan Berdasarkan Prioritas</h3>
            <canvas id="priorityChart" height="200"></canvas>
        </div>
    </div>

    <!-- Monthly Trend -->
    <div class="bg-white rounded-xl p-6 shadow-md">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tren Keluhan 6 Bulan Terakhir</h3>
        <canvas id="trendChart" height="80"></canvas>
    </div>

    <!-- Recent Complaints & Top Lists -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Recent Complaints -->
        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-clock text-indigo-600 mr-2"></i>Keluhan Terbaru
            </h3>
            @if($recentComplaints->count() > 0)
            <div class="space-y-3">
                @foreach($recentComplaints as $complaint)
                <div class="border-l-4 {{ $complaint->priority == 'high' ? 'border-red-500' : ($complaint->priority == 'medium' ? 'border-yellow-500' : 'border-green-500') }} pl-4 py-2 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start mb-1">
                        <a href="{{ route('admin.complaints.show', $complaint) }}" class="font-semibold text-gray-800 hover:text-indigo-600">
                            {{ $complaint->complaint_number }}
                        </a>
                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $complaint->getStatusBadgeClass() }}">
                            {{ $complaint->getStatusLabel() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600">{{ $complaint->product_name }} - {{ $complaint->problem_type }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-user mr-1"></i>{{ $complaint->user->name }} • 
                        <i class="fas fa-calendar ml-2 mr-1"></i>{{ $complaint->created_at->diffForHumans() }}
                    </p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-center py-8">Tidak ada keluhan terbaru</p>
            @endif
        </div>

        <!-- Top Problems & Solutions -->
        <div class="space-y-6">
            <!-- Top Problems -->
            <div class="bg-white rounded-xl p-6 shadow-md">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>Masalah Terbanyak
                </h3>
                @if($topProblems->count() > 0)
                <div class="space-y-2">
                    @foreach($topProblems as $problem)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700">{{ $problem->problem_type }}</span>
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $problem->total }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-center py-4">Tidak ada data</p>
                @endif
            </div>

            <!-- Top Solutions -->
            <div class="bg-white rounded-xl p-6 shadow-md">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-star text-yellow-500 mr-2"></i>Solusi Terpopuler
                </h3>
                @if($topSolutions->count() > 0)
                <div class="space-y-2">
                    @foreach($topSolutions as $solution)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700 truncate">{{ $solution->title }}</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold ml-2">
                            {{ $solution->usage_count }}x
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-center py-4">Tidak ada data</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Metrics -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-700 text-sm font-medium">Rata-rata Waktu Selesai</p>
                    <h3 class="text-3xl font-bold text-blue-800 mt-1">
                        {{ $avgResolutionTime ? number_format($avgResolutionTime, 1) : '0' }} hari
                    </h3>
                </div>
                <i class="fas fa-clock text-blue-300 text-4xl"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-700 text-sm font-medium">Tingkat Penyelesaian</p>
                    <h3 class="text-3xl font-bold text-green-800 mt-1">
                        {{ $totalComplaints > 0 ? number_format(($resolvedComplaints / $totalComplaints) * 100, 1) : 0 }}%
                    </h3>
                </div>
                <i class="fas fa-check-double text-green-300 text-4xl"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-700 text-sm font-medium">Keluhan Hari Ini</p>
                    <h3 class="text-3xl font-bold text-purple-800 mt-1">
                        {{ \App\Models\Complaint::whereDate('created_at', today())->count() }}
                    </h3>
                </div>
                <i class="fas fa-calendar-day text-purple-300 text-4xl"></i>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($complaintsByStatus->pluck('status')->map(function($status) {
            return match($status) {
                'submitted' => 'Diajukan',
                'in_progress' => 'Diproses',
                'resolved' => 'Selesai',
                'closed' => 'Ditutup',
                default => $status
            };
        })) !!},
        datasets: [{
            data: {!! json_encode($complaintsByStatus->pluck('total')) !!},
            backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#6b7280']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Priority Chart
const priorityCtx = document.getElementById('priorityChart').getContext('2d');
new Chart(priorityCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($complaintsByPriority->pluck('priority')->map(function($priority) {
            return match($priority) {
                'low' => 'Rendah',
                'medium' => 'Sedang',
                'high' => 'Tinggi',
                default => $priority
            };
        })) !!},
        datasets: [{
            data: {!! json_encode($complaintsByPriority->pluck('total')) !!},
            backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Trend Chart
const trendCtx = document.getElementById('trendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyComplaints->map(function($item) {
            return date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year));
        })) !!},
        datasets: [{
            label: 'Jumlah Keluhan',
            data: {!! json_encode($monthlyComplaints->pluck('total')) !!},
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endpush
@endsection