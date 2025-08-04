<table>
    <tr>
        <th colspan="6" style="font-weight: bold;">{{ $title }}</th>
    </tr>
</table>

<table>
    <tr>
        <th style="font-weight: bold;">No</th>
        <th style="font-weight: bold;">Pertanyaan</th>
        <th style="font-weight: bold;">Jawaban</th>
        <th style="font-weight: bold;">Skor</th>
        <th style="font-weight: bold;">Dokumen</th>
        <th style="font-weight: bold;">Keterangan</th>
    </tr>

    @foreach ($daftarPertanyaanDanJawaban as $pertanyaanDanjawaban)
        <tr>
            <td>{{ $pertanyaanDanjawaban['nomor'] }}</td>
            <td>{{ $pertanyaanDanjawaban['pertanyaan'] }}</td>
            <td>{{ $pertanyaanDanjawaban['status'] }}</td>
            <td>{{ $pertanyaanDanjawaban['skor'] }}</td>
            <td>{{ $pertanyaanDanjawaban['dokumen'] }}</td>
            <td>{{ $pertanyaanDanjawaban['keterangan'] }}</td>
        </tr>
    @endforeach
</table>
