<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        // If user is already authenticated, redirect to their dashboard
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.dashboard');
        }
        
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nik'      => ['required', 'string', 'max:50', 'unique:users'],
            'jabatan'  => ['required', 'string', 'max:100'],
            'departemen' => ['required', 'string', 'max:100'],
            'phone'    => ['required', 'string', 'max:20'],
            'address'  => ['required', 'string'],
            'password' => [
                'required', 
                'confirmed', 
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ], [
            'name.required'      => 'Nama lengkap harus diisi',
            'email.required'     => 'Email harus diisi',
            'email.email'        => 'Format email tidak valid',
            'email.unique'       => 'Email sudah terdaftar',
            'nik.required'       => 'NIK Karyawan harus diisi',
            'nik.unique'         => 'NIK sudah terdaftar, jika ini milik Anda hubungi administrator',
            'jabatan.required'   => 'Jabatan harus diisi',
            'departemen.required'=> 'Departemen harus diisi',
            'phone.required'     => 'Nomor telepon harus diisi',
            'address.required'   => 'Alamat harus diisi',
            'password.required'  => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min'       => 'Password minimal 8 karakter',
            'password.letters'   => 'Password harus mengandung minimal satu huruf',
            'password.mixed'     => 'Password harus mengandung kombinasi huruf besar dan kecil',
            'password.numbers'   => 'Password harus mengandung minimal satu angka',
            'password.symbols'   => 'Password harus mengandung minimal satu simbol',
            'password.uncompromised' => 'Password ini terdeteksi pernah bocor di internet, silakan gunakan password lain demi keamanan',
        ]);

        // Verifikasi Cloudflare Turnstile
        $turnstileResponse = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret'   => config('services.turnstile.secret_key'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$turnstileResponse->json('success')) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Verifikasi keamanan gagal. Silakan coba lagi.',
            ]);
        }

        // Buat akun dengan status PENDING - menunggu persetujuan admin
        User::create([
            'name'                => $validated['name'],
            'email'               => $validated['email'],
            'nik'                 => $validated['nik'],
            'jabatan'             => $validated['jabatan'],
            'departemen'          => $validated['departemen'],
            'phone'               => $validated['phone'],
            'address'             => $validated['address'],
            'password'            => Hash::make($validated['password']),
            'role'                => 'user',
            'is_active'           => false,          // Nonaktif sampai admin approve
            'registration_status' => 'pending',      // Harus disetujui admin
            'email_verified_at'   => null,            // Belum diverifikasi
        ]);

        // TIDAK langsung login - arahkan ke halaman menunggu verifikasi
        return redirect()->route('register.pending')
            ->with('registered_name', $validated['name'])
            ->with('registered_email', $validated['email']);
    }

    public function showPendingPage()
    {
        return view('auth.register-pending');
    }
}