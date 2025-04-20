<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Responden\Responden;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KelolaRespondenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Query terhas user dengan relasi responden
        $queryUserResponden = User::whereHas('responden')->with('responden');

        // Request cari
        if ($requestCari = request('cari')) {
            $queryUserResponden->where(function ($query) use ($requestCari) {
                $query->where('nama', 'like', '%' . $requestCari . '%')
                    ->orWhere('username', 'like', '%' . $requestCari . '%')
                    ->orWhere('email', 'like', '%' . $requestCari . '%')
                    ->orWhere('nomor_telepon', 'like', '%' . $requestCari . '%');
            });
        }
        // Request daerah
        if (($requestDaerah = request('daerah')) && $requestDaerah !== 'semua') {
            $daerah = [
                'kabupaten-atau-kota' => 'Kabupaten/Kota',
                'provinsi' => 'Provinsi'
            ];
            $queryUserResponden->whereHas(
                'responden',
                fn($query) => $query->where('daerah', $daerah[$requestDaerah])
            );
        }
        // Request akses evaluasi
        if (($requestAksesEvaluasi = request('akses-evaluasi')) && $requestAksesEvaluasi !== 'semua') {
            // Mengubah string ke boolean
            $aksesEvaluasi = filter_var($requestAksesEvaluasi, FILTER_VALIDATE_BOOLEAN);
            $queryUserResponden->whereHas(
                'responden',
                fn($query) => $query->where('akses_evaluasi', $aksesEvaluasi)
            );
        }

        // Request status akun
        if (($requestStatusAkun = request('status-akun')) && $requestStatusAkun !== 'semua') {
            // Mengubah string ke boolean
            $statusAkun = filter_var($requestStatusAkun, FILTER_VALIDATE_BOOLEAN);
            $queryUserResponden->whereHas(
                'responden',
                fn($query) => $query->where('apakah_akun_nonaktif', !$statusAkun)
            );
        }

        // Menampilkan daftar responden
        $daftarResponden = $queryUserResponden->latest()->paginate(10);

        $totalDaftarDaerahResponden = Responden::selectRaw('daerah, COUNT(*) as total')
            ->groupBy('daerah')
            ->pluck('total', 'daerah');

        return view('pages.admin.kelola-responden.index', [
            'title' => 'Kelola Responden',
            'daftarResponden' => $daftarResponden,
            'daftarDataCard' => [
                'totalResponden' => Responden::count(),
                'totalKabupatenKota' => $totalDaftarDaerahResponden['Kabupaten/Kota'] ?? 0,
                'totalProvinsi' => $totalDaftarDaerahResponden['Provinsi'] ?? 0,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.kelola-responden.form', [
            'title' => 'Tambah Responden',
            'responden' => new User(),
            'page_meta' => [
                'route' => route('kelola-responden.store'),
                'method' => 'POST'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedTambahResponden = $request->validate(
            [
                'nama' => ['required', 'max:255'],
                'daerah' => ['required', 'in:Kabupaten/Kota,Provinsi'],
                'username' => ['required', 'min:8', 'max:255', 'unique:users,username'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'nomor_telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:13', 'unique:users,nomor_telepon'],
                'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
                'akses_evaluasi' => ['required', 'boolean']
            ]
        );
        // Memberikan peran nilai responden (3) secara default
        $validatedTambahResponden['peran_id'] = 3;
        // Memberikan enkripsi pada password
        $validatedTambahResponden['password'] = Hash::make($validatedTambahResponden['password']);

        $user = User::create($validatedTambahResponden);

        // Menambahkan data responden yg dibuat ke table responden
        Responden::create([
            'user_id' => $user->id,
            'akses_evaluasi' => $request->akses_evaluasi,
            'daerah' => $request->daerah
        ]);

        return redirect()->route('kelola-responden.index')->with('success', "Responden <b>$user->nama</b> berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)
            ->where('peran_id', 3)->firstOrFail();

        return view('pages.admin.kelola-responden.detail', [
            'title' => 'Detail Responden',
            'responden' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::where('id', $id)
            ->where('peran_id', 3)->firstOrFail();

        return view('pages.admin.kelola-responden.form', [
            'title' => 'Edit Responden',
            'responden' => $user,
            'page_meta' => [
                'route' => route('kelola-responden.update', $user->id),
                'method' => 'PUT'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $validatedEditResponden = $request->validate([
            'nama' => ['required', 'max:255'],
            'username' => [
                'required',
                'min:8',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'nomor_telepon' => [
                'required',
                'max:255',
                'min:10',
                'max:13',
                'regex:/^[0-9]+$/',
                Rule::unique('users', 'nomor_telepon')->ignore($user->id),
            ],
            'password' => [
                'nullable',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
            ],
            'akses_evaluasi' => ['required', 'boolean']
        ]);

        // Jika terdapat password baru
        if ($validatedEditResponden['password']) {
            $validatedEditResponden['password'] = Hash::make($validatedEditResponden['password']);
        } else {
            unset($validatedEditResponden['password']);
        }

        $user->update($validatedEditResponden);
        $user->responden->update([
            'daerah' => $request->daerah,
            'akses_evaluasi' => $request->akses_evaluasi
        ]);

        return redirect()->route('kelola-responden.index')->with('success', "Responden <b>$user->nama</b> berhasil diperbarui");
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

        return redirect()->route('kelola-responden.index')
            ->with('success', "Responden <b>$user->nama</b> berhasil di$apakahAkunNonaktifMessage");
    }
}
