<?php

namespace App\Http\Controllers;

use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function index()
    {
        // Alihkan ke fungsi redirectUser
        return $this->redirectUser();
    }

    function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            // 'g-recaptcha-response' => ['required', new Recaptcha]
        ]);

        // Lakukan credentials hanya untuk username dan password (abaikan captcha)
        $credentials = $request->only('username', 'password');

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika akun nonaktif
            if (Auth::user()->apakah_akun_nonaktif === 1) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'failedLogin' => 'Akun Anda telah dinonaktifkan.'
                ]);
            }

            return $this->redirectUser();
        }

        return back()->withErrors([
            'failedLogin' => 'Username atau password yang Anda masukkan salah.'
        ])->withInput();
    }

    // Metode untuk mengalihkan pengguna berdasarkan peran_id
    function redirectUser()
    {
        // Jika pengguna sudah login
        if (Auth::check()) {
            // Lakukan pengecekan setiap peran id
            switch (Auth::user()->peran_id) {
                case 1:
                    return redirect()->route('admin.dashboard');
                case 2:
                    return redirect('/verifikator/dashboard');
                case 3:
                    return redirect()->route('responden.dashboard');
                default:
                    break;
            }
        }

        // Jika pengguna belum login
        return view('pages.login');
    }

    function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
