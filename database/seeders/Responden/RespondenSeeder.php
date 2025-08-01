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
            // Provinsi
            [
                'nama' => 'Dinas Pendidikan dan Kebudayaan Provinsi Kalimantan Selatan',
                'username' => 'dindikbudkalsel',
                'email' => 'dindikbudkalsel@egov.id',
                'nomor_telepon' => '081200000001',
                'daerah' => 'Provinsi',
                'alamat' => 'Jl. Dharma Praja II, Kawasan Perkantoran Pemerintah Provinsi Kalimantan Selatan, Banjarbaru',
            ],
            [
                'nama' => 'Dinas Kesehatan Provinsi Kalimantan Selatan',
                'username' => 'dinkeskalsel',
                'email' => 'dinkeskalsel@egov.id',
                'nomor_telepon' => '081200000002',
                'daerah' => 'Provinsi',
                'alamat' => 'Jl. Belitung Darat, Banjarmasin',
            ],
            [
                'nama' => 'Dinas Pekerjaan Umum dan Penataan Ruang Provinsi Kalimantan Selatan',
                'username' => 'dpuprkalsel',
                'email' => 'dpuprkalsel@egov.id',
                'nomor_telepon' => '081200000003',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Perumahan Rakyat dan Kawasan Permukiman Provinsi Kalimantan Selatan',
                'username' => 'disperkimkalsel',
                'email' => 'disperkimkalsel@egov.id',
                'nomor_telepon' => '081200000004',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Sosial Provinsi Kalimantan Selatan',
                'username' => 'dinsoskalsel',
                'email' => 'dinsoskalsel@egov.id',
                'nomor_telepon' => '081200000005',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Tenaga Kerja dan Transmigrasi Provinsi Kalimantan Selatan',
                'username' => 'disnakertranskalsel',
                'email' => 'disnakertranskalsel@egov.id',
                'nomor_telepon' => '081200000006',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Pemberdayaan Perempuan, Perlindungan Anak dan Keluarga Berencana Provinsi Kalimantan Selatan',
                'username' => 'dp3akkalsel',
                'email' => 'dp3akkalsel@egov.id',
                'nomor_telepon' => '081200000007',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Pertanian dan Ketahanan Pangan Provinsi Kalimantan Selatan',
                'username' => 'dpkpkalsel',
                'email' => 'dpkpkalsel@egov.id',
                'nomor_telepon' => '081200000008',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Lingkungan Hidup Provinsi Kalimantan Selatan',
                'username' => 'dlhkalsel',
                'email' => 'dlhkalsel@egov.id',
                'nomor_telepon' => '081200000009',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Kependudukan Pencatatan Sipil Provinsi Kalimantan Selatan',
                'username' => 'dukcapilkalsel',
                'email' => 'dukcapilkalsel@egov.id',
                'nomor_telepon' => '081200000010',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Pemberdayaan Masyarakat dan Desa Provinsi Kalimantan Selatan',
                'username' => 'dpmdkalsel',
                'email' => 'dpmdkalsel@egov.id',
                'nomor_telepon' => '081200000011',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Perhubungan Provinsi Kalimantan Selatan',
                'username' => 'dishubkalsel',
                'email' => 'dishubkalsel@egov.id',
                'nomor_telepon' => '081200000012',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Komunikasi dan Informatika Provinsi Kalimantan Selatan',
                'username' => 'diskominfokalsel',
                'email' => 'diskominfokalsel@egov.id',
                'nomor_telepon' => '081200000013',
                'daerah' => 'Provinsi',
                'alamat' => 'Jl. Dharma Praja II, Banjarbaru',
            ],
            [
                'nama' => 'Dinas Koperasi, Usaha Kecil, dan Menengah Provinsi Kalimantan Selatan',
                'username' => 'diskopukmkalsel',
                'email' => 'diskopukmkalsel@egov.id',
                'nomor_telepon' => '081200000014',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Kalimantan Selatan',
                'username' => 'dpmptspkalsel',
                'email' => 'dpmptspkalsel@egov.id',
                'nomor_telepon' => '081200000015',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Kepemudaan dan Olahraga Provinsi Kalimantan Selatan',
                'username' => 'dispora_kalsel',
                'email' => 'dispora_kalsel@egov.id',
                'nomor_telepon' => '081200000016',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Pariwisata Provinsi Kalimantan Selatan',
                'username' => 'disparkalsel',
                'email' => 'disparkalsel@egov.id',
                'nomor_telepon' => '081200000017',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Perpustakaan dan Kearsipan Provinsi Kalimantan Selatan',
                'username' => 'dispersipkalsel',
                'email' => 'dispersipkalsel@egov.id',
                'nomor_telepon' => '081200000018',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Kelautan dan Perikanan Provinsi Kalimantan Selatan',
                'username' => 'dkpkalsel',
                'email' => 'dkpkalsel@egov.id',
                'nomor_telepon' => '081200000019',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Perkebunan dan Peternakan Provinsi Kalimantan Selatan',
                'username' => 'disbunnakkalsel',
                'email' => 'disbunnakkalsel@egov.id',
                'nomor_telepon' => '081200000020',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Kehutanan Provinsi Kalimantan Selatan',
                'username' => 'dishutkalsel',
                'email' => 'dishutkalsel@egov.id',
                'nomor_telepon' => '081200000021',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Energi dan Sumber Daya Mineral Provinsi Kalimantan Selatan',
                'username' => 'esdmkalsel',
                'email' => 'esdmkalsel@egov.id',
                'nomor_telepon' => '081200000022',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Perdagangan Provinsi Kalimantan Selatan',
                'username' => 'disdagkalsel',
                'email' => 'disdagkalsel@egov.id',
                'nomor_telepon' => '081200000023',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Perindustrian Provinsi Kalimantan Selatan',
                'username' => 'disperinkalsel',
                'email' => 'disperinkalsel@egov.id',
                'nomor_telepon' => '081200000024',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Badan Perencanaan Pembangunan Daerah Provinsi Kalimantan Selatan',
                'username' => 'bappedakalsel',
                'email' => 'bappedakalsel@egov.id',
                'nomor_telepon' => '081200000025',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Inspektorat Provinsi Kalimantan Selatan',
                'username' => 'inspektoratkalsel',
                'email' => 'inspektoratkalsel@egov.id',
                'nomor_telepon' => '081200000026',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Badan Kepegawaian Daerah Provinsi Kalimantan Selatan',
                'username' => 'bkdkalsel',
                'email' => 'bkdkalsel@egov.id',
                'nomor_telepon' => '081200000027',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Badan Pengembangan Sumber Daya Manusia Provinsi Kalimantan Selatan',
                'username' => 'bpsdmkalsel',
                'email' => 'bpsdmkalsel@egov.id',
                'nomor_telepon' => '081200000028',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Badan Riset dan Inovasi Daerah Provinsi Kalimantan Selatan',
                'username' => 'brindakalsel',
                'email' => 'brindakalsel@egov.id',
                'nomor_telepon' => '081200000029',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Badan Pendapatan Daerah Provinsi Kalimantan Selatan',
                'username' => 'bapkadakalsel',
                'email' => 'bapkadakalsel@egov.id',
                'nomor_telepon' => '081200000030',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Badan Pengelolaan Keuangan dan Aset Daerah Provinsi Kalimantan Selatan',
                'username' => 'bpkadkalsel',
                'email' => 'bpkadkalsel@egov.id',
                'nomor_telepon' => '081200000031',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'BPBD Provinsi Kalimantan Selatan',
                'username' => 'bpbdkalsel',
                'email' => 'bpbdkalsel@egov.id',
                'nomor_telepon' => '081200000032',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Badan Kesatuan Bangsa dan Politik Provinsi Kalimantan Selatan',
                'username' => 'bakesbangpolkalsel',
                'email' => 'bakesbangpolkalsel@egov.id',
                'nomor_telepon' => '081200000033',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Satuan Polisi Pamong Praja & Damkar Provinsi Kalimantan Selatan',
                'username' => 'satpolppdamkarkalsel',
                'email' => 'satpolppdamkarkalsel@egov.id',
                'nomor_telepon' => '081200000034',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Biro Pemerintahan dan Otonomi Daerah Provinsi Kalimantan Selatan',
                'username' => 'biropemotdakalsel',
                'email' => 'biropemotdakalsel@egov.id',
                'nomor_telepon' => '081200000035',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Biro Hukum Provinsi Kalimantan Selatan',
                'username' => 'birohukunkalsel',
                'email' => 'birohukunkalsel@egov.id',
                'nomor_telepon' => '081200000036',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Biro Organisasi Provinsi Kalimantan Selatan',
                'username' => 'biroorganisasikalsel',
                'email' => 'biroorganisasikalsel@egov.id',
                'nomor_telepon' => '081200000037',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Biro Perekonomian Provinsi Kalimantan Selatan',
                'username' => 'biroperekonomiankalsel',
                'email' => 'biroperekonomiankalsel@egov.id',
                'nomor_telepon' => '081200000038',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Biro Administrasi Pembangunan Provinsi Kalimantan Selatan',
                'username' => 'biroadmpembangunankalsel',
                'email' => 'biroadmpembangunankalsel@egov.id',
                'nomor_telepon' => '081200000039',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Biro Kesejahteraan Rakyat Provinsi Kalimantan Selatan',
                'username' => 'birokesrakkalsel',
                'email' => 'birokesrakkalsel@egov.id',
                'nomor_telepon' => '081200000040',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Biro Administrasi Pimpinan Provinsi Kalimantan Selatan',
                'username' => 'biroadmpimpkalsel',
                'email' => 'biroadmpimpkalsel@egov.id',
                'nomor_telepon' => '081200000041',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Biro Umum Provinsi Kalimantan Selatan',
                'username' => 'biroumumkalsel',
                'email' => 'biroumumkalsel@egov.id',
                'nomor_telepon' => '081200000042',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Biro Pengadaan Barang/Jasa Provinsi Kalimantan Selatan',
                'username' => 'biropengadaankalsel',
                'email' => 'biropengadaankalsel@egov.id',
                'nomor_telepon' => '081200000043',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Sekretaris DPRD Prov. Kalsel',
                'username' => 'setdprdprovkalsel',
                'email' => 'setdprdprovkalsel@egov.id',
                'nomor_telepon' => '081200000044',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'RSUD Ulin Banjarmasin Provinsi Kalimantan Selatan',
                'username' => 'rsudulinkalsel',
                'email' => 'rsudulinkalsel@egov.id',
                'nomor_telepon' => '081200000045',
                'daerah' => 'Provinsi',
                'alamat' => 'Jl. Jenderal Ahmad Yani Km. 1, Banjarmasin',
            ],
            [
                'nama' => 'RS. Dr. H. Moch. Ansari Saleh Provinsi Kalimantan Selatan',
                'username' => 'rsansarisalekalsel',
                'email' => 'rsansarisalekalsel@egov.id',
                'nomor_telepon' => '081200000046',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'Rumah Sakit Jiwa Sambang Lihum Provinsi Kalimantan Selatan',
                'username' => 'rsjsambanglihukalsel',
                'email' => 'rsjsambanglihukalsel@egov.id',
                'nomor_telepon' => '081200000047',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            [
                'nama' => 'RSGM Gusti Hasan Aman Provinsi Kalimantan Selatan',
                'username' => 'rsgmgustihasankalsel',
                'email' => 'rsgmgustihasankalsel@egov.id',
                'nomor_telepon' => '081200000048',
                'daerah' => 'Provinsi',
                'alamat' => '',
            ],
            // Kabupaten/Kota
            [
                'nama' => 'Dinas Komunikasi dan Informatika Kota Banjarbaru',
                'username' => 'diskominfobanjarbaru',
                'email' => 'diskominfokotabanjarbaru@egov.id',
                'nomor_telepon' => '081300000001',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => 'Jl. Pangeran Suriansyah No.5, Kel. Komet, Kec. Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan 70711',
            ],
            [
                'nama' => 'Dinas Komunikasi dan Informatika Kabupaten Banjar',
                'username' => 'diskominfobanjar',
                'email' => 'diskominfobanjar@egov.com',
                'nomor_telepon' => '081300000002',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Komunikasi dan Informatika Kota Banjarmasin',
                'username' => 'diskominfobanjarmasin',
                'email' => 'diskominfo.bmb@egov.com',
                'nomor_telepon' => '081300000003',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => '',
            ],
            [
                'nama' => 'Dinas Komunikasi dan Informatika Kabupaten Tanah Laut',
                'username' => 'diskominfotanahlaut',
                'email' => 'diskominfotanahlaut@egov.com',
                'nomor_telepon' => '081300000004',
                'daerah' => 'Kabupaten/Kota',
                'alamat' => '',
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
