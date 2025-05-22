<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Peran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KelolaAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Query terhas user dengan relasi admin
        $queryAdminWithUser = Admin::with('user');

        // Request cari
        if ($requestCari = request('cari')) {
            $queryAdminWithUser->whereHas(
                'user',
                function ($query) use ($requestCari) {
                    $query->where('nama', 'like', '%' . $requestCari . '%')
                        ->orWhere('username', 'like', '%' . $requestCari . '%')
                        ->orWhere('email', 'like', '%' . $requestCari . '%')
                        ->orWhere('nomor_telepon', 'like', '%' . $requestCari . '%');
                }
            );
        }

        // Request status akun
        if (($requestStatusAkun = request('status-akun')) && $requestStatusAkun !== 'semua') {
            // Mengubah string ke boolean
            $statusAkun = filter_var($requestStatusAkun, FILTER_VALIDATE_BOOLEAN);
            $queryAdminWithUser->whereHas(
                'user',
                fn($query) => $query->where('apakah_akun_nonaktif', !$statusAkun)
            );
        }

        // Menampilkan daftar responden
        $daftarAdmin = $queryAdminWithUser->latest()->paginate(10);

        return view('pages.superadmin.kelola-admin.index', [
            'title' => 'Kelola Admin',
            'daftarAdmin' => $daftarAdmin,
            'daftarDataCard' => [
                'totalAdmin' => Admin::count()
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.superadmin.kelola-admin.form', [
            'title' => 'Tambah Admin',
            'admin' => new User(),
            'page_meta' => [
                'route' => route('kelola-admin.store'),
                'method' => 'POST'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedTambahAdmin = $request->validate(
            [
                'nama' => ['required', 'max:255'],
                'username' => ['required', 'min:8', 'max:255', 'unique:users,username'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'nomor_telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:13', 'unique:users,nomor_telepon'],
                'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
            ]
        );
        // Memberikan peran nilai admin (1) secara default
        $adminPeranId = Peran::where('nama_peran', 'Admin')->first()->id;
        $validatedTambahAdmin['peran_id'] = $adminPeranId;
        // Memberikan enkripsi pada password
        $validatedTambahAdmin['password'] = Hash::make($validatedTambahAdmin['password']);

        $user = User::create($validatedTambahAdmin);

        // Menambahkan data admin yg dibuat ke table admin
        Admin::create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('kelola-admin.index')->with('success', "Admin <b>$user->nama</b> berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = Admin::find($id);

        return view('pages.superadmin.kelola-admin.detail', [
            'title' => 'Detail Admin',
            'admin' => $admin,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::find($id);

        return view('pages.superadmin.kelola-admin.form', [
            'title' => 'Edit Admin',
            'admin' => $admin,
            'page_meta' => [
                'route' => route('kelola-admin.update', $admin->id),
                'method' => 'PUT'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = Admin::find($id);

        $validatedEditAdmin = $request->validate([
            'nama' => ['required', 'max:255'],
            'username' => [
                'required',
                'min:8',
                'max:255',
                Rule::unique('users', 'username')->ignore($admin->user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($admin->user->id),
            ],
            'nomor_telepon' => [
                'required',
                'max:255',
                'min:10',
                'max:13',
                'regex:/^[0-9]+$/',
                Rule::unique('users', 'nomor_telepon')->ignore($admin->user->id),
            ],
            'password' => ['nullable', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
        ]);

        // Jika terdapat password baru
        if ($validatedEditAdmin['password']) {
            $validatedEditAdmin['password'] = Hash::make($validatedEditAdmin['password']);
        } else {
            unset($validatedEditAdmin['password']);
        }

        $admin->user->update($validatedEditAdmin);
        $admin->update([
            // 
        ]);

        return redirect()->route('kelola-admin.index')->with('success', "Admin <b>" . $admin->user->nama . "</b> berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $apakahAkunNonaktif = filter_var($request->apakah_akun_nonaktif, FILTER_VALIDATE_BOOLEAN);

        $user = User::find($id);
        $user->update([
            'apakah_akun_nonaktif' => $apakahAkunNonaktif
        ]);

        $apakahAkunNonaktifMessage = $apakahAkunNonaktif ? 'nonaktifkan' : 'aktifkan';

        return redirect()->route('kelola-admin.index')
            ->with('success', "Admin <b>$user->nama</b> berhasil di$apakahAkunNonaktifMessage");
    }
}