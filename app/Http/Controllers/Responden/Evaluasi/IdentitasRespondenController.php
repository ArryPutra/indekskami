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

    public function index(HasilEvaluasi $hasilEvaluasi)
    {
        $responden = Auth::user()->responden;

        if (count($responden->hasilEvaluasi) > 0 && request()->is('responden/evaluasi/identitas-responden')) {
            return redirect()->route('responden.identitas-responden', $responden->hasilEvaluasi->last()->id);
        }

        $identitasResponden = $hasilEvaluasi->identitasResponden ?? new IdentitasResponden();

        return view('pages.responden.evaluasi.identitas-responden', [
            'title' => 'Identitas Responden',
            'identitasResponden' => $identitasResponden,
            'pageMeta' => [
                'route' => route('responden.identitas-responden.simpan'),
                'method' => 'POST'
            ]
        ]);
    }

    public function simpan(Request $request)
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
}
