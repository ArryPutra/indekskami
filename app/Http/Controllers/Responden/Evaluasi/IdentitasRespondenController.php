<?php

namespace App\Http\Controllers\Responden\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Responden\IdentitasResponden;
use App\Models\Responden\NilaiEvaluasi;
use App\Models\Responden\Responden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdentitasRespondenController extends Controller
{

    public function create()
    {
        $responden = Auth::user()->responden;

        if ($responden->status_evaluasi !== Responden::STATUS_BELUM) {
            return abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        return view('pages.responden.evaluasi.identitas-responden', [
            'title' => 'Identitas Responden',
            'identitasResponden' => new IdentitasResponden(),
            'pageMeta' => [
                'route' => route('responden.identitas-responden.store'),
                'method' => 'POST'
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'identitas_instansi' => ['required', 'in:Satuan Kerja,Direktorat,Departemen'],
            'alamat' => ['required'],
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
        ]);

        $user->responden->update([
            'status_evaluasi' => Responden::STATUS_MENGERJAKAN
        ]);

        return redirect()->route('responden.evaluasi.i-kategori-se', $HasilEvaluasi->id);
    }

    public function edit(IdentitasResponden $identitasResponden)
    {
        if ($identitasResponden->responden_id !== Auth::user()->responden->id) {
            return abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        return view('pages.responden.evaluasi.identitas-responden', [
            'title' => 'Identitas Responden',
            'identitasResponden' => $identitasResponden,
            'hasilEvaluasiId' => $identitasResponden->hasilEvaluasi->id,
            'pageMeta' => [
                'route' => route('responden.identitas-responden.update', $identitasResponden->id),
                'method' => 'PUT'
            ]
        ]);
    }

    public function update(Request $request, IdentitasResponden $identitasResponden)
    {
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
