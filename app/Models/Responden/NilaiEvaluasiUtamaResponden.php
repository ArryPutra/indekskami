<?php

namespace App\Models\Responden;

use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Responden\NilaiEvaluasi;
use Illuminate\Database\Eloquent\Model;

class NilaiEvaluasiUtamaResponden extends Model
{
    protected $table = 'nilai_evaluasi_utama_responden';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const TINGKAT_KEMATANGAN_I = 'I';
    const TINGKAT_KEMATANGAN_I_PLUS = 'I+';
    const TINGKAT_KEMATANGAN_II = 'II';
    const TINGKAT_KEMATANGAN_II_PLUS = 'II+';
    const TINGKAT_KEMATANGAN_III = 'III';
    const TINGKAT_KEMATANGAN_III_PLUS = 'III+';
    const TINGKAT_KEMATANGAN_IV = 'IV';
    const TINGKAT_KEMATANGAN_IV_PLUS = 'IV+';
    const TINGKAT_KEMATANGAN_V = 'V';

    public static function getTingkatKematanganOptions()
    {
        return [
            self::TINGKAT_KEMATANGAN_I,
            self::TINGKAT_KEMATANGAN_I_PLUS,
            self::TINGKAT_KEMATANGAN_II,
            self::TINGKAT_KEMATANGAN_II_PLUS,
            self::TINGKAT_KEMATANGAN_III,
            self::TINGKAT_KEMATANGAN_III_PLUS,
            self::TINGKAT_KEMATANGAN_IV,
            self::TINGKAT_KEMATANGAN_IV_PLUS,
            self::TINGKAT_KEMATANGAN_V
        ];
    }

    public function nilaiEvaluasiUtama()
    {
        return $this->belongsTo(NilaiEvaluasiUtama::class);
    }

    public static function getNilaiEvaluasiUtama($nilaiEvaluasiUtamaResponden)
    {
        return $nilaiEvaluasiUtamaResponden->map(function ($nilaiEvaluasiUtamaResponden) {
            return [
                'namaNilaiEvaluasiUtama'
                => $nilaiEvaluasiUtamaResponden->nilaiEvaluasiUtama->nama_nilai_evaluasi_utama,
                'skorStatusTingkatKematangan'
                => NilaiEvaluasi::getSkorTingkatKematangan($nilaiEvaluasiUtamaResponden->status_tingkat_kematangan)
            ];
        });
    }

    public static function getStatusTingkatKematangan(
        $daftarPertanyaanDanJawaban,
        $skorEvaluasiUtamaTingkatKematangan,
        $daftarSkorTingkatKematangan,
        $areaEvaluasiId
    ) {
        $daftarStatusTingkatKematangan = [
            'V' => self::getStatusTingkatKematanganV(
                $daftarPertanyaanDanJawaban,
                $skorEvaluasiUtamaTingkatKematangan,
                $areaEvaluasiId
            ),
            'IV' => self::getStatusTingkatKematanganIV(
                $daftarPertanyaanDanJawaban,
                $skorEvaluasiUtamaTingkatKematangan,
                $areaEvaluasiId
            ),
            'III' => self::getStatusTingkatKematanganIII(
                $daftarPertanyaanDanJawaban,
                $skorEvaluasiUtamaTingkatKematangan,
                $areaEvaluasiId
            ),
            'II' => self::getStatusTingkatKematanganII(
                $daftarPertanyaanDanJawaban,
                $skorEvaluasiUtamaTingkatKematangan,
            ),
        ];

        $daftarSkorTingkatKematanganTersedia = collect($daftarSkorTingkatKematangan);

        foreach ($daftarStatusTingkatKematangan as $tingkat => $status) {
            if ($status !== 'No' && $daftarSkorTingkatKematanganTersedia->contains('tingkatKematangan', $tingkat)) {
                return $status;
            }
        }
    }

