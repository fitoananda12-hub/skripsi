<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.complaints.index', compact('complaints'));
    }

    public function create()
    {
        $problemTypes = [
            'Tidak Merekat dengan Baik',
            'Cepat Kering',
            'Bau Menyengat',
            'Kemasan Rusak',
            'Konsistensi Tidak Sesuai',
            'Warna Berubah',
            'Bocor',
            'Lainnya',
        ];

        return view('user.complaints.create', compact('problemTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'problem_type' => ['required', 'string'],
            'description' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
        ], [
            'product_name.required' => 'Nama produk harus diisi',
            'problem_type.required' => 'Jenis masalah harus dipilih',
            'description.required' => 'Deskripsi keluhan harus diisi',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
            'incident_date.required' => 'Tanggal kejadian harus diisi',
            'incident_date.before_or_equal' => 'Tanggal kejadian tidak boleh melebihi hari ini',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'user_id' => auth()->id(),
            'product_name' => $validated['product_name'],
            'problem_type' => $validated['problem_type'],
            'description' => $validated['description'],
            'photo' => $photoPath,
            'incident_date' => $validated['incident_date'],
            'status' => 'submitted',
            'priority' => 'medium',
        ]);

        return redirect()->route('user.complaints.show', $complaint)
            ->with('success', 'Keluhan berhasil diajukan dengan nomor: ' . $complaint->complaint_number);
    }

    public function show(Complaint $complaint)
    {
        // Ensure user can only view their own complaints
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $complaint->load(['assignedAdmin', 'solutions']);

        return view('user.complaints.show', compact('complaint'));
    }
}