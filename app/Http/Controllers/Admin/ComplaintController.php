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
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%')
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
            'returned' => Complaint::where('status', 'returned')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
        ];

        return view('admin.complaints.index', compact('complaints', 'admins', 'statusCounts'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['user', 'assignedAdmin', 'solutions']);

        return view('admin.complaints.show', compact('complaint'));
    }

    public function edit(Complaint $complaint)
    {
        $complaint->load('solutions');
        $admins = User::whereIn('role', ['admin', 'admin-lab', 'admin-sales'])
              ->where('name', '!=', 'Super Admin')
              ->get();
        $solutions = Solution::where('is_active', true)->get();

        return view('admin.complaints.edit', compact('complaint', 'admins', 'solutions'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:submitted,in_progress,returned,resolved'],
            'priority' => ['required', 'in:low,medium,high'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'admin_response' => ['nullable', 'string'],
            'solution_ids' => ['nullable', 'array'],
            'solution_ids.*' => ['exists:solutions,id'],
        ], [
            'status.required' => 'Status harus dipilih',
            'priority.required' => 'Prioritas harus dipilih',
        ]);

        // If status changed, update timestamps accordingly
        if ($validated['status'] === 'resolved') {
            $validated['resolved_at'] = $complaint->resolved_at ?? now();
            $validated['returned_at'] = null;
        } elseif ($validated['status'] === 'returned') {
            $validated['returned_at'] = $complaint->returned_at ?? now();
            $validated['resolved_at'] = $complaint->resolved_at ?? now();
        } else {
            $validated['resolved_at'] = null;
            $validated['returned_at'] = null;
        }

        // Remove solution_ids from validated data before update
        $solutionIds = $validated['solution_ids'] ?? [];
        unset($validated['solution_ids']);

        $complaint->update($validated);

        // Sync solutions from Knowledge Base
        $complaint->solutions()->sync($solutionIds);

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
            'status' => ['required', 'in:in_progress,returned,resolved'],
            'solution_ids' => ['nullable', 'array'],
            'solution_ids.*' => ['exists:solutions,id'],
        ], [
            'admin_response.required' => 'Respon harus diisi',
            'status.required' => 'Status harus dipilih',
        ]);

        $updateData = [
            'admin_response' => $validated['admin_response'],
            'status' => $validated['status'],
        ];

        if ($validated['status'] === 'resolved') {
            $updateData['resolved_at'] = $complaint->resolved_at ?? now();
            $updateData['returned_at'] = null;
        } elseif ($validated['status'] === 'returned') {
            $updateData['returned_at'] = $complaint->returned_at ?? now();
            $updateData['resolved_at'] = $complaint->resolved_at ?? now();
        } else {
            $updateData['resolved_at'] = null;
            $updateData['returned_at'] = null;
        }

        $complaint->update($updateData);

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