<?php

namespace App\Http\Controllers\SuperadminAdmin;

use App\Http\Controllers\Controller;
use App\Models\Peran;
use App\Models\Responden\Responden;
use App\Models\Responden\StatusHasilEvaluasi;
use App\Models\Responden\StatusProgresEvaluasiResponden;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KelolaRespondenController extends Controller
{

    public function index()
    {
        // Query terhas responden dengan relasi user
        $queryRespondenWithUser = Responden::with(['user.responden']);

        // Request cari
        if ($requestCari = request('cari')) {
            $queryRespondenWithUser->whereHas(
                'user',
                function ($query) use ($requestCari) {
                    $query->where('nama', 'like', '%' . $requestCari . '%')
                        ->orWhere('username', 'like', '%' . $requestCari . '%')
                        ->orWhere('email', 'like', '%' . $requestCari . '%')
                        ->orWhere('nomor_telepon', 'like', '%' . $requestCari . '%');
                }
            );
        }
        // Request daerah
        if (($requestDaerah = request('daerah')) && $requestDaerah !== 'semua') {
            $daerah = [
                'kabupaten-atau-kota' => 'Kabupaten/Kota',
                'provinsi' => 'Provinsi'
            ];
            $queryRespondenWithUser->where('daerah', $daerah[$requestDaerah]);
        }
        // Request akses evaluasi
        if (($requestAksesEvaluasi = request('akses-evaluasi')) && $requestAksesEvaluasi !== 'semua') {
            // Mengubah string ke boolean
            $aksesEvaluasi = filter_var($requestAksesEvaluasi, FILTER_VALIDATE_BOOLEAN);
            $queryRespondenWithUser->where('akses_evaluasi', $aksesEvaluasi);
        }

        // Request status akun
        if (($requestStatusAkun = request('status-akun')) && $requestStatusAkun !== 'semua') {
            // Mengubah string ke boolean
            $statusAkun = filter_var($requestStatusAkun, FILTER_VALIDATE_BOOLEAN);
            $queryRespondenWithUser->whereHas(
                'user',
                function ($query) use ($statusAkun) {
                    $query->where('apakah_akun_nonaktif', !$statusAkun);
                }
            );
        }

        // Menampilkan daftar responden
        $daftarResponden = $queryRespondenWithUser->latest()->paginate(10)->appends(request()->query());

        $totalDaftarDaerahResponden = Responden::selectRaw('daerah, COUNT(*) as total')
            ->groupBy('daerah')
            ->pluck('total', 'daerah');

        return view('pages.superadmin-admin.kelola-responden.index', [
            'title' => 'Kelola Responden',
            'daftarResponden' => $daftarResponden,
            'daftarDataCard' => [
                'totalResponden' => Responden::count(),
                'totalKabupatenKota' => $totalDaftarDaerahResponden['Kabupaten/Kota'] ?? 0,
                'totalProvinsi' => $totalDaftarDaerahResponden['Provinsi'] ?? 0,
            ]
        ]);
    }

    public function create()
    {
        return view('pages.superadmin-admin.kelola-responden.form', [
            'title' => 'Tambah Responden',
            'responden' => new User(),
            'page_meta' => [
                'route' => route('kelola-responden.store'),
                'method' => 'POST'
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validatedTambahResponden = $request->validate(
            [
                'nama' => ['required', 'max:255'],
                'daerah' => ['required', 'in:Kabupaten/Kota,Provinsi'],
                'username' => ['required', 'min:8', 'max:255', 'unique:users,username'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'nomor_telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:13', 'unique:users,nomor_telepon'],
                'alamat' => ['required', 'max:255'],
                'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
                'akses_evaluasi' => ['required', 'boolean']
            ]
        );
        // Memberikan peran nilai responden (3) secara default
        $validatedTambahResponden['peran_id'] = Peran::PERAN_RESPONDEN_ID;
        // Memberikan enkripsi pada password
        $validatedTambahResponden['password'] = Hash::make($validatedTambahResponden['password']);
        // Membuat user baru
        $user = User::create($validatedTambahResponden);

        // Membuat responden baru
        Responden::create([
            // Relasikan responden dengan user baru dibuat
            'user_id' => $user->id,
            'status_progres_evaluasi_responden_id' => StatusProgresEvaluasiResponden::TIDAK_MENGERJAKAN_ID,
            'akses_evaluasi' => $request->akses_evaluasi,
            'daerah' => $request->daerah,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('kelola-responden.index')->with('success', "Responden <b>$user->nama</b> berhasil ditambahkan");
    }

    public function show(string $id)
    {
        $responden = Responden::find($id);

        $daftarRiwayatEvaluasi = $responden->hasilEvaluasi
            ->where('status_hasil_evaluasi_id', StatusHasilEvaluasi::STATUS_DIVERIFIKASI_ID)
            ->sortByDesc('tanggal_diverifikasi')
            ->values();
        $daftarRiwayatEvaluasi->load([
            'nilaiEvaluasi',
            'verifikator.user'
        ]);

        return view('pages.superadmin-admin.kelola-responden.detail', [
            'title' => 'Detail Responden',
            'responden' => $responden,
            'daftarRiwayatEvaluasi' => $daftarRiwayatEvaluasi
        ]);
    }

    public function edit(string $id)
    {
        $responden = Responden::find($id);

        return view('pages.superadmin-admin.kelola-responden.form', [
            'title' => 'Edit Responden',
            'responden' => $responden,
            'page_meta' => [
                'route' => route('kelola-responden.update', $responden->id),
                'method' => 'PUT'
            ]
        ]);
    }

    public function update(Request $request, string $id)
    {
        $responden = Responden::find($id);

        $validatedEditResponden = $request->validate([
            'nama' => ['required', 'max:255'],
            'username' => [
                'required',
                'min:8',
                'max:255',
                Rule::unique('users', 'username')->ignore($responden->user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($responden->user->id),
            ],
            'nomor_telepon' => [
                'required',
                'max:255',
                'min:10',
                'max:13',
                'regex:/^[0-9]+$/',
                Rule::unique('users', 'nomor_telepon')->ignore($responden->user->id),
            ],
            'alamat' => ['required', 'max:255'],
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

        $responden->user->update($validatedEditResponden);
        $responden->update([
            'daerah' => $request->daerah,
            'akses_evaluasi' => $request->akses_evaluasi
        ]);

        return redirect()->route('kelola-responden.index')->with('success', "Responden <b>" . $responden->user->nama . "</b> berhasil diperbarui");
    }

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
