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
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        // Base query for complaints in the selected period
        $complaintQuery = Complaint::query();
        if ($dateFrom) {
            $complaintQuery->where('created_at', '>=', $dateFrom . ' 00:00:00');
        }
        if ($dateTo) {
            $complaintQuery->where('created_at', '<=', $dateTo . ' 23:59:59');
        }

        // Total complaints in period
        $totalComplaints = (clone $complaintQuery)->count();

        // Complaints by status
        $complaintsByStatus = (clone $complaintQuery)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Complaints by priority
        $complaintsByPriority = (clone $complaintQuery)
            ->select('priority', DB::raw('count(*) as total'))
            ->groupBy('priority')
            ->get();

        // Top products with complaints
        $topProducts = (clone $complaintQuery)
            ->select('product_name', DB::raw('count(*) as total'))
            ->groupBy('product_name')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Top problem types
        $topProblems = (clone $complaintQuery)
            ->select('problem_type', DB::raw('count(*) as total'))
            ->groupBy('problem_type')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Daily complaints trend
        $dailyTrend = (clone $complaintQuery)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Admin performance
        $adminPerformance = User::where('role', 'admin')
            ->withCount([
                'assignedComplaints as total_assigned' => function($q) use ($dateFrom, $dateTo) {
                    if ($dateFrom) {
                        $q->where('created_at', '>=', $dateFrom . ' 00:00:00');
                    }
                    if ($dateTo) {
                        $q->where('created_at', '<=', $dateTo . ' 23:59:59');
                    }
                },
                'assignedComplaints as total_resolved' => function($q) use ($dateFrom, $dateTo) {
                    $q->where('status', 'resolved');
                    if ($dateFrom) {
                        $q->where('created_at', '>=', $dateFrom . ' 00:00:00');
                    }
                    if ($dateTo) {
                        $q->where('created_at', '<=', $dateTo . ' 23:59:59');
                    }
                }
            ])
            ->get();

        // Average resolution time
        $avgResolutionTime = (clone $complaintQuery)
            ->whereNotNull('resolved_at')
            ->selectRaw('AVG(DATEDIFF(resolved_at, created_at)) as avg_days')
            ->value('avg_days');

        // Active users
        $activeUsers = User::where('role', 'user')
            ->whereHas('complaints', function($q) use ($dateFrom, $dateTo) {
                if ($dateFrom) {
                    $q->where('created_at', '>=', $dateFrom . ' 00:00:00');
                }
                if ($dateTo) {
                    $q->where('created_at', '<=', $dateTo . ' 23:59:59');
                }
            })
            ->count();

        // Resolution rate
        $resolvedCount = (clone $complaintQuery)
            ->where('status', 'resolved')
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
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $query = Complaint::with(['user', 'assignedAdmin']);
        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom . ' 00:00:00');
        }
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo . ' 23:59:59');
        }
        $complaints = $query->get();

        $filename = 'laporan_keluhan_' . ($dateFrom ?: 'all') . '_to_' . ($dateTo ?: 'all') . '.csv';

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