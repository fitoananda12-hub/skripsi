@extends('layouts.admin')

@section('title', 'Laporan & Analisis')
@section('page-title', 'Laporan & Analisis')

@section('content')
<div class="space-y-6">
    <!-- Filter & Export -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Filter Periode Laporan</h3>
            <a href="{{ route('admin.reports.export', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                <i class="fas fa-file-export mr-2"></i>Export CSV
            </a>
        </div>

        <form method="GET" action="{{ route('admin.reports.index') }}" class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Key Metrics -->
    <div class="grid md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-blue-500">
            <p class="text-gray-600 text-sm">Total Keluhan</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalComplaints }}</h3>
            <p class="text-xs text-gray-500 mt-1">Periode ini</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-green-500">
            <p class="text-gray-600 text-sm">Tingkat Selesai</p>
            <h3 class="text-3xl font-bold text-green-600">{{ $resolutionRate }}%</h3>
            <p class="text-xs text-gray-500 mt-1">Resolution rate</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-purple-500">
            <p class="text-gray-600 text-sm">Rata-rata Waktu</p>
            <h3 class="text-3xl font-bold text-purple-600">{{ $avgResolutionTime ? number_format($avgResolutionTime, 1) : '0' }}</h3>
            <p class="text-xs text-gray-500 mt-1">Hari penyelesaian</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-orange-500">
            <p class="text-gray-600 text-sm">User Aktif</p>
            <h3 class="text-3xl font-bold text-orange-600">{{ $activeUsers }}</h3>
            <p class="text-xs text-gray-500 mt-1">User membuat keluhan</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Status Distribution -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Status</h3>
            <canvas id="statusChart" height="200"></canvas>
        </div>

        <!-- Priority Distribution -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Prioritas</h3>
            <canvas id="priorityChart" height="200"></canvas>
        </div>
    </div>

    <!-- Daily Trend -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tren Harian Keluhan</h3>
        <canvas id="dailyChart" height="80"></canvas>
    </div>

    <!-- Top Lists -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Top Products -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-box text-red-600 mr-2"></i>Produk dengan Keluhan Terbanyak
            </h3>
            @if($topProducts->count() > 0)
            <div class="space-y-3">
                @foreach($topProducts as $product)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-800 font-medium">{{ $product->product_name }}</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                        {{ $product->total }} keluhan
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-center py-8">Tidak ada data</p>
            @endif
        </div>

        <!-- Top Problems -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>Jenis Masalah Terbanyak
            </h3>
            @if($topProblems->count() > 0)
            <div class="space-y-3">
                @foreach($topProblems as $problem)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-800 font-medium">{{ $problem->problem_type }}</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        {{ $problem->total }} kasus
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-center py-8">Tidak ada data</p>
            @endif
        </div>
    </div>

    <!-- Admin Performance -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-users-cog text-indigo-600 mr-2"></i>Performa Admin
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Admin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Ditugaskan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Diselesaikan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tingkat Selesai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($adminPerformance as $admin)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-800">{{ $admin->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-800 font-medium">{{ $admin->total_assigned }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-green-600 font-medium">{{ $admin->total_resolved }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $rate = $admin->total_assigned > 0 ? round(($admin->total_resolved / $admin->total_assigned) * 100, 1) : 0;
                            @endphp
                            <div class="flex items-center">
                                <div class="flex-1 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $rate }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-800">{{ $rate }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
        labels: {!! json_encode($complaintsByStatus->pluck('status')->map(function($s) {
            return match($s) {
                'submitted' => 'Diajukan',
                'in_progress' => 'Diproses',
                'resolved' => 'Selesai',
                'closed' => 'Ditutup',
                default => $s
            };
        })) !!},
        datasets: [{
            data: {!! json_encode($complaintsByStatus->pluck('total')) !!},
            backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#6b7280']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});

// Priority Chart
const priorityCtx = document.getElementById('priorityChart').getContext('2d');
new Chart(priorityCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($complaintsByPriority->pluck('priority')->map(function($p) {
            return match($p) {
                'low' => 'Rendah',
                'medium' => 'Sedang',
                'high' => 'Tinggi',
                default => $p
            };
        })) !!},
        datasets: [{
            data: {!! json_encode($complaintsByPriority->pluck('total')) !!},
            backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});

// Daily Trend Chart
const dailyCtx = document.getElementById('dailyChart').getContext('2d');
new Chart(dailyCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($dailyTrend->pluck('date')->map(function($d) {
            return date('d M', strtotime($d));
        })) !!},
        datasets: [{
            label: 'Keluhan',
            data: {!! json_encode($dailyTrend->pluck('total')) !!},
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>
@endpush
@endsection