<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use App\Models\Solution;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with(['user', 'assignedAdmin']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by assigned admin
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('complaint_number', 'like', '%' . $request->search . '%')
                  ->orWhere('product_name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $complaints = $query->latest()->paginate(15);

        $admins = User::where('role', 'admin')->get();

        $statusCounts = [
            'all' => Complaint::count(),
            'submitted' => Complaint::where('status', 'submitted')->count(),
            'in_progress' => Complaint::where('status', 'in_progress')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'closed' => Complaint::where('status', 'closed')->count(),
        ];

        return view('admin.complaints.index', compact('complaints', 'admins', 'statusCounts'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['user', 'assignedAdmin', 'solutions']);
        $admins = User::where('role', 'admin')->get();
        $solutions = Solution::where('is_active', true)->get();

        return view('admin.complaints.show', compact('complaint', 'admins', 'solutions'));
    }

    public function edit(Complaint $complaint)
    {
        $admins = User::where('role', 'admin')->get();
        $solutions = Solution::where('is_active', true)->get();

        return view('admin.complaints.edit', compact('complaint', 'admins', 'solutions'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:submitted,in_progress,resolved,closed'],
            'priority' => ['required', 'in:low,medium,high'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'admin_response' => ['nullable', 'string'],
        ], [
            'status.required' => 'Status harus dipilih',
            'priority.required' => 'Prioritas harus dipilih',
        ]);

        // If status changed to resolved, set resolved_at
        if ($validated['status'] === 'resolved' && $complaint->status !== 'resolved') {
            $validated['resolved_at'] = now();
        }

        $complaint->update($validated);

        return redirect()->route('admin.complaints.show', $complaint)
            ->with('success', 'Data keluhan berhasil diperbarui');
    }

    public function assign(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
        ], [
            'assigned_to.required' => 'Admin harus dipilih',
        ]);

        $complaint->update([
            'assigned_to' => $validated['assigned_to'],
            'status' => 'in_progress',
        ]);

        return back()->with('success', 'Keluhan berhasil ditugaskan');
    }

    public function respond(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'admin_response' => ['required', 'string'],
            'status' => ['required', 'in:in_progress,resolved'],
            'solution_ids' => ['nullable', 'array'],
            'solution_ids.*' => ['exists:solutions,id'],
        ], [
            'admin_response.required' => 'Respon harus diisi',
            'status.required' => 'Status harus dipilih',
        ]);

        $complaint->update([
            'admin_response' => $validated['admin_response'],
            'status' => $validated['status'],
            'resolved_at' => $validated['status'] === 'resolved' ? now() : null,
        ]);

        // Attach solutions if provided
        if (!empty($validated['solution_ids'])) {
            $complaint->solutions()->sync($validated['solution_ids']);
            
            // Increment usage count for each solution
            Solution::whereIn('id', $validated['solution_ids'])
                ->increment('usage_count');
        }

        return back()->with('success', 'Respon berhasil dikirim');
    }
}