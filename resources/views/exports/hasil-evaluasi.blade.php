<table>
    <tr>
        <th colspan="2" style="text-align:center; font-weight:bold; font-size:20px;">LAPORAN HASIL EVALUASI</th>
    </tr>
</table>

<br>

<table>
    <tr>
        <th colspan="2">Data Utama</th>
    </tr>
    <tr>
        <td>Nama Instansi</td>
        <td>{{ $responden->user->nama }}</td>
    </tr>
    <tr>
        <td>Evaluasi Ke</td>
        <td>{{ $hasilEvaluasi->evaluasi_ke }}</td>
    </tr>
    <tr>
        <td>Tanggal Mulai Evaluasi</td>
        <td>{{ \Carbon\Carbon::parse($hasilEvaluasi->created_at)->translatedFormat('l, d F Y, H:i:s') }}</td>
    </tr>
    <tr>
        <td>Tanggal Diserahkan</td>
        <td>
            @if ($hasilEvaluasi->tanggal_diserahkan)
                {{ \Carbon\Carbon::parse($hasilEvaluasi->tanggal_diserahkan)->translatedFormat('l, d F Y, H:i:s') }}
            @else
                Belum Diserahkan
            @endif
        </td>
    </tr>
    <tr>
        <td>Tanggal Diverifikasi</td>
        <td>
            @if ($hasilEvaluasi->tanggal_diverifikasi)
                {{ \Carbon\Carbon::parse($hasilEvaluasi->tanggal_diverifikasi)->translatedFormat('l, d F Y, H:i:s') }}
            @else
                Belum Diverifikasi
            @endif
        </td>
    </tr>
    <tr>
        <td>Ditinjau Oleh</td>
        <td>
            @if ($hasilEvaluasi->verifikator)
                {{ $hasilEvaluasi->verifikator->user->nama }}
            @else
                Belum Ditinjau
            @endif
        </td>
    </tr>
</table>

<br>

<table>
    <tr>
        <th colspan="2">Identitas Responden</th>
    </tr>
    <tr>
        <td>Nomor Telepon</td>
        <td>{{ $identitasResponden->nomor_telepon }}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>{{ $identitasResponden->email }}</td>
    </tr>
    <tr>
        <td>Pengisi Lembar Evaluasi</td>
        <td>{{ $identitasResponden->pengisi_lembar_evaluasi }}</td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>{{ $identitasResponden->jabatan }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>{{ $responden->alamat }}</td>
    </tr>
    <tr>
        <td>Deskripsi Ruang Lingkup</td>
        <td>{{ $identitasResponden->deskripsi_ruang_lingkup }}</td>
    </tr>
</table>

<br>

<table>
    <tr>
        <td>Skor Kategori SE</td>
        <td>{{ $nilaiEvaluasi->skor_kategori_se }}</td>
    </tr>
    <tr>
        <td>Kategori SE</td>
        <td>{{ $nilaiEvaluasi->kategori_se }}</td>
    </tr>
    <tr>
        <td>Hasil Evaluasi Akhir</td>
        <td>{{ $hasilEvaluasiAkhir['label'] }}</td>
    </tr>
    <tr>
        <td>Tingkat Kelengkapan ISO 27001</td>
        <td>{{ $tingkatKelengkapanIso['skor'] }} ({{ $tingkatKelengkapanIso['persentase'] }}%)</td>
    </tr>

    @foreach ($nilaiEvaluasi->nilaiEvaluasiUtamaResponden as $item)
        <tr>
            <td>{{ $item->nilaiEvaluasiUtama->nama_nilai_evaluasi_utama }}</td>
            <td>
                Skor: {{ $item->total_skor }},
                Tingkat Kematangan: {{ $item->status_tingkat_kematangan }}
            </td>
        </tr>
    @endforeach

    <tr>
        <td>Pengamanan Keterlibatan Pihak Ketiga</td>
        <td>{{ $nilaiEvaluasi->pengamanan_keterlibatan_pihak_ketiga }}%</td>
    </tr>
</table>
