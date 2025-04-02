<?php

namespace Database\Seeders\Evaluasi;

use App\Models\Evaluasi\PertanyaanIKategoriSE;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PertanyaanIKategoriSESeeder extends Seeder
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
                'status_a' => 'A. Lebih dari Rp.30 Miliar',
                'status_b' => 'B. Lebih dari Rp.3 Miliar s/d Rp.30 Miliar',
                'status_c' => 'C. Kurang dari Rp.3 Miliar',
            ],
            [
                'nomor' => 2,
                'pertanyaan' => 'Total anggaran operasional tahunan yang dialokasikan untuk pengelolaan Sistem Elektronik',
                'status_a' => 'A. Lebih dari Rp.10 Miliar',
                'status_b' => 'B. Lebih dari Rp.1 Miliar s/d Rp.10 Miliar',
                'status_c' => 'C. Kurang dari Rp.1 Miliar',
            ],
            [
                'nomor' => 3,
                'pertanyaan' => 'Memiliki kewajiban kepatuhan terhadap Peraturan atau Standar tertentu',
                'status_a' => 'A. Peraturan atau Standar nasional dan internasional',
                'status_b' => 'B. Peraturan atau Standar nasional',
                'status_c' => 'C. Tidak ada Peraturan khusus',
            ],
            [
                'nomor' => 4,
                'pertanyaan' => 'Menggunakan teknik kriptografi khusus untuk keamanan informasi dalam Sistem Elektronik',
                'status_a' => 'A. Teknik kriptografi khusus yang disertifikasi oleh Negara',
                'status_b' => 'B. Teknik kriptografi sesuai standar industri, tersedia secara publik atau dikembangkan sendiri',
                'status_c' => 'C. Tidak ada penggunaan teknik kriptografi',
            ],
            [
                'nomor' => 5,
                'pertanyaan' => 'Jumlah pengguna Sistem Elektronik',
                'status_a' => 'A. Lebih dari 5.000 pengguna',
                'status_b' => 'B. 1.000 sampai dengan 5.000 pengguna',
                'status_c' => 'C. Kurang dari 1.000 pengguna',
            ],
            [
                'nomor' => 6,
                'pertanyaan' => 'Data pribadi yang dikelola Sistem Elektronik',
                'status_a' => 'A. Data pribadi yang memiliki hubungan dengan Data Pribadi lainnya',
                'status_b' => 'B. Data pribadi yang bersifat individu dan/atau data pribadi yang terkait dengan kepemilikan badan usaha',
                'status_c' => 'C. Tidak ada data pribadi',
            ],
            [
                'nomor' => 7,
                'pertanyaan' => 'Tingkat klasifikasi/kekritisan Data yang ada dalam Sistem Elektronik, relatif terhadap ancaman upaya penyerangan atau penerobosan keamanan informasi',
                'status_a' => 'A. Sangat Rahasia',
                'status_b' => 'B. Rahasia dan/atau Terbatas',
                'status_c' => 'C. Biasa',
            ],
            [
                'nomor' => 8,
                'pertanyaan' => 'Tingkat kekritisan proses yang ada dalam Sistem Elektronik, relatif terhadap ancaman upaya penyerangan atau penerobosan keamanan informasi',
                'status_a' => 'A. Proses yang berisiko mengganggu hajat hidup orang banyak dan memberi dampak langsung pada layanan publik',
                'status_b' => 'B. Proses yang berisiko mengganggu hajat hidup orang banyak dan memberi dampak tidak langsung',
                'status_c' => 'C. Proses yang hanya berdampak pada bisnis perusahaan',
            ],
            [
                'nomor' => 9,
                'pertanyaan' => 'Dampak dari kegagalan Sistem Elektronik',
                'status_a' => 'A. Membahayakan pertahanan keamanan negara',
                'status_b' => 'B. Tidak tersedianya layanan publik berskala nasional atau berdampak pada layanan di sektor lain',
                'status_c' => 'C. Tidak tersedianya layanan publik dalam 1 propinsi atau internal 1 instansi/perusahaan',
            ],
            [
                'nomor' => 10,
                'pertanyaan' => 'Potensi kerugian atau dampak negatif dari insiden ditembusnya keamanan informasi Sistem Elektronik (sabotase, terorisme)',
                'status_a' => 'A. Menimbulkan korban jiwa',
                'status_b' => 'B. Terbatas pada kerugian finansial',
                'status_c' => 'C. Mengakibatkan gangguan operasional sementara (tidak membahayakan dan mengakibatkan kerugian finansial)',
            ],
        ];

        foreach ($daftarPertanyaan as $pertanyaan) {
            PertanyaanIKategoriSE::create([
                'area_evaluasi_id' => 1,
                'nomor' => $pertanyaan['nomor'],
                'pertanyaan' => $pertanyaan['pertanyaan'],
                'status_a' => $pertanyaan['status_a'],
                'status_b' => $pertanyaan['status_b'],
                'status_c' => $pertanyaan['status_c'],
                'skor_status_c' => 5,
                'skor_status_b' => 2,
                'skor_status_c' => 1,
            ]);
        }
    }
}
