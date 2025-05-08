<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\HasilEvaluasi;
use App\Models\Evaluasi\StatusHasilEvaluasi;
use App\Models\Responden\IdentitasResponden;
use App\Models\Responden\NilaiEvaluasi;
use App\Models\Responden\Responden;
use App\Models\Responden\StatusEvaluasi;
use App\Models\Responden\StatusProgresEvaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class IdentitasRespondenController extends Controller
{

    public function create()
    {
        $user = Auth::user();
        $responden = $user->responden;

        // Responden dilarang mengakses halaman ini jika bukan memulai evaluasi
        abort_if(
            $responden->statusProgresEvaluasi->status_progres_evaluasi !== StatusProgresEvaluasi::BELUM_MEMULAI,
            403
        );

        return view('pages.evaluasi.identitas-responden', [
            'title' => 'Identitas Responden',
            'identitasResponden' => new IdentitasResponden([
                'nomor_telepon' => $user->nomor_telepon,
                'email' => $user->email
            ]),
            'pageMeta' => [
                'route' => route('responden.evaluasi.identitas-responden.store'),
                'method' => 'POST'
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
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
            'nomor_telepon' => $validatedData['nomor_telepon'],
            'email' => $validatedData['email'],
            'pengisi_lembar_evaluasi' => $validatedData['pengisi_lembar_evaluasi'],
            'jabatan' => $validatedData['jabatan'],
            'tanggal_pengisian' => now(),
            'deskripsi_ruang_lingkup' => $request->deskripsi_ruang_lingkup,
        ]);

        $nilaiEvaluasi = NilaiEvaluasi::create([
            'responden_id' => $responden->id,
        ]);

        $hasilEvaluasi = HasilEvaluasi::create([
            'responden_id' => $responden->id,
            'identitas_responden_id' => $IdentitasResponden->id,
            'nilai_evaluasi_id' => $nilaiEvaluasi->id,
            'status_hasil_evaluasi_id' => StatusHasilEvaluasi::where(
                'status_hasil_evaluasi',
                StatusHasilEvaluasi::STATUS_DIKERJAKAN
            )->value('id')
        ]);

        $responden->update([
            'status_progres_evaluasi_id' => StatusProgresEvaluasi::where(
                'status_progres_evaluasi',
                StatusProgresEvaluasi::SEDANG_MENGERJAKAN
            )->value('id')
        ]);

        return redirect()->route('responden.evaluasi.pertanyaan', [1, $hasilEvaluasi->id]);
    }

    public function edit(IdentitasResponden $identitasResponden)
    {
        abort_if($identitasResponden->responden_id !== Auth::user()->responden->id, 403);

        return view('pages.evaluasi.identitas-responden', [
            'title' => 'Identitas Responden',
            'identitasResponden' => $identitasResponden,
            'hasilEvaluasi' => $identitasResponden->hasilEvaluasi,
            'pageMeta' => [
                'route' => route('responden.evaluasi.identitas-responden.update', $identitasResponden->id),
                'method' => 'PUT'
            ],
            'daftarAreaEvaluasiUtama' => AreaEvaluasi::all()
        ]);
    }

    public function update(Request $request, IdentitasResponden $identitasResponden)
    {
        $validatedData = $request->validate([
            'nomor_telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:13'],
            'email' => ['required', 'email'],
            'pengisi_lembar_evaluasi' => ['required', 'max:255'],
            'jabatan' => ['required', 'max:255'],
            'deskripsi_ruang_lingkup' => ['required'],
        ]);

        $identitasResponden->update([
            'nomor_telepon' => $validatedData['nomor_telepon'],
            'email' => $validatedData['email'],
            'pengisi_lembar_evaluasi' => $validatedData['pengisi_lembar_evaluasi'],
            'jabatan' => $validatedData['jabatan'],
            'deskripsi_ruang_lingkup' => $validatedData['deskripsi_ruang_lingkup']
        ]);

        return redirect()->back()->with('success', 'Data identitas berhasil diperbarui!');
    }
}
