<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\NilaiEvaluasiUtama;
use App\Models\Evaluasi\NilaiEvaluasiUtamaResponden;
use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
use App\Models\Evaluasi\TipeEvaluasi;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\StatusHasilEvaluasi;
use App\Models\Peran;
use App\Models\Responden\NilaiEvaluasi;
use App\Models\Responden\StatusProgresEvaluasiResponden;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(HasilEvaluasi $hasilEvaluasi)
    {
        $hasilEvaluasi->load([
            'statusHasilEvaluasi',
            'responden.user',
            'identitasResponden',
            'nilaiEvaluasi.nilaiEvaluasiUtamaResponden.nilaiEvaluasiUtama'
        ]);

        $nilaiEvaluasi = $hasilEvaluasi->nilaiEvaluasi;

        $apakahEvaluasiDapatDikerjakan = false;
        $statusHasilEvaluasiId = $hasilEvaluasi->statusHasilEvaluasi->id;
        // Jika evaluasi sedang dikerjakan oleh responden
        if (
            $statusHasilEvaluasiId === StatusHasilEvaluasi::STATUS_DIKERJAKAN_ID
            && Auth::user()->peran_id === Peran::PERAN_RESPONDEN_ID
        ) {
            $apakahEvaluasiDapatDikerjakan = true;
        } // Jika evaluasi diperiksa oleh verifikator maka buat dapat evaluasi bisa dikerjakan
        else if (
            $statusHasilEvaluasiId === StatusHasilEvaluasi::STATUS_DITINJAU_ID
            && Auth::user()->peran_id === Peran::PERAN_VERIFIKATOR_ID
        ) {
            $apakahEvaluasiDapatDikerjakan = true;
        }

        return view('pages.evaluasi.dashboard.dashboard', [
            'title' => 'Dashboard Evaluasi',
            'responden' => $hasilEvaluasi->responden,
            'daftarAreaEvaluasi' => AreaEvaluasi::all(),
            'hasilEvaluasi' => $hasilEvaluasi,
            'hasilEvaluasiId' => $hasilEvaluasi->id,
            'statusHasilEvaluasiSaatIni' => $hasilEvaluasi->statusHasilEvaluasi->nama_status_hasil_evaluasi,
            'identitasResponden' => $hasilEvaluasi->identitasResponden,
            'nilaiEvaluasi' => $nilaiEvaluasi,
            'hasilEvaluasiAkhir' => $this->getHasilEvaluasiAkhir($nilaiEvaluasi->hasil_evaluasi_akhir),
            'tingkatKelengkapanIso' => NilaiEvaluasi::getTingkatKelengkapanIso($nilaiEvaluasi->tingkat_kelengkapan_iso),
            'daftarNilaiEvaluasiUtama' => NilaiEvaluasiUtamaResponden::getNilaiEvaluasiUtama($nilaiEvaluasi->nilaiEvaluasiUtamaResponden),
            'isResponden' => Auth::user()->peran->nama_peran === Peran::PERAN_RESPONDEN,
            'apakahEvaluasiDapatDikerjakan' => $apakahEvaluasiDapatDikerjakan,
            'progresEvaluasiTerjawab' => HasilEvaluasi::getProgresEvaluasiTerjawab($hasilEvaluasi),
        ]);
    }

    // Fungsi Milik -> Responden
    public function kirimEvaluasi(HasilEvaluasi $hasilEvaluasi)
    {
        DB::transaction(function () use ($hasilEvaluasi) {
            $hasilEvaluasi->update([
                'status_hasil_evaluasi_id' => StatusHasilEvaluasi::where('nama_status_hasil_evaluasi', 'Ditinjau')->value('id'),
                'tanggal_diserahkan' => Carbon::now()
            ]);

            $hasilEvaluasi->responden->update([
                'status_progres_evaluasi_responden_id' => StatusProgresEvaluasiResponden::where(
                    'nama_status_progres_evaluasi_responden',
                    StatusProgresEvaluasiResponden::SELESAI_MENGERJAKAN
                )->value('id'),
            ]);
        });

        return redirect()->route('responden.redirect-evaluasi');
    }

    // Fungsi Milik -> Admin & Verifikator
    public function verifikasiEvaluasi(Request $request, HasilEvaluasi $hasilEvaluasi)
    {
        // Memastikan bahwa verifikasi tidak dapat dilakukan jika status evaluasi bukan "ditinjau"
        abort_if($hasilEvaluasi->statusHasilEvaluasi->id
            !== StatusHasilEvaluasi::STATUS_DITINJAU_ID, 403);

        DB::transaction(function () use ($request, $hasilEvaluasi) {
            $hasilEvaluasi->update([
                'status_hasil_evaluasi_id' => StatusHasilEvaluasi::where(
                    'nama_status_hasil_evaluasi',
                    StatusHasilEvaluasi::STATUS_DIVERIFIKASI
                )->value('id'),
                'verifikator_id' => Auth::user()->verifikator->id,
                'tanggal_diverifikasi' => Carbon::now(),
                'catatan' => $request->catatan
            ]);

            $hasilEvaluasi->responden->update([
                'status_progres_evaluasi_responden_id' => StatusProgresEvaluasiResponden::where(
                    'nama_status_progres_evaluasi_responden',
                    StatusProgresEvaluasiResponden::TIDAK_MENGERJAKAN
                )->value('id')
            ]);
        });

        $namaResponden = $hasilEvaluasi->responden->user->nama;
        return redirect()->route('verifikator.kelola-evaluasi.perlu-ditinjau')
            ->with('success', "Evaluasi $namaResponden berhasil diverifikasi.");
    }

    public function revisiEvaluasi(Request $request, HasilEvaluasi $hasilEvaluasi)
    {
        // Revisi tidak dapat dilakukan jika status evaluasi "dikerjakan"
        abort_if($hasilEvaluasi->statusHasilEvaluasi->id
            === StatusHasilEvaluasi::STATUS_DIKERJAKAN_ID, 403);

        DB::transaction(function () use ($request, $hasilEvaluasi) {
            $hasilEvaluasi->update([
                'status_hasil_evaluasi_id' => StatusHasilEvaluasi::where(
                    'nama_status_hasil_evaluasi',
                    StatusHasilEvaluasi::STATUS_DIKERJAKAN
                )->value('id'),
                'verifikator_id' => Auth::user()->verifikator->id,
                'tanggal_diserahkan' => null,
                'tanggal_diverifikasi' => null,
                'catatan' => $request->catatan
            ]);


            $hasilEvaluasi->responden->update([
                'status_progres_evaluasi_responden_id' => StatusProgresEvaluasiResponden::where(
                    'nama_status_progres_evaluasi_responden',
                    StatusProgresEvaluasiResponden::SEDANG_MENGERJAKAN
                )->value('id')
            ]);
        });

        $namaResponden = $hasilEvaluasi->responden->user->nama;
        return redirect()->route('verifikator.kelola-evaluasi.perlu-ditinjau')
            ->with('success', "Evaluasi $namaResponden berhasil direvisi.");
    }

    private function getHasilEvaluasiAkhir($hasilEvaluasiAkhir)
    {
        return match ($hasilEvaluasiAkhir) {
            NilaiEvaluasi::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK
            => [
                'color' => 'bg-red-600',
                'label' => NilaiEvaluasi::HASIL_EVALUASI_AKHIR_TIDAK_LAYAK
            ],
            NilaiEvaluasi::HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR
            => [
                'color' => 'bg-yellow-500',
                'label' => NilaiEvaluasi::HASIL_EVALUASI_AKHIR_PEMENUHAN_KERANGKA_KERJA_DASAR
            ],
            NilaiEvaluasi::HASIL_EVALUASI_AKHIR_CUKUP_BAIK
            => [
                'color' => 'bg-lime-400',
                'label' => NilaiEvaluasi::HASIL_EVALUASI_AKHIR_CUKUP_BAIK
            ],
            NilaiEvaluasi::HASIL_EVALUASI_AKHIR_BAIK
            => [
                'color' => 'bg-lime-600',
                'label' => NilaiEvaluasi::HASIL_EVALUASI_AKHIR_BAIK
            ],
        };
    }
}
