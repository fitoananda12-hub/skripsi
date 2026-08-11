<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')->withCount('complaints');

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status registrasi
        if ($request->filled('registration_status')) {
            $query->where('registration_status', $request->registration_status);
        }

        // Filter by status aktif
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $users = $query->latest()->paginate(15);

        $totalUsers    = User::where('role', 'user')->count();
        $activeUsers   = User::where('role', 'user')->where('is_active', true)->where('registration_status', 'approved')->count();
        $inactiveUsers = User::where('role', 'user')->where('is_active', false)->where('registration_status', 'approved')->count();
        $pendingUsers  = User::where('role', 'user')->where('registration_status', 'pending')->count();
        $rejectedUsers = User::where('role', 'user')->where('registration_status', 'rejected')->count();

        return view('admin.users.index', compact(
            'users', 'totalUsers', 'activeUsers', 'inactiveUsers', 'pendingUsers', 'rejectedUsers'
        ));
    }

    public function show(User $user)
    {
        $user->load('approvedBy', 'complaints');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Setujui (approve) pendaftaran user
     */
    public function approve(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat mengubah status akun admin');
        }

        $user->update([
            'registration_status' => 'approved',
            'is_active'           => true,
            'approved_at'         => now(),
            'approved_by'         => Auth::id(),
            'rejection_reason'    => null,
        ]);

        return back()->with('success', "Pendaftaran {$user->name} ({$user->nik}) berhasil disetujui. User sekarang dapat login.");
    }

    /**
     * Tolak (reject) pendaftaran user
     */
    public function reject(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat mengubah status akun admin');
        }

        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan harus diisi',
        ]);

        $user->update([
            'registration_status' => 'rejected',
            'is_active'           => false,
            'rejection_reason'    => $request->rejection_reason,
        ]);

        return back()->with('success', "Pendaftaran {$user->name} berhasil ditolak.");
    }

    /**
     * Toggle status aktif/nonaktif user (hanya untuk user yang sudah approved)
     */
    public function toggleStatus(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat mengubah status akun admin');
        }

        if (!$user->isApproved()) {
            return back()->with('error', 'Hanya user yang sudah diverifikasi yang dapat diaktifkan/dinonaktifkan');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$user->name} berhasil {$status}");
    }

    /**
     * Hapus akun user
     */
    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun admin');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "Akun {$name} berhasil dihapus dari sistem.");
    }
}