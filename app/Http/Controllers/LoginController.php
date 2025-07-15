<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Tampilkan form login admin backend.
     */
    public function loginForm()
    {
        return view('backend.auth.login', [
            'judul' => 'Login',
        ]);
    }

    /**
     * Proses autentikasi admin.
     */
    public function unifiedLogin(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        if (Auth::guard('admin')->attempt(['username' => $login, 'password' => $password])) {
            return redirect()->route('backend.dashboard');
        }

        if (Auth::guard('web')->attempt(['email' => $login, 'password' => $password])) {
            return redirect()->route('home-page');
        }

        return back()->withErrors(['login' => 'Username/email atau password salah.']);
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

    public function logoutFrontend()
    {
        Auth::guard('web')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect(route('home-page'))->with('success', 'Anda telah berhasil logout.');
    }

    // Arahkan ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Simpan atau update user
            $user = User::updateOrCreate(
                ['google_id' => $googleUser->id],
                [
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                ]
            );

            Auth::login($user);
            session()->regenerate();

            return redirect()->route('home-page');
        } catch (\Throwable $th) {
            return redirect()->route('login')->with('error', 'Gagal login via Google.');
        }
    }
}
