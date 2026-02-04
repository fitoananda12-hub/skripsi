<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::where('user_id', auth()->id());

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('complaint_number', 'like', '%' . $request->search . '%')
                  ->orWhere('product_name', 'like', '%' . $request->search . '%')
                  ->orWhere('problem_type', 'like', '%' . $request->search . '%');
            });
        }

        $complaints = $query->latest()->paginate(15);

        $statusCounts = [
            'all' => Complaint::where('user_id', auth()->id())->count(),
            'submitted' => Complaint::where('user_id', auth()->id())->where('status', 'submitted')->count(),
            'in_progress' => Complaint::where('user_id', auth()->id())->where('status', 'in_progress')->count(),
            'resolved' => Complaint::where('user_id', auth()->id())->where('status', 'resolved')->count(),
            'closed' => Complaint::where('user_id', auth()->id())->where('status', 'closed')->count(),
        ];

        return view('user.history', compact('complaints', 'statusCounts'));
    }
}