<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Evaluasi\PertanyaanKategoriSe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PertanyaanKategoriSeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarPertanyaan = [
            [
                'nomor' => 1,
                'pertanyaan' => 'Nilai investasi sistem elektronik yang terpasang',
                'status_pertama' => 'A. Lebih dari Rp.30 Miliar',
                'status_kedua' => 'B. Lebih dari Rp.3 Miliar s/d Rp.30 Miliar',
                'status_ketiga' => 'C. Kurang dari Rp.3 Miliar',
            ],
            [
                'nomor' => 2,
                'pertanyaan' => 'Total anggaran operasional tahunan yang dialokasikan untuk pengelolaan Sistem Elektronik',
                'status_pertama' => 'A. Lebih dari Rp.10 Miliar',
                'status_kedua' => 'B. Lebih dari Rp.1 Miliar s/d Rp.10 Miliar',
                'status_ketiga' => 'C. Kurang dari Rp.1 Miliar',
            ],
            [
                'nomor' => 3,
                'pertanyaan' => 'Memiliki kewajiban kepatuhan terhadap Peraturan atau Standar tertentu',
                'status_pertama' => 'A. Peraturan atau Standar nasional dan internasional',
                'status_kedua' => 'B. Peraturan atau Standar nasional',
                'status_ketiga' => 'C. Tidak ada Peraturan khusus',
            ],
            [
                'nomor' => 4,
                'pertanyaan' => 'Menggunakan teknik kriptografi khusus untuk keamanan informasi dalam Sistem Elektronik',
                'status_pertama' => 'A. Teknik kriptografi khusus yang disertifikasi oleh Negara',
                'status_kedua' => 'B. Teknik kriptografi sesuai standar industri, tersedia secara publik atau dikembangkan sendiri',
                'status_ketiga' => 'C. Tidak ada penggunaan teknik kriptografi',
            ],
            [
                'nomor' => 5,
                'pertanyaan' => 'Jumlah pengguna Sistem Elektronik',
                'status_pertama' => 'A. Lebih dari 5.000 pengguna',
                'status_kedua' => 'B. 1.000 sampai dengan 5.000 pengguna',
                'status_ketiga' => 'C. Kurang dari 1.000 pengguna',
            ],
            [
                'nomor' => 6,
                'pertanyaan' => 'Data pribadi yang dikelola Sistem Elektronik',
                'status_pertama' => 'A. Data pribadi yang memiliki hubungan dengan Data Pribadi lainnya',
                'status_kedua' => 'B. Data pribadi yang bersifat individu dan/atau data pribadi yang terkait dengan kepemilikan badan usaha',
                'status_ketiga' => 'C. Tidak ada data pribadi',
            ],
            [
                'nomor' => 7,
                'pertanyaan' => 'Tingkat klasifikasi/kekritisan Data yang ada dalam Sistem Elektronik, relatif terhadap ancaman upaya penyerangan atau penerobosan keamanan informasi',
                'status_pertama' => 'A. Sangat Rahasia',
                'status_kedua' => 'B. Rahasia dan/atau Terbatas',
                'status_ketiga' => 'C. Biasa',
            ],
            [
                'nomor' => 8,
                'pertanyaan' => 'Tingkat kekritisan proses yang ada dalam Sistem Elektronik, relatif terhadap ancaman upaya penyerangan atau penerobosan keamanan informasi',
                'status_pertama' => 'A. Proses yang berisiko mengganggu hajat hidup orang banyak dan memberi dampak langsung pada layanan publik',
                'status_kedua' => 'B. Proses yang berisiko mengganggu hajat hidup orang banyak dan memberi dampak tidak langsung',
                'status_ketiga' => 'C. Proses yang hanya berdampak pada bisnis perusahaan',
            ],
            [
                'nomor' => 9,
                'pertanyaan' => 'Dampak dari kegagalan Sistem Elektronik',
                'status_pertama' => 'A. Membahayakan pertahanan keamanan negara',
                'status_kedua' => 'B. Tidak tersedianya layanan publik berskala nasional atau berdampak pada layanan di sektor lain',
                'status_ketiga' => 'C. Tidak tersedianya layanan publik dalam 1 propinsi atau internal 1 instansi/perusahaan',
            ],
            [
                'nomor' => 10,
                'pertanyaan' => 'Potensi kerugian atau dampak negatif dari insiden ditembusnya keamanan informasi Sistem Elektronik (sabotase, terorisme)',
                'status_pertama' => 'A. Menimbulkan korban jiwa',
                'status_kedua' => 'B. Terbatas pada kerugian finansial',
                'status_ketiga' => 'C. Mengakibatkan gangguan operasional sementara (tidak membahayakan dan mengakibatkan kerugian finansial)',
            ],
        ];

        foreach ($daftarPertanyaan as $pertanyaan) {
            $pertanyaanEvaluasi = PertanyaanEvaluasi::create([
                'area_evaluasi_id' => 1,
                'nomor' => $pertanyaan['nomor'],
                'catatan' => $pertanyaan['catatan'] ?? null,
                'pertanyaan' => $pertanyaan['pertanyaan'],
            ]);
            PertanyaanKategoriSe::create([
                'pertanyaan_evaluasi_id' => $pertanyaanEvaluasi->id,
                'status_pertama' => $pertanyaan['status_pertama'],
                'status_kedua' => $pertanyaan['status_kedua'],
                'status_ketiga' => $pertanyaan['status_ketiga'],
                'skor_status_pertama' => 5,
                'skor_status_kedua' => 2,
                'skor_status_ketiga' => 1,
            ]);
        }
    }
}
