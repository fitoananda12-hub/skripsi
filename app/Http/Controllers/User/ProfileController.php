<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'nik' => ['required', 'string', 'max:50', 'unique:users,nik,' . $user->id],
            'jabatan' => ['required', 'string', 'max:100'],
            'departemen' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah digunakan',
            'nik.required' => 'NIK Karyawan harus diisi',
            'nik.unique' => 'NIK sudah digunakan',
            'jabatan.required' => 'Jabatan harus diisi',
            'departemen.required' => 'Departemen harus diisi',
            'phone.required' => 'Nomor telepon harus diisi',
            'address.required' => 'Alamat harus diisi',
            'current_password.required_with' => 'Password lama harus diisi jika ingin mengganti password',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok',
            'new_password.min' => 'Password baru minimal 8 karakter',
        ]);

        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->nik = $validated['nik'];
        $user->jabatan = $validated['jabatan'];
        $user->departemen = $validated['departemen'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];

        // Update password if provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
            }

            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}