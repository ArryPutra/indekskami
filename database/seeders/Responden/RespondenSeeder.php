<?php

namespace Database\Seeders\Responden;

use App\Models\Peran;
use App\Models\Responden\Responden;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RespondenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarResponden = [
            [
                'nama' => 'Diskominfo Prov. Kalsel',
                'username' => 'diskominfoprovkalsel',
                'email' => 'diskominfoprovkalsel@egov.id',
                'nomor_telepon' => '081345677809',
                'daerah' => 'Provinsi',
                'alamat' => 'Jalan Dharma Praja II, Kawasan Perkantoran Pemerintah Provinsi Kalimantan Selatan, Cempaka, Kota Banjarbaru, Kalimantan Selatan 70732',
            ],
            [
                'nama' => 'Diskominfo Kota Banjarbaru',
                'username' => 'diskominfokotabanjarbaru',
                'email' => 'diskominfo.kotabanjarbaru@egov.id',
                'nomor_telepon' => '081234567810',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Jl. Pangeran Suriansyah No.5, Kel. Komet, Kec. Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan 70711',
            ],
            [
                'nama' => 'Disdikbud Prov Kalsel',
                'username' => 'disdikbudprovkalsel',
                'email' => 'disdikbud.provkalsel@egov.com',
                'nomor_telepon' => '081234567811',
                'daerah' => 'Provinsi',
                'alamat' => 'Jl. Jenderal Basuki Rahmat No.1, Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan 70713',
            ],
            [
                'nama' => 'Disdukcapil Prov Kalsel',
                'username' => 'disdukcapilprovkalsel',
                'email' => 'disdukcapil.provkalsel@egov.com',
                'nomor_telepon' => '081234567812',
                'daerah' => 'Provinsi',
                'alamat' => 'Jl. Jenderal Basuki Rahmat No.1, Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan 70713',
            ],
            [
                'nama' => 'RSGM Gusti Hasan Aman',
                'username' => 'rsgm',
                'email' => 'rsgm@egov.com',
                'nomor_telepon' => '081234567813',
                'daerah' => 'Provinsi',
                'alamat' => 'Jl. Simpang Ulin No.28, Kel. Sungai Baru, Kec. Banjarmasin Tengah, Kota Banjarmasin, Kalimantan Selatan 70122',
            ],
            [
                'nama' => 'Dinas Sosial Prov Kalsel',
                'username' => 'dinassosialprovkalsel',
                'email' => 'dinassosial.provkalsel@egov.com',
                'nomor_telepon' => '081234567814',
                'daerah' => 'Provinsi',
                'alamat' => 'Jl. Letjend. R. Soeprapto No.8, Antasan Besar, Kec. Banjarmasin Tengah, Kota Banjarmasin, Kalimantan Selatan 70111',
            ],
            [
                'nama' => 'Dispar Prov Kalsel',
                'username' => 'disparprovkalsel',
                'email' => 'dispar.provkalsel@egov.com',
                'nomor_telepon' => '081234567815',
                'daerah' => 'Provinsi',
                'alamat' => 'Jl. Jend. A. Yani Km 7,5, Kertak Hanyar, Kabupaten Banjar, Kalimantan Selatan 70654',
            ],
            [
                'nama' => 'Disperin Prov Kalsel',
                'username' => 'disperinprovkalsel',
                'email' => 'disperin.provkalsel@egov.com',
                'nomor_telepon' => '081234567816',
                'daerah' => 'Provinsi',
                'alamat' => 'Jl. Dharma Praja, Komplek Perkantoran Provinsi Kalimantan Selatan, Banjarbaru',
            ],
            [
                'nama' => 'Dinas PMD Prov Kalsel',
                'username' => 'dinaspmdprovkalsel',
                'email' => 'dinaspmd.provkalsel@egov.com',
                'nomor_telepon' => '081234567817',
                'daerah' => 'Provinsi',
                'alamat' => 'l. Bangun Praja No.1, Komplek Perkantoran Pemerintah Provinsi Kalimantan Selatan, Cempaka, Kota Banjarbaru',
            ],
            [
                'nama' => 'DP3A Prov Kalsel',
                'username' => 'dp3aprovkalsel',
                'email' => 'dp3a.provkalsel@egov.com',
                'nomor_telepon' => '081234567818',
                'daerah' => 'Provinsi',
                'alamat' => 'Palam, Cempaka, Kota Banjarbaru, Kalimantan Selatan 70732',
            ],
            [
                'nama' => 'Diskominfo Kab. Banjar',
                'username' => 'diskominfobanjar',
                'email' => 'diskominfo.banjar@egov.com',
                'nomor_telepon' => '081234567819',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Tidak tersedia',
            ],
            [
                'nama' => 'Diskominfo Banjarmasin',
                'username' => 'diskominfobjm',
                'email' => 'diskominfo.bmb@egov.com',
                'nomor_telepon' => '081234567820',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Tidak tersedia',
            ],
            [
                'nama' => 'Diskominfo Kab. Tanah Laut',
                'username' => 'diskominfotanahlaut',
                'email' => 'diskominfo.tanahlaut@egov.com',
                'nomor_telepon' => '081234567821',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Tidak tersedia',
            ],
            [
                'nama' => 'Diskominfo Kab. Tapin',
                'username' => 'diskominfotapin',
                'email' => 'diskominfo.tapin@egov.com',
                'nomor_telepon' => '081234567822',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Tidak tersedia',
            ],
            [
                'nama' => 'Diskominfo Kab. Balangan',
                'username' => 'diskominfobalangan',
                'email' => 'diskominfo.balangan@egov.com',
                'nomor_telepon' => '081234567823',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Tidak tersedia',
            ],
            [
                'nama' => 'Diskominfo Kab. Kotabaru',
                'username' => 'diskominfokotabaru',
                'email' => 'diskominfo.kotabaru@egov.com',
                'nomor_telepon' => '081234567824',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Tidak tersedia',
            ],
            [
                'nama' => 'Diskominfo Kab. Tabalong',
                'username' => 'diskominfotabalong',
                'email' => 'diskominfo.tabalong@egov.com',
                'nomor_telepon' => '081234567825',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Tidak tersedia',
            ],
            [
                'nama' => 'Diskominfo Kab. Tanbu',
                'username' => 'diskominfotanbu',
                'email' => 'diskominfo.tanbu@egov.com',
                'nomor_telepon' => '081234567826',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Tidak tersedia',
            ],
            [
                'nama' => 'Diskominfo Kab. HSU',
                'username' => 'diskominfohsu',
                'email' => 'diskominfo.hsu@egov.com',
                'nomor_telepon' => '081234567827',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Tidak tersedia',
            ],
            [
                'nama' => 'Diskominfo Kab. Rantau',
                'username' => 'diskominforantau',
                'email' => 'diskominfo.rantau@egov.com',
                'nomor_telepon' => '081234567828',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Tidak tersedia',
            ],
            [
                'nama' => 'Diskominfo Kab. Pelaihari',
                'username' => 'diskominfopelaihari',
                'email' => 'diskominfo.pelaihari@egov.com',
                'nomor_telepon' => '081234567829',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Tidak tersedia',
            ],
        ];

        foreach ($daftarResponden as $responden) {
            $user = User::create([
                'nama' => $responden['nama'],
                'username' => $responden['username'],
                'email' => $responden['email'],
                'nomor_telepon' => $responden['nomor_telepon'],
                'password' => Hash::make('password123'),
                'peran_id' => Peran::PERAN_RESPONDEN_ID,
            ]);
            Responden::create([
                'user_id' => $user->id,
                'status_progres_evaluasi_responden_id' => 1,
                'daerah' => $responden['daerah'],
                'alamat' => $responden['alamat'],
                'akses_evaluasi' => 1
            ]);
        }
    }
}
