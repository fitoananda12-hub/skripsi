<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // If user is already authenticated, redirect to their dashboard
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.dashboard');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email harus diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        // Verifikasi Cloudflare Turnstile
        if (!app()->environment('local')) {
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
        }

        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // ===== PENGECEKAN STATUS REGISTRASI =====
            
            // Blok jika masih menunggu persetujuan admin
            if ($user->isPending()) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda masih menunggu verifikasi oleh administrator. Silakan hubungi admin jika sudah lama menunggu.',
                ]);
            }

            // Blok jika pendaftaran ditolak
            if ($user->isRejected()) {
                Auth::logout();
                $reason = $user->rejection_reason 
                    ? 'Alasan: ' . $user->rejection_reason 
                    : 'Silakan hubungi administrator untuk informasi lebih lanjut.';
                throw ValidationException::withMessages([
                    'email' => 'Pendaftaran akun Anda telah ditolak. ' . $reason,
                ]);
            }

            // ===== PENGECEKAN STATUS AKTIF =====
            if (!$user->is_active) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.',
                ]);
            }

            // Redirect berdasarkan role
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang, ' . $user->name);
            }

            return redirect()->intended(route('user.dashboard'))
                ->with('success', 'Selamat datang, ' . $user->name);
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')
            ->with('success', 'Anda telah berhasil logout');
    }
}