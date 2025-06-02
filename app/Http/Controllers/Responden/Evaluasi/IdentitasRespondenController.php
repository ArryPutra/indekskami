<?php

namespace App\Http\Controllers\Responden\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Responden\NilaiEvaluasiUtama;
use App\Models\Responden\NilaiEvaluasiUtamaResponden;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\StatusHasilEvaluasi;
use App\Models\Responden\IdentitasResponden;
use App\Models\Responden\NilaiEvaluasi;
use App\Models\Responden\StatusProgresEvaluasiResponden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IdentitasRespondenController extends Controller
{

    public function create()
    {
        $user = Auth::user();
        $responden = $user->responden;

        // Responden dilarang mengakses halaman ini jika bukan belum mengerjakan evaluasi
        abort_if(
            $responden->statusProgresEvaluasiResponden->nama_status_progres_evaluasi_responden !== StatusProgresEvaluasiResponden::TIDAK_MENGERJAKAN,
            403
        );

        return view('pages.responden.evaluasi.identitas-responden', [
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

        $hasilEvaluasi = DB::transaction(function () use ($request, $responden, $validatedData) {
            $identitasResponden = IdentitasResponden::create([
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

            foreach (NilaiEvaluasiUtama::all() as $nilaiEvaluasiUtama) {
                NilaiEvaluasiUtamaResponden::create([
                    'nilai_evaluasi_id' => $nilaiEvaluasi->id,
                    'nilai_evaluasi_utama_id' => $nilaiEvaluasiUtama->id,
                    'total_skor' => 0,
                    'status_tingkat_kematangan' => PertanyaanEvaluasiUtama::TINGKAT_KEMATANGAN_I
                ]);
            }

            $hasilEvaluasi = HasilEvaluasi::create([
                'responden_id' => $responden->id,
                'identitas_responden_id' => $identitasResponden->id,
                'nilai_evaluasi_id' => $nilaiEvaluasi->id,
                'status_hasil_evaluasi_id' => StatusHasilEvaluasi::where(
                    'nama_status_hasil_evaluasi',
                    StatusHasilEvaluasi::STATUS_DIKERJAKAN
                )->value('id'),
                'evaluasi_ke' => $responden->hasilEvaluasi->count() + 1
            ]);

            $responden->update([
                'status_progres_evaluasi_responden_id' => StatusProgresEvaluasiResponden::SEDANG_MENGERJAKAN_ID
            ]);

            return $hasilEvaluasi;
        });


        return redirect()->route('responden.evaluasi.pertanyaan', [1, $hasilEvaluasi->id]);
    }

    public function edit(IdentitasResponden $identitasResponden)
    {
        abort_if($identitasResponden->responden_id !== Auth::user()->responden->id, 403);

        return view('pages.responden.evaluasi.identitas-responden', [
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
