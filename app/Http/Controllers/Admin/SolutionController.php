<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solution;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function index(Request $request)
    {
        $query = Solution::with('creator');

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('problem_category', 'like', '%' . $request->search . '%')
                  ->orWhere('solution_description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by active status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $solutions = $query->latest()->paginate(15);

        $totalSolutions = Solution::count();
        $activeSolutions = Solution::where('is_active', true)->count();
        $totalUsage = Solution::sum('usage_count');

        return view('admin.solutions.index', compact('solutions', 'totalSolutions', 'activeSolutions', 'totalUsage'));
    }

    public function create()
    {
        $problemCategories = [
            'Daya Rekat Lemah',
            'Pengeringan Cepat',
            'Bau Tidak Sedap',
            'Kemasan Rusak',
            'Konsistensi Tidak Sesuai',
            'Perubahan Warna',
            'Kebocoran',
            'Lainnya',
        ];

        return view('admin.solutions.create', compact('problemCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'problem_category' => ['required', 'string'],
            'solution_description' => ['required', 'string'],
            'technical_steps' => ['nullable', 'string'],
            'prevention_tips' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ], [
            'title.required' => 'Judul solusi harus diisi',
            'problem_category.required' => 'Kategori masalah harus dipilih',
            'solution_description.required' => 'Deskripsi solusi harus diisi',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_active'] = $request->has('is_active');
        $validated['usage_count'] = 0;

        Solution::create($validated);

        return redirect()->route('admin.solutions.index')
            ->with('success', 'Solusi berhasil ditambahkan ke knowledge base');
    }

    public function show(Solution $solution)
    {
        $solution->load(['creator', 'complaints']);
        return view('admin.solutions.show', compact('solution'));
    }

    public function edit(Solution $solution)
    {
        $problemCategories = [
            'Daya Rekat Lemah',
            'Pengeringan Cepat',
            'Bau Tidak Sedap',
            'Kemasan Rusak',
            'Konsistensi Tidak Sesuai',
            'Perubahan Warna',
            'Kebocoran',
            'Lainnya',
        ];

        return view('admin.solutions.edit', compact('solution', 'problemCategories'));
    }

    public function update(Request $request, Solution $solution)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'problem_category' => ['required', 'string'],
            'solution_description' => ['required', 'string'],
            'technical_steps' => ['nullable', 'string'],
            'prevention_tips' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ], [
            'title.required' => 'Judul solusi harus diisi',
            'problem_category.required' => 'Kategori masalah harus dipilih',
            'solution_description.required' => 'Deskripsi solusi harus diisi',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $solution->update($validated);

        return redirect()->route('admin.solutions.index')
            ->with('success', 'Solusi berhasil diperbarui');
    }

    public function destroy(Solution $solution)
    {
        $solution->delete();

        return redirect()->route('admin.solutions.index')
            ->with('success', 'Solusi berhasil dihapus');
    }
}