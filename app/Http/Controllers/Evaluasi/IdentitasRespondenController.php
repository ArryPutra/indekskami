<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Responden\IdentitasResponden;
use App\Models\Responden\NilaiEvaluasi;
use App\Models\Responden\Responden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class IdentitasRespondenController extends Controller
{

    public function create()
    {
        $user = Auth::user();
        $responden = $user->responden;

        abort_if($responden->status_evaluasi !== Responden::STATUS_BELUM, 403);

        return view('pages.evaluasi.identitas-responden', [
            'title' => 'Identitas Responden',
            'identitasResponden' => new IdentitasResponden([
                'nomor_telepon' => $user->nomor_telepon,
                'email' => $user->email
            ]),
            'pageMeta' => [
                'route' => route('responden.identitas-responden.store'),
                'method' => 'POST'
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'identitas_instansi' => ['required', Rule::in(IdentitasResponden::getIdentitasOptions())],
            'alamat' => ['required'],
            'nomor_telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:13'],
            'email' => ['required', 'email'],
            'pengisi_lembar_evaluasi' => ['required', 'max:255'],
            'jabatan' => ['required', 'max:255'],
            'deskripsi_ruang_lingkup' => ['required'],
        ]);

        $user = Auth::user();
        $responden = $user->responden;

        $IdentitasResponden = IdentitasResponden::create([
            'responden_id' => $responden->id,
            'identitas_instansi' => $request->identitas_instansi,
            'alamat' => $request->alamat,
            'nomor_telepon' => $user->nomor_telepon,
            'email' => $user->email,
            'pengisi_lembar_evaluasi' => $request->pengisi_lembar_evaluasi,
            'jabatan' => $request->jabatan,
            'tanggal_pengisian' => now(),
            'deskripsi_ruang_lingkup' => $request->deskripsi_ruang_lingkup,
        ]);

        $nilaiEvaluasi = NilaiEvaluasi::create([
            'responden_id' => $responden->id,
            'identitas_responden_id' => $IdentitasResponden->id
        ]);

        $HasilEvaluasi = HasilEvaluasi::create([
            'responden_id' => $responden->id,
            'identitas_responden_id' => $IdentitasResponden->id,
            'nilai_evaluasi_id' => $nilaiEvaluasi->id,
            'status' => HasilEvaluasi::STATUS_DIKERJAKAN
        ]);

        $user->responden->update([
            'status_evaluasi' => Responden::STATUS_MENGERJAKAN
        ]);

        return redirect()->route('responden.evaluasi.i-kategori-se', $HasilEvaluasi->id);
    }

    public function edit(IdentitasResponden $identitasResponden)
    {
        abort_if($identitasResponden->responden_id !== Auth::user()->responden->id, 403);

        $daftarAreaEvaluasi = AreaEvaluasi::all();

        return view('pages.evaluasi.identitas-responden', [
            'title' => 'Identitas Responden',
            'identitasResponden' => $identitasResponden,
            'hasilEvaluasi' => $identitasResponden->hasilEvaluasi,
            'pageMeta' => [
                'route' => route('responden.identitas-responden.update', $identitasResponden->id),
                'method' => 'PUT'
            ],
            'daftarAreaEvaluasiUtama' => $daftarAreaEvaluasi->whereNotIn('id', [1, 8])
        ]);
    }

    public function update(Request $request, IdentitasResponden $identitasResponden)
    {
        $request->validate([
            'identitas_instansi' => ['required', Rule::in(IdentitasResponden::getIdentitasOptions())],
            'alamat' => ['required'],
            'nomor_telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:13'],
            'email' => ['required', 'email'],
            'pengisi_lembar_evaluasi' => ['required', 'max:255'],
            'jabatan' => ['required', 'max:255'],
            'deskripsi_ruang_lingkup' => ['required'],
        ]);

        $identitasResponden->update([
            'identitas_instansi' => $request->identitas_instansi,
            'alamat' => $request->alamat,
            'pengisi_lembar_evaluasi' => $request->pengisi_lembar_evaluasi,
            'jabatan' => $request->jabatan,
            'deskripsi_ruang_lingkup' => $request->deskripsi_ruang_lingkup
        ]);

        return redirect()->back()->with('success', 'Data identitas berhasil diperbarui!');
    }
}
