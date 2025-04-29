<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Evaluasi\PertanyaanSuplemen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PertanyaanSuplemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarPertanyaan = [
            [
                'nomor' => 1,
                'pertanyaan' => 'Apakah instansi/perusahaan mengidentifikasi risiko keamanan informasi yang ada terkait dengan kerjasama dengan pihak ketiga atau karyawan kontrak?'
            ],
            [
                'nomor' => 2,
                'pertanyaan' => 'Apakah instansi/perusahaan mengkomunikasikan dan mengklarifikasi risiko keamanan informasi yang ada pada pihak ketiga kepada mereka?'
            ],
            [
                'nomor' => 3,
                'pertanyaan' => 'Apakah instansi/perusahaan mengklarifikasi persyaratan mitigasi risiko instansi/perusahaan dan ekspektasi mitigasi risiko yang harus dipatuhi oleh pihak ketiga?'
            ],
            [
                'nomor' => 4,
                'pertanyaan' => 'Apakah rencana mitigasi terhadap risiko yang diidentifikasi tersebut disetujui oleh manajemen pihak ketiga atau karyawan kontrak?'
            ],
            [
                'nomor' => 5,
                'pertanyaan' => 'Apakah instansi/perusahaan telah menerapkan kebijakan keamanan informasi bagi pihak ketiga secara memadai, mencakup persyaratan pengendalian akses, penghancuran informasi, manajemen risiko penyediaan layanan pihak ketiga, dan NDA bagi karyawan pihak ketiga?'
            ],
            [
                'nomor' => 6,
                'pertanyaan' => 'Apakah kebijakan tersebut (7.1.1.5) telah dikomunikasikan kepada pihak ketiga dan mereka menyatakan persetujuannya dalam dokumen kontrak, SLA atau dokumen sejenis lainnya?'
            ],
            [
                'nomor' => 7,
                'pertanyaan' => 'Apakah hak audit TI secara berkala ke pihak ketiga/pihak ketiga telah ditetapkan sebagai bagian dan persyaratan kontrak, dikomunikasikan dan disetujui pihak ketiga? Termasuk di dalamnya akses terhadap laporan audit internal/eksternal tentang kondisi kontrol keamanan informasi pihak ketiga/pihak ketiga?'
            ],
            [
                'nomor' => 8,
                'pertanyaan' => 'Apakah pihak ketiga sudah mengidentifikasi risiko terkait alih daya, subkontraktor atau penyedia teknologi/infrastruktur yang digunakan dalam layanannya?'
            ],
            [
                'nomor' => 9,
                'pertanyaan' => 'Apakah pihak ketiga sudah menerapkan pengendalian risikonya dalam perjanjian dengan mereka atau dokumen sejenis?'
            ],
            [
                'nomor' => 10,
                'pertanyaan' => 'Apakah pihak ketiga melakukan pemantauan dan evaluasi terhadap kepatuhan alih daya, subkontraktor atau penyedia teknologi/infrastruktur terhadap persyaratan keamanan yang ditetapkan?'
            ],
            [
                'nomor' => 11,
                'pertanyaan' => 'Apakah instansi/perusahaan telah menetapkan proses, prosedur atau rencana terdokumentasi untuk mengelola dan memantau layanan dan aspek keamanan informasi (termasuk pengamanan aset informasi dan infrastruktur milik instansi/perusahaan yang diakses) dalam hubungan kerjasama dengan pihak ketiga?'
            ],
            [
                'nomor' => 12,
                'pertanyaan' => 'Apakah peran dan tanggung jawab pemantauan, evaluasi dan/atau audit aspek keamanan informasi pihak ketiga telah ditetapkan dan/atau ditugaskan dalam unit organisasi tertentu?'
            ],
            [
                'nomor' => 13,
                'pertanyaan' => 'Apakah tersedia laporan berkala tentang pencapaian sasaran tingkat layanan (SLA) dan aspek keamanan yang disyaratkan dalam perjanjian komersil (kontrak)?'
            ],
            [
                'nomor' => 14,
                'pertanyaan' => 'Apakah ada rapat secara berkala untuk memantau dan mengevaluasi pencapaian sasaran tingkat layanan (SLA) dan aspek keamanan?'
            ],
            [
                'nomor' => 15,
                'pertanyaan' => 'Apakah hasil pemantauan dan evaluasi terhadap laporan atau pembahasan dalam rapat berkala tersebut didokumentasikan, dikomunikasikan dan ditindaklanjuti oleh pihak ketiga serta dilaporkan kemajuannya kepada instansi/perusahaan?'
            ],
            [
                'nomor' => 16,
                'pertanyaan' => 'Apakah instansi/perusahaan telah menetapkan rencana dan melakukan audit terhadap pemenuhan persyaratan keamanan informasi oleh pihak ketiga?'
            ],
            [
                'nomor' => 17,
                'pertanyaan' => 'Apakah hasil audit tersebut ditindaklanjuti oleh pihak ketiga dengan melaporkan rencana perbaikan yang terukur dan bukti-bukti penerapan rencana tersebut?'
            ],
            [
                'nomor' => 18,
                'pertanyaan' => 'Apakah kondisi terkait denda/penalti karena ketidakpatuhan pihak ketiga terhadap persyaratan dan/atau tingkat layanan telah didokumentasikan, dikomunikasikan, dipahami dan diterapkan?'
            ],
            [
                'nomor' => 19,
                'pertanyaan' => 'Apakah instansi/perusahaan mengelola perubahan yang terjadi dalam hubungan dengan pihak ketiga yang menyangkut antara lain: - Perubahan layanan pihak ketiga; - Perubahan kebijakan, prosedur, dan/atau - Kontrol risiko pihak ketiga?'
            ],
            [
                'nomor' => 20,
                'pertanyaan' => 'Apakah risiko yang menyertai perubahan tersebut dikaji, didokumentasikan dan ditetapkan rencana mitigasi barunya?'
            ],
            [
                'nomor' => 21,
                'pertanyaan' => 'Apakah pihak ketiga memiliki prosedur formal untuk menangani data selama dalam siklus hidupnya mulai dari pembuatan, pendaftaran, perubahan, dan penghapusan/penghancuran aset?'
            ],
            [
                'nomor' => 22,
                'pertanyaan' => 'Apakah prosedur untuk penghancuran (disposal) data secara aman telah disepakati bersama pihak ketiga?'
            ],
            [
                'nomor' => 23,
                'pertanyaan' => 'Apakah pihak ketiga memiliki prosedur untuk pelaporan, pemantauan, penanganan, dan analisis insiden keamanan informasi?'
            ],
            [
                'nomor' => 24,
                'pertanyaan' => 'Apakah pihak ketiga memiliki bukti-bukti penerapan yang memadai dalam menangani insiden keamanan informasi?'
            ],
            [
                'nomor' => 25,
                'pertanyaan' => 'Apakah pihak ketiga memiliki kebijakan, prosedur atau rencana terdokumentasi untuk mengatasi kelangsungan layanan pihak ketiga dalam keadaan darurat/bencana?'
            ],
            [
                'nomor' => 26,
                'pertanyaan' => 'Apakah kebijakan, prosedur atau rencana kelangsungan layanan tersebut telah diujicoba, didokumentasikan hasilnya dan dievaluasi efektivitasnya?'
            ],
            [
                'nomor' => 27,
                'pertanyaan' => 'Apakah pihak ketiga memiliki organisasi atau tim khusus yang ditugaskan untuk mengelola proses kelangsungan layanannya?'
            ]
        ];

        foreach ($daftarPertanyaan as $pertanyaan) {
            PertanyaanSuplemen::create([
                'area_evaluasi_id' => 8,
                'nomor' => $pertanyaan['nomor'],
                'pertanyaan' => $pertanyaan['pertanyaan'],
            ]);
        }
    }
}
