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
        $responden = $hasilEvaluasi->responden->with('user')->first();

        $nilaiEvaluasi =
            $hasilEvaluasi->nilaiEvaluasi->with('nilaiEvaluasiUtamaResponden.nilaiEvaluasiUtama')->first();

        return view('pages.evaluasi.dashboard.dashboard', [
            'title' => 'Dashboard Evaluasi',
            'responden' => $responden,
            'daftarAreaEvaluasi' => AreaEvaluasi::all(),
            'hasilEvaluasi' => $hasilEvaluasi,
            'hasilEvaluasiId' => $hasilEvaluasi->id,
            'statusHasilEvaluasiSaatIni' => $hasilEvaluasi->statusHasilEvaluasi->nama_status_hasil_evaluasi,
            'identitasResponden' => $hasilEvaluasi->identitasResponden,
            'nilaiEvaluasi' => $nilaiEvaluasi->load('nilaiEvaluasiUtamaResponden.nilaiEvaluasiUtama'),
            'hasilEvaluasiAkhir' => $this->getHasilEvaluasiAkhir($nilaiEvaluasi->hasil_evaluasi_akhir),
            'tingkatKelengkapanIso' => NilaiEvaluasi::getTingkatKelengkapanIso($nilaiEvaluasi->tingkat_kelengkapan_iso),
            'daftarNilaiEvaluasiUtama' => NilaiEvaluasiUtamaResponden::getNilaiEvaluasiUtama($nilaiEvaluasi->nilaiEvaluasiUtamaResponden),
            'isResponden' => Auth::user()->peran->nama_peran === Peran::PERAN_RESPONDEN,
            'apakahEvaluasiSedangDikerjakan' => ($hasilEvaluasi->statusHasilEvaluasi->id === StatusHasilEvaluasi::STATUS_DIKERJAKAN_ID)
                && (Auth::user()->peran_id === Peran::PERAN_RESPONDEN_ID),
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

        return redirect()->route('responden.evaluasi.selesai-evaluasi');
    }

    // Fungsi Milik -> Admin & Verifikator
    public function verifikasiEvaluasi(HasilEvaluasi $hasilEvaluasi)
    {
        DB::transaction(function () use ($hasilEvaluasi) {
            $hasilEvaluasi->update([
                'status_hasil_evaluasi_id' => StatusHasilEvaluasi::where(
                    'nama_status_hasil_evaluasi',
                    StatusHasilEvaluasi::STATUS_DIVERIFIKASI
                )->value('id'),
                'tanggal_diverifikasi' => Carbon::now()
            ]);

            $hasilEvaluasi->responden->update([
                'status_progres_evaluasi_responden_id' => StatusProgresEvaluasiResponden::where(
                    'nama_status_progres_evaluasi_responden',
                    StatusProgresEvaluasiResponden::TIDAK_MENGERJAKAN
                )->value('id')
            ]);
        });

        return redirect()->route('verifikator.kelola-evaluasi.perlu-ditinjau');
    }

    public function revisiEvaluasi(Request $request, HasilEvaluasi $hasilEvaluasi)
    {
        DB::transaction(function () use ($request, $hasilEvaluasi) {
            $hasilEvaluasi->update([
                'status_hasil_evaluasi_id' => StatusHasilEvaluasi::where(
                    'nama_status_hasil_evaluasi',
                    StatusHasilEvaluasi::STATUS_DIKERJAKAN
                )->value('id'),
                'tanggal_diverifikasi' => Carbon::now(),
                'catatan' => $request->catatan
            ]);


            $hasilEvaluasi->responden->update([
                'status_progres_evaluasi_responden_id' => StatusProgresEvaluasiResponden::where(
                    'nama_status_progres_evaluasi_responden',
                    StatusProgresEvaluasiResponden::SEDANG_MENGERJAKAN
                )->value('id')
            ]);
        });

        return redirect()->route('verifikator.kelola-evaluasi.perlu-ditinjau');
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
