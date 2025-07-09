<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan form login admin backend.
     */
    public function loginBackend()
    {
        return view('backend.auth.login', [
            'judul' => 'Login',
        ]);
    }

    /**
     * Proses autentikasi admin.
     */
    public function authenticateBackend(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Gunakan guard 'admin' sesuai konfigurasi
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            // Cek apakah admin diblokir
            if ($admin->blokir === 'Y') {
                Auth::guard('admin')->logout();
                return back()->with('error', 'Akun Anda diblokir.');
            }

            // Regenerasi session
            $request->session()->regenerate();

            return redirect()->intended(route('backend.dashboard'));
        }

        return back()->with('error', 'Username atau password salah.');
    }

    /**
     * Logout admin dari backend.
     */
    public function logoutBackend()
    {
        Auth::guard('admin')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect(route('login'))->with('success', 'Anda telah berhasil logout.');
    }
}
