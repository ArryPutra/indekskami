<?php

namespace App\Http\Controllers\SuperadminAdmin;

use App\Http\Controllers\Controller;
use App\Models\Manajemen\Manajemen;
use App\Models\Peran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KelolaManajemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Query terhas user dengan relasi manajemen
        $queryManajemenWithUser = Manajemen::with('user');

        // Request cari
        if ($requestCari = request('cari')) {
            $queryManajemenWithUser->whereHas(
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
            $queryManajemenWithUser->whereHas(
                'user',
                fn($query) => $query->where('apakah_akun_nonaktif', !$statusAkun)
            );
        }

        // Menampilkan daftar responden
        $daftarManajemen = $queryManajemenWithUser->latest()->paginate(10);

        return view('pages.superadmin-admin.kelola-manajemen.index', [
            'title' => 'Kelola Manajemen',
            'daftarManajemen' => $daftarManajemen,
            'daftarDataCard' => [
                'totalManajemen' => Manajemen::count()
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.superadmin-admin.kelola-manajemen.form', [
            'title' => 'Tambah Manajemen',
            'manajemen' => new User(),
            'page_meta' => [
                'route' => route('kelola-manajemen.store'),
                'method' => 'POST'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedTambahManajemen = $request->validate(
            [
                'nama' => ['required', 'max:255'],
                'username' => ['required', 'min:8', 'max:255', 'unique:users,username'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'nomor_telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:13', 'unique:users,nomor_telepon'],
                'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
            ]
        );
        // Memberikan peran nilai manajemen (1) secara default
        $manajemenPeranId = Peran::where('nama_peran', 'Manajemen')->first()->id;
        $validatedTambahManajemen['peran_id'] = $manajemenPeranId;
        // Memberikan enkripsi pada password
        $validatedTambahManajemen['password'] = Hash::make($validatedTambahManajemen['password']);

        $user = User::create($validatedTambahManajemen);

        // Menambahkan data manajemen yg dibuat ke table manajemen
        Manajemen::create([
            'user_id' => $user->id,
            'jabatan' => 'Kepala Manajemen Indeks KAMI'
        ]);

        return redirect()->route('kelola-manajemen.index')->with('success', "Manajemen <b>$user->nama</b> berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $manajemen = Manajemen::find($id);

        return view('pages.superadmin-admin.kelola-manajemen.detail', [
            'title' => 'Detail Manajemen',
            'manajemen' => $manajemen,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $manajemen = Manajemen::find($id);

        return view('pages.superadmin-admin.kelola-manajemen.form', [
            'title' => 'Edit Manajemen',
            'manajemen' => $manajemen,
            'page_meta' => [
                'route' => route('kelola-manajemen.update', $manajemen->id),
                'method' => 'PUT'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $manajemen = Manajemen::find($id);

        $validatedEditManajemen = $request->validate([
            'nama' => ['required', 'max:255'],
            'username' => [
                'required',
                'min:8',
                'max:255',
                Rule::unique('users', 'username')->ignore($manajemen->user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($manajemen->user->id),
            ],
            'nomor_telepon' => [
                'required',
                'max:255',
                'min:10',
                'max:13',
                'regex:/^[0-9]+$/',
                Rule::unique('users', 'nomor_telepon')->ignore($manajemen->user->id),
            ],
            'jabatan' => ['required', 'max:255'],
            'password' => ['nullable', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
        ]);

        // Jika terdapat password baru
        if ($validatedEditManajemen['password']) {
            $validatedEditManajemen['password'] = Hash::make($validatedEditManajemen['password']);
        } else {
            unset($validatedEditManajemen['password']);
        }

        $manajemen->user->update($validatedEditManajemen);
        $manajemen->update([
            'jabatan' => $validatedEditManajemen['jabatan']
        ]);

        return redirect()->route('kelola-manajemen.index')->with('success', "Manajemen <b>" . $manajemen->user->nama . "</b> berhasil diperbarui");
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

        return redirect()->route('kelola-manajemen.index')
            ->with('success', "Manajemen <b>$user->nama</b> berhasil di$apakahAkunNonaktifMessage");
    }
}
