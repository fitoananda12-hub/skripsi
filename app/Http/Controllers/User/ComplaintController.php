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
            'customer_name'      => ['required', 'string', 'max:255'],
            'product_name'       => ['required', 'string', 'max:255'],
            'problem_type'       => ['required', 'string'],
            'problem_type_custom'=> ['nullable', 'string', 'max:100', 'required_if:problem_type,Lainnya'],
            'description'        => ['required', 'string'],
            'media'              => ['nullable', 'array'],
            'media.*'            => ['file', 'mimes:jpeg,png,jpg,mp4,mov', 'max:10240'],
            'incident_date'      => ['required', 'date', 'before_or_equal:today'],
        ], [
            'customer_name.required'       => 'Nama customer harus diisi',
            'product_name.required'        => 'Nama produk harus diisi',
            'problem_type.required'        => 'Jenis masalah harus dipilih',
            'problem_type_custom.required_if' => 'Silakan ketik jenis masalah Anda secara spesifik',
            'problem_type_custom.max'      => 'Jenis masalah maksimal 100 karakter',
            'description.required'         => 'Deskripsi keluhan harus diisi',
            'media.array'                  => 'File bukti harus berupa array',
            'media.*.file'                 => 'File bukti harus berupa file valid',
            'media.*.mimes'                => 'Format file harus berupa foto (jpeg, png, jpg) atau video (mp4, mov)',
            'media.*.max'                  => 'Ukuran file bukti maksimal 10MB',
            'incident_date.required'       => 'Tanggal kejadian harus diisi',
            'incident_date.before_or_equal'=> 'Tanggal kejadian tidak boleh melebihi hari ini',
        ]);

        // Jika pilih "Lainnya", gunakan teks custom sebagai nilai problem_type
        $finalProblemType = ($validated['problem_type'] === 'Lainnya' && !empty($validated['problem_type_custom']))
            ? trim($validated['problem_type_custom'])
            : $validated['problem_type'];

        $photoPaths = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $photoPaths[] = $file->store('complaints', config('filesystems.default'));
            }
        }

        $complaint = Complaint::create([
            'user_id'       => auth()->id(),
            'customer_name' => $validated['customer_name'],
            'product_name'  => $validated['product_name'],
            'problem_type'  => $finalProblemType,
            'description'   => $validated['description'],
            'photo'         => $photoPaths,
            'incident_date' => $validated['incident_date'],
            'status'        => 'submitted',
            'priority'      => 'medium',
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