    public static function getStatusPenilaianTahapPenerapan3(
        $daftarPertanyaanDanJawaban,
        int $areaEvaluasiId
    ) {
        $daftarJawabanTahap1 = $daftarPertanyaanDanJawaban->where('pertanyaan_tahap', 1);

        $totalSkorTahapPenerapan1 = $daftarJawabanTahap1->sum('skor_jawaban');
        // $totalJawabanTahap1TidakDiterapkan = $daftarJawabanTahap1->where('skor_jawaban', 0)->count();
        $totalJawabanTahap1DalamPerencanaan = $daftarJawabanTahap1->where('skor_jawaban', 1)->count();
        $totalJawabanTahap1DiterapkanSebagian = $daftarJawabanTahap1->where('skor_jawaban', 2)->count();
        // $totalJawabanTahap1DiterapkanSecaraMenyeluruh = $daftarJawabanTahap1->where('skor_jawaban', 3)->count();

        $skorValiditasTahapPenerapan3 = $daftarPertanyaanDanJawaban->where('pertanyaan_tahap', 1)->count() * 3;

        $statusValiditasTahapPenerapn3 = 'NO';
        if (
            $totalJawabanTahap1DalamPerencanaan === 0
            && $totalSkorTahapPenerapan1 >= ($skorValiditasTahapPenerapan3 - 2)
            && $totalJawabanTahap1DiterapkanSebagian <= 2
        ) {
            $statusValiditasTahapPenerapn3 = 'OK';
        }

        $jumlahPertanyaanTahap1 = $daftarPertanyaanDanJawaban->where('pertanyaan_tahap', 1)->count();
        $jumlahPertanyaanTahap2 = $daftarPertanyaanDanJawaban->where('pertanyaan_tahap', 2)->count();
        $batasSkorMinUntukSkorTahapPenerapan3 = (2 * $jumlahPertanyaanTahap1) + (4 * $jumlahPertanyaanTahap2);
        // Khusus III Risiko memiliki rumus berbeda
        if ($areaEvaluasiId === AreaEvaluasi::AREA_EVALUASI_III_RISIKO_ID) {
            $batasSkorMinUntukSkorTahapPenerapan3 = (2 * $jumlahPertanyaanTahap1) + (4 * $jumlahPertanyaanTahap2 / 2) + (6 * $jumlahPertanyaanTahap2 / 2);
        }

        $totalSkorTahapPenerapan1Dan2 = $daftarPertanyaanDanJawaban->whereIn('pertanyaan_tahap', [1, 2])->sum('skor_jawaban');

        if (
            $totalSkorTahapPenerapan1Dan2 >= $batasSkorMinUntukSkorTahapPenerapan3
            && $statusValiditasTahapPenerapn3 == 'OK'
        ) {
            return true;
        } else {
            return false;
        }
    }

    private static function getStatusTingkatKematanganII(
        $daftarPertanyaanDanJawaban,
        $skorEvaluasiUtamaTingkatKematangan,
    ) {
        $totalSkorJawabanTingkatKematanganII = $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'II')->sum('skor_jawaban');
        $skorMinimumTingkatKematanganII = $skorEvaluasiUtamaTingkatKematangan['skor_minimum_tingkat_kematangan_ii'];
        $skorPencapaianTingkatKematanganII = $skorEvaluasiUtamaTingkatKematangan['skor_pencapaian_tingkat_kematangan_ii'];

