<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        return view('pages.superadmin.profil', [
            'title' => 'Profil',
            'user' => Auth::user()
        ]);
    }

    public function perbaruiPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8||confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        $user->password = Hash::make($request->password_baru);

        return redirect()->route('superadmin.profil')->with('success', 'Password berhasil diperbarui');
    }
}
