<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        // Total complaints in period
        $totalComplaints = Complaint::whereBetween('created_at', [$dateFrom, $dateTo])->count();

        // Complaints by status
        $complaintsByStatus = Complaint::select('status', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('status')
            ->get();

        // Complaints by priority
        $complaintsByPriority = Complaint::select('priority', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('priority')
            ->get();

        // Top products with complaints
        $topProducts = Complaint::select('product_name', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('product_name')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Top problem types
        $topProblems = Complaint::select('problem_type', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('problem_type')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Daily complaints trend
        $dailyTrend = Complaint::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Admin performance
        $adminPerformance = User::where('role', 'admin')
            ->withCount([
                'assignedComplaints as total_assigned' => function($q) use ($dateFrom, $dateTo) {
                    $q->whereBetween('created_at', [$dateFrom, $dateTo]);
                },
                'assignedComplaints as total_resolved' => function($q) use ($dateFrom, $dateTo) {
                    $q->where('status', 'resolved')
                      ->whereBetween('created_at', [$dateFrom, $dateTo]);
                }
            ])
            ->get();

        // Average resolution time
        $avgResolutionTime = Complaint::whereNotNull('resolved_at')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->selectRaw('AVG(DATEDIFF(resolved_at, created_at)) as avg_days')
            ->value('avg_days');

        // Active users
        $activeUsers = User::where('role', 'user')
            ->whereHas('complaints', function($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->count();

        // Resolution rate
        $resolvedCount = Complaint::where('status', 'resolved')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();
        $resolutionRate = $totalComplaints > 0 ? round(($resolvedCount / $totalComplaints) * 100, 2) : 0;

        return view('admin.reports.index', compact(
            'dateFrom',
            'dateTo',
            'totalComplaints',
            'complaintsByStatus',
            'complaintsByPriority',
            'topProducts',
            'topProblems',
            'dailyTrend',
            'adminPerformance',
            'avgResolutionTime',
            'activeUsers',
            'resolutionRate'
        ));
    }

    public function export(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $complaints = Complaint::with(['user', 'assignedAdmin'])
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->get();

        $filename = 'laporan_keluhan_' . $dateFrom . '_to_' . $dateTo . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($complaints) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, [
                'No. Keluhan',
                'Tanggal',
                'Nama User',
                'Email User',
                'Produk',
                'Jenis Masalah',
                'Deskripsi',
                'Status',
                'Prioritas',
                'Admin',
                'Respon Admin',
                'Tanggal Selesai'
            ]);

            // Data
            foreach ($complaints as $complaint) {
                fputcsv($file, [
                    $complaint->complaint_number,
                    $complaint->created_at->format('d-m-Y H:i'),
                    $complaint->user->name,
                    $complaint->user->email,
                    $complaint->product_name,
                    $complaint->problem_type,
                    $complaint->description,
                    $complaint->getStatusLabel(),
                    $complaint->getPriorityLabel(),
                    $complaint->assignedAdmin ? $complaint->assignedAdmin->name : '-',
                    $complaint->admin_response ?? '-',
                    $complaint->resolved_at ? $complaint->resolved_at->format('d-m-Y H:i') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}