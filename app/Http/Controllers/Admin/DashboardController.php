<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use App\Models\Solution;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'submitted')->count();
        $inProgressComplaints = Complaint::where('status', 'in_progress')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();
        $totalUsers = User::where('role', 'user')->count();
        $totalSolutions = Solution::where('is_active', true)->count();

        // Recent complaints
        $recentComplaints = Complaint::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Complaints by status
        $complaintsByStatus = Complaint::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Complaints by priority
        $complaintsByPriority = Complaint::select('priority', DB::raw('count(*) as total'))
            ->groupBy('priority')
            ->get();

        // Monthly complaints (last 6 months)
        $monthlyComplaints = Complaint::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month', 'year')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Top problem types
        $topProblems = Complaint::select('problem_type', DB::raw('count(*) as total'))
            ->groupBy('problem_type')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Most used solutions
        $topSolutions = Solution::orderBy('usage_count', 'desc')
            ->limit(5)
            ->get();

        // Average resolution time (in days)
        $avgResolutionTime = Complaint::whereNotNull('resolved_at')
            ->selectRaw('AVG(DATEDIFF(resolved_at, created_at)) as avg_days')
            ->value('avg_days');

        return view('admin.dashboard', compact(
            'totalComplaints',
            'pendingComplaints',
            'inProgressComplaints',
            'resolvedComplaints',
            'totalUsers',
            'totalSolutions',
            'recentComplaints',
            'complaintsByStatus',
            'complaintsByPriority',
            'monthlyComplaints',
            'topProblems',
            'topSolutions',
            'avgResolutionTime'
        ));
    }
}