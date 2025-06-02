<?php

namespace Database\Seeders\Responden;

use App\Models\Responden\NilaiEvaluasiUtama;
use App\Models\Responden\NilaiEvaluasiUtamaResponden;
use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
use App\Models\Responden\HasilEvaluasi;
use App\Models\Responden\IdentitasResponden;
use App\Models\Responden\JawabanEvaluasi;
use App\Models\Responden\NilaiEvaluasi;
use App\Models\Responden\Responden;
use App\Models\Responden\StatusHasilEvaluasi;
use App\Models\Responden\StatusProgresEvaluasiResponden;
use App\Models\Verifikator\Verifikator;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JawabanEvaluasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $daftarResponden = Responden::all();

        $daftarPertanyaan = PertanyaanEvaluasi::all();

        foreach ($daftarResponden as $responden) {
            foreach (range(1, 3) as $range) {
                $identitasResponden = IdentitasResponden::create([
                    'responden_id' => $responden->id,
                    'nomor_telepon' => $responden->user->nomor_telepon,
                    'email' => $responden->user->email,
                    'pengisi_lembar_evaluasi' => $faker->name,
                    'jabatan' => $faker->jobTitle,
                    'tanggal_pengisian' => $faker->dateTimeBetween('-2 year', 'now'),
                    'deskripsi_ruang_lingkup' => $faker->text,
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
                    'status_hasil_evaluasi_id' => StatusHasilEvaluasi::STATUS_DIKERJAKAN_ID,
                    'evaluasi_ke' => $range
                ]);
                $responden->update([
                    'status_progres_evaluasi_responden_id' => StatusProgresEvaluasiResponden::where(
                        'nama_status_progres_evaluasi_responden',
                        StatusProgresEvaluasiResponden::SEDANG_MENGERJAKAN
                    )->value('id')
                ]);

                // foreach ($daftarPertanyaan as $pertanyaan) {
                //     $jawabanEvaluasi = JawabanEvaluasi::create(
                //         [
                //             'responden_id' => $responden->id,
                //             'pertanyaan_evaluasi_id' => $pertanyaan->id,
                //             'hasil_evaluasi_id' => $hasilEvaluasi->id,
                //             'status_jawaban' => $faker->randomElement(JawabanEvaluasi::getStatusOptions()),
                //             'status_jawaban' => 'status_ketiga',
                //             'bukti_dokumen' => $faker->url(),
                //             // 'keterangan' => $faker->text
                //         ]
                //     );
                // }

                // hasil jawaban
                $nilaiEvaluasi->update([
                    'kategori_se' => $faker->randomElement(NilaiEvaluasi::getKategoriSeOptions()),
                    'tingkat_kelengkapan_iso' => $faker->numberBetween(100, 918),
                ]);

                $hasilEvaluasi->update([
                    'status_hasil_evaluasi_id' => StatusHasilEvaluasi::STATUS_DIVERIFIKASI_ID,
                    'verifikator_id' => Verifikator::all()->random()->id,
                    'tanggal_diverifikasi' => $faker->dateTimeBetween('-2 year', 'now')
                ]);
                $responden->update([
                    'status_progres_evaluasi_responden_id' => StatusProgresEvaluasiResponden::TIDAK_MENGERJAKAN_ID
                ]);
            }
        }
    }
}
