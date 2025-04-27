<?php

namespace Database\Seeders;

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
                'nama' => 'Diskominfo Prov Kalsel',
                'username' => 'diskominfoprovkalsel',
                'email' => 'diskominfo.provkalsel@egov.com',
                'nomor_telepon' => '081234567810',
                'daerah' => 'Provinsi'
            ],
            [
                'nama' => 'Disdikbud Prov Kalsel',
                'username' => 'disdikbudprovkalsel',
                'email' => 'disdikbud.provkalsel@egov.com',
                'nomor_telepon' => '081234567811',
                'daerah' => 'Provinsi'
            ],
            // [
            //     'nama' => 'Disdukcapil Prov Kalsel',
            //     'username' => 'disdukcapilprovkalsel',
            //     'email' => 'disdukcapil.provkalsel@egov.com',
            //     'nomor_telepon' => '081234567812',
            //     'daerah' => 'Provinsi'
            // ],
            // [
            //     'nama' => 'RSGM',
            //     'username' => 'rsgm',
            //     'email' => 'rsgm@egov.com',
            //     'nomor_telepon' => '081234567813',
            //     'daerah' => 'Provinsi'
            // ],
            // [
            //     'nama' => 'Dinas Sosial Prov Kalsel',
            //     'username' => 'dinassosialprovkalsel',
            //     'email' => 'dinassosial.provkalsel@egov.com',
            //     'nomor_telepon' => '081234567814',
            //     'daerah' => 'Provinsi'
            // ],
            // [
            //     'nama' => 'Dispar Prov Kalsel',
            //     'username' => 'disparprovkalsel',
            //     'email' => 'dispar.provkalsel@egov.com',
            //     'nomor_telepon' => '081234567815',
            //     'daerah' => 'Provinsi'
            // ],
            // [
            //     'nama' => 'Disperin Prov Kalsel',
            //     'username' => 'disperinprovkalsel',
            //     'email' => 'disperin.provkalsel@egov.com',
            //     'nomor_telepon' => '081234567816',
            //     'daerah' => 'Provinsi'
            // ],
            // [
            //     'nama' => 'Dinas PMD Prov Kalsel',
            //     'username' => 'dinaspmdprovkalsel',
            //     'email' => 'dinaspmd.provkalsel@egov.com',
            //     'nomor_telepon' => '081234567817',
            //     'daerah' => 'Provinsi'
            // ],
            // [
            //     'nama' => 'DP3A Prov Kalsel',
            //     'username' => 'dp3aprovkalsel',
            //     'email' => 'dp3a.provkalsel@egov.com',
            //     'nomor_telepon' => '081234567818',
            //     'daerah' => 'Provinsi'
            // ],
            // [
            //     'nama' => 'Diskominfo Kab. Banjar',
            //     'username' => 'diskominfobanjar',
            //     'email' => 'diskominfo.banjar@egov.com',
            //     'nomor_telepon' => '081234567819',
            //     'daerah' => 'Kabupaten/Kota'
            // ],
            // [
            //     'nama' => 'Diskominfo Banjarmasin',
            //     'username' => 'diskominfobjm',
            //     'email' => 'diskominfo.bmb@egov.com',
            //     'nomor_telepon' => '081234567820',
            //     'daerah' => 'Kabupaten/Kota'
            // ],
            // [
            //     'nama' => 'Diskominfo Kab. Tanah Laut',
            //     'username' => 'diskominfotanahlaut',
            //     'email' => 'diskominfo.tanahlaut@egov.com',
            //     'nomor_telepon' => '081234567821',
            //     'daerah' => 'Kabupaten/Kota'
            // ],
            // [
            //     'nama' => 'Diskominfo Kab. Tapin',
            //     'username' => 'diskominfotapin',
            //     'email' => 'diskominfo.tapin@egov.com',
            //     'nomor_telepon' => '081234567822',
            //     'daerah' => 'Kabupaten/Kota'
            // ],
            // [
            //     'nama' => 'Diskominfo Kab. Balangan',
            //     'username' => 'diskominfobalangan',
            //     'email' => 'diskominfo.balangan@egov.com',
            //     'nomor_telepon' => '081234567823',
            //     'daerah' => 'Kabupaten/Kota'
            // ],
            // [
            //     'nama' => 'Diskominfo Kab. Kotabaru',
            //     'username' => 'diskominfokotabaru',
            //     'email' => 'diskominfo.kotabaru@egov.com',
            //     'nomor_telepon' => '081234567824',
            //     'daerah' => 'Kabupaten/Kota'
            // ],
            // [
            //     'nama' => 'Diskominfo Kab. Tabalong',
            //     'username' => 'diskominfotabalong',
            //     'email' => 'diskominfo.tabalong@egov.com',
            //     'nomor_telepon' => '081234567825',
            //     'daerah' => 'Kabupaten/Kota'
            // ],
            // [
            //     'nama' => 'Diskominfo Kab. Tanbu',
            //     'username' => 'diskominfotanbu',
            //     'email' => 'diskominfo.tanbu@egov.com',
            //     'nomor_telepon' => '081234567826',
            //     'daerah' => 'Kabupaten/Kota'
            // ],
            // [
            //     'nama' => 'Diskominfo Kab. HSU',
            //     'username' => 'diskominfohsu',
            //     'email' => 'diskominfo.hsu@egov.com',
            //     'nomor_telepon' => '081234567827',
            //     'daerah' => 'Kabupaten/Kota'
            // ],
            // [
            //     'nama' => 'Diskominfo Kab. Rantau',
            //     'username' => 'diskominforantau',
            //     'email' => 'diskominfo.rantau@egov.com',
            //     'nomor_telepon' => '081234567828',
            //     'daerah' => 'Kabupaten/Kota'
            // ],
            // [
            //     'nama' => 'Diskominfo Kab. Pelaihari',
            //     'username' => 'diskominfopelaihari',
            //     'email' => 'diskominfo.pelaihari@egov.com',
            //     'nomor_telepon' => '081234567829',
            //     'daerah' => 'Kabupaten/Kota'
            // ],
        ];

        foreach ($daftarResponden as $responden) {
            $user = User::create([
                'nama' => $responden['nama'],
                'username' => $responden['username'],
                'email' => $responden['email'],
                'nomor_telepon' => $responden['nomor_telepon'],
                'password' => Hash::make('password123'),
                'peran_id' => 3,
            ]);
            Responden::create([
                'user_id' => $user->id,
                'daerah' => $responden['daerah'],
                'akses_evaluasi' => 1
            ]);
        }
    }
}
