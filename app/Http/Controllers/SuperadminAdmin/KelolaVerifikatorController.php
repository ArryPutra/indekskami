<?php

namespace App\Http\Controllers\SuperadminAdmin;

use App\Http\Controllers\Controller;
use App\Models\Peran;
use App\Models\User;
use App\Models\Verifikator\Verifikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KelolaVerifikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Query terhas user dengan relasi verifikator
        $queryVerifikatorWithUser = Verifikator::with('user');

        // Request cari
        if ($requestCari = request('cari')) {
            $queryVerifikatorWithUser->whereHas(
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
            $queryVerifikatorWithUser->whereHas(
                'user',
                fn($query) => $query->where('apakah_akun_nonaktif', !$statusAkun)
            );
        }

        // Menampilkan daftar verifikator
        $daftarVerifikator = $queryVerifikatorWithUser->latest()->paginate(10);

        return view('pages.superadmin-admin.kelola-verifikator.index', [
            'title' => 'Kelola Verifikator',
            'daftarVerifikator' => $daftarVerifikator,
            'daftarDataCard' => [
                'totalVerifikator' => Verifikator::count()
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.superadmin-admin.kelola-verifikator.form', [
            'title' => 'Tambah Verifikator',
            'verifikator' => new User(),
            'page_meta' => [
                'route' => route('kelola-verifikator.store'),
                'method' => 'POST'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedTambahVerifikator = $request->validate(
            [
                'nama' => ['required', 'max:255'],
                'username' => ['required', 'min:8', 'max:255', 'unique:users,username'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'nomor_telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:13', 'unique:users,nomor_telepon'],
                'nomor_sk' => ['required'],
                'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
            ]
        );
        // Memberikan peran nilai verifikator (2) secara default
        $verifikatorPeranId = Peran::where('nama_peran', 'Verifikator')->first()->id;
        $validatedTambahVerifikator['peran_id'] = $verifikatorPeranId;
        // Memberikan enkripsi pada password
        $validatedTambahVerifikator['password'] = Hash::make($validatedTambahVerifikator['password']);

        $user = User::create($validatedTambahVerifikator);

        // Menambahkan data verifikator yg dibuat ke table verifikator
        Verifikator::create([
            'user_id' => $user->id,
            'nomor_sk' => $request->nomor_sk,
        ]);

        return redirect()->route('kelola-verifikator.index')->with('success', "Verifikator <b>$user->nama</b> berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $verifikator = Verifikator::find($id);

        return view('pages.superadmin-admin.kelola-verifikator.detail', [
            'title' => 'Detail Verifikator',
            'verifikator' => $verifikator,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $verifikator = Verifikator::find($id);

        return view('pages.superadmin-admin.kelola-verifikator.form', [
            'title' => 'Edit Verifikator',
            'verifikator' => $verifikator,
            'page_meta' => [
                'route' => route('kelola-verifikator.update', $verifikator->id),
                'method' => 'PUT'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $verifikator = Verifikator::find($id);

        $validatedEditVerifikator = $request->validate([
            'nama' => ['required', 'max:255'],
            'username' => [
                'required',
                'min:8',
                'max:255',
                Rule::unique('users', 'username')->ignore($verifikator->user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($verifikator->user->id),
            ],
            'nomor_telepon' => [
                'required',
                'max:255',
                'min:10',
                'max:13',
                'regex:/^[0-9]+$/',
                Rule::unique('users', 'nomor_telepon')->ignore($verifikator->user->id),
            ],
            'password' => ['nullable', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
        ]);

        // Jika terdapat password baru
        if ($validatedEditVerifikator['password']) {
            $validatedEditVerifikator['password'] = Hash::make($validatedEditVerifikator['password']);
        } else {
            unset($validatedEditVerifikator['password']);
        }

        $verifikator->user->update($validatedEditVerifikator);
        $verifikator->update([
            'nomor_sk' => $request->nomor_sk,
        ]);

        return redirect()->route('kelola-verifikator.index')->with('success', "Verifikator <b>" . $verifikator->user->nama . "</b> berhasil diperbarui");
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

        return redirect()->route('kelola-verifikator.index')
            ->with('success', "Verifikator <b>$user->nama</b> berhasil di$apakahAkunNonaktifMessage");
    }
}
