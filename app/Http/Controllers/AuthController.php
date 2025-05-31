<?php

namespace App\Http\Controllers;

use App\Models\Peran;
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

        // Jika login berhasil
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika akun nonaktif
            if (Auth::user()->apakah_akun_nonaktif === 1) {
                // Langsung buat pengguna tidak bisa masuk/logout paksa
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Kembalikan ke halaman login dengan pesan kesalahan
                return back()->withErrors([
                    'failedLogin' => 'Akun Anda telah dinonaktifkan.'
                ]);
            }

            // Jika akun aktif arahkan ke halaman sesuai peran
            return $this->redirectUser();
        }

        // Jika login gagal berikan pesan kesalahan
        return back()->withErrors([
            'failedLogin' => 'Username atau password yang Anda masukkan salah.'
        ])->withInput();
    }

    // Metode untuk mengalihkan pengguna berdasarkan peran_id
    function redirectUser()
    {
        // Jika pengguna sudah login
        if (Auth::check()) {
            $peranIdList = Peran::pluck('id', 'nama_peran')->toArray();

            // Lakukan pengecekan setiap peran id
            // Lalu navigasi ke halaman dashboard sesuai peran
            switch (Auth::user()->peran_id) {
                case $peranIdList[Peran::PERAN_SUPERADMIN]:
                    return redirect()->route('superadmin.dashboard');
                case $peranIdList[Peran::PERAN_ADMIN]:
                    return redirect()->route('admin.dashboard');
                case $peranIdList[Peran::PERAN_RESPONDEN]:
                    return redirect()->route('responden.dashboard');
                case $peranIdList[Peran::PERAN_VERIFIKATOR]:
                    return redirect()->route('verifikator.dashboard');
                case $peranIdList[Peran::PERAN_MANAJEMEN]:
                    return redirect()->route('manajemen.dashboard');
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