        if ($totalSkorJawabanTingkatKematanganII >= $skorPencapaianTingkatKematanganII) {
            return 'II';
        } else if ($totalSkorJawabanTingkatKematanganII >= $skorMinimumTingkatKematanganII) {
            return 'I+';
        } else {
            return 'I';
        }
    }

    private static function getStatusTingkatKematanganIII(
        $daftarPertanyaanDanJawaban,
        $skorEvaluasiUtamaTingkatKematangan,
        $areaEvaluasiId
    ) {
        $totalSkorJawabanTingkatKematanganIII = $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'III')->sum('skor_jawaban');
        $validitasTingkatKematanganIII =
            $daftarPertanyaanDanJawaban->where('tingkat_kematangan', "II")->sum('skor_jawaban')
            >= $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'II')->sum('skor_status_keempat') * (80 / 100)
            &&
            self::getStatusPenilaianTahapPenerapan3($daftarPertanyaanDanJawaban, $areaEvaluasiId);
        $skorMinimumTingkatKematanganIII = $skorEvaluasiUtamaTingkatKematangan['skor_minimum_tingkat_kematangan_iii'];
        $skorPencapaianTingkatKematanganIII = $skorEvaluasiUtamaTingkatKematangan['skor_pencapaian_tingkat_kematangan_iii'];

        if ($validitasTingkatKematanganIII) {
            if ($totalSkorJawabanTingkatKematanganIII >= $skorPencapaianTingkatKematanganIII) {
                return 'III';
            } else if ($totalSkorJawabanTingkatKematanganIII >= $skorMinimumTingkatKematanganIII) {
                return 'II+';
            } else {
                return 'II';
            }
        } else {
            return 'No';
        }
    }

    private static function getStatusTingkatKematanganIV(
        $daftarPertanyaanDanJawaban,
        $skorEvaluasiUtamaTingkatKematangan,
        $areaEvaluasiId
    ) {

        $skorValiditasTingkatKematanganIV = match ($skorEvaluasiUtamaTingkatKematangan->areaEvaluasi->nama_area_evaluasi) {
            AreaEvaluasi::AREA_EVALUASI_II_TATA_KELOLA => 16,
            AreaEvaluasi::AREA_EVALUASI_III_RISIKO => 10,
            AreaEvaluasi::AREA_EVALUASI_IV_KERANGKA_KERJA => 92,
            AreaEvaluasi::AREA_EVALUASI_V_PENGELOLAAN_ASET => 61,
            AreaEvaluasi::AREA_EVALUASI_VI_TEKNOLOGI => 64,
            default => 0
        };

        $totalSkorJawabanTingkatKematanganIV = $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'IV')->sum('skor_jawaban');
        $validitasTingkatKematanganIV =
            ($daftarPertanyaanDanJawaban->where('tingkat_kematangan', "II")->sum('skor_jawaban')
                >= $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'II')->sum('skor_status_keempat') * (80 / 100)
                &&
                self::getStatusPenilaianTahapPenerapan3($daftarPertanyaanDanJawaban, $areaEvaluasiId))
            &&
            $daftarPertanyaanDanJawaban->where('tingkat_kematangan', "III")->sum('skor_jawaban')
            >= $skorValiditasTingkatKematanganIV;
        $skorMinimumTingkatKematanganIV = $skorEvaluasiUtamaTingkatKematangan['skor_minimum_tingkat_kematangan_iv'];
        $skorPencapaianTingkatKematanganIV = $skorEvaluasiUtamaTingkatKematangan['skor_pencapaian_tingkat_kematangan_iv'];

        if ($validitasTingkatKematanganIV) {
            if (
                ($daftarPertanyaanDanJawaban->where('tingkat_kematangan', "II")->sum('skor_jawaban')
                    === $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'II')->sum('skor_status_keempat'))
                &&
                (
                    $daftarPertanyaanDanJawaban->where('tingkat_kematangan', "III")->sum('skor_jawaban')
                    >=
                    $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'III')->sum('skor_status_keempat')
                )
                &&
                (
                    $totalSkorJawabanTingkatKematanganIV
                    >=
                    $skorPencapaianTingkatKematanganIV
                )

            ) {
                return 'IV';
            } else if (
                $totalSkorJawabanTingkatKematanganIV
                >=
                $skorMinimumTingkatKematanganIV
            ) {
                return 'III+';
            } else {
                return 'III';
            }
        } else {
            return 'No';
        }
    }

    private static function getStatusTingkatKematanganV(
        $daftarPertanyaanDanJawaban,
        $skorEvaluasiUtamaTingkatKematangan,
        $areaEvaluasiId
    ) {
        $skorValiditasTingkatKematanganIV = match ($skorEvaluasiUtamaTingkatKematangan->areaEvaluasi->nama_area_evaluasi) {
            AreaEvaluasi::AREA_EVALUASI_II_TATA_KELOLA => 16,
            AreaEvaluasi::AREA_EVALUASI_III_RISIKO => 10,
            AreaEvaluasi::AREA_EVALUASI_IV_KERANGKA_KERJA => 92,
            AreaEvaluasi::AREA_EVALUASI_V_PENGELOLAAN_ASET => 61,
            AreaEvaluasi::AREA_EVALUASI_VI_TEKNOLOGI => 64,
            default => 0
        };

        $totalSkorJawabanTingkatKematanganV = $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'V')->sum('skor_jawaban');
        $validitasTingkatKematanganV =
            (($daftarPertanyaanDanJawaban->where('tingkat_kematangan', "II")->sum('skor_jawaban')
                >= $daftarPertanyaanDanJawaban->where('tingkat_kematangan', 'II')->sum('skor_status_keempat') * (80 / 100)
                &&
                self::getStatusPenilaianTahapPenerapan3($daftarPertanyaanDanJawaban, $areaEvaluasiId))
                &&
                $daftarPertanyaanDanJawaban->where('tingkat_kematangan', "III")->sum('skor_jawaban')
                >= $skorValiditasTingkatKematanganIV)
            &&
            $daftarPertanyaanDanJawaban->where('tingkat_kematangan', "IV")->sum('skor_jawaban')
            >= $skorEvaluasiUtamaTingkatKematangan['skor_pencapaian_tingkat_kematangan_iv'];
        $skorMinimumTingkatKematanganV = $skorEvaluasiUtamaTingkatKematangan['skor_minimum_tingkat_kematangan_v'];
        $skorPencapaianTingkatKematanganV = $skorEvaluasiUtamaTingkatKematangan['skor_pencapaian_tingkat_kematangan_v'];

        if ($validitasTingkatKematanganV) {
            if ($totalSkorJawabanTingkatKematanganV >= $skorPencapaianTingkatKematanganV) {
                return 'V';
            } else if ($totalSkorJawabanTingkatKematanganV >= $skorMinimumTingkatKematanganV) {
                return 'IV+';
            } else {
                return 'V';
            }
        } else {
            return 'No';
        }
    }
}
