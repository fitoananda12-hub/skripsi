<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalComplaints = $user->complaints()->count();
        $submittedComplaints = $user->complaints()->where('status', 'submitted')->count();
        $inProgressComplaints = $user->complaints()->where('status', 'in_progress')->count();
        $resolvedComplaints = $user->complaints()->where('status', 'resolved')->count();
        $recentComplaints = $user->complaints()->latest()->limit(5)->get();

        return view('user.dashboard', compact(
            'totalComplaints',
            'submittedComplaints',
            'inProgressComplaints',
            'resolvedComplaints',
            'recentComplaints'
        ));
    }
}
