@extends('layouts.layout')

@php
    use App\Models\Responden\NilaiEvaluasi;
    use Illuminate\Support\Str;
@endphp

@section('content')
    <form action="{{ route('manajemen.dashboard') }}" method="get">
        <section class="flex gap-6">
            <x-date onchange="this.form.submit()" name="tanggal-mulai" label="Tanggal mulai"
                value="{{ request('tanggal-mulai') }}" />
            <x-date onchange="this.form.submit()" name="tanggal-akhir" label="Tanggal akhir"
                value="{{ request('tanggal-akhir') }}" />
        </section>

        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-4 mb-6 mt-4">
            <x-card>
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                            clip-rule="evenodd" />
                        <path fill-rule="evenodd"
                            d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z"
                            clip-rule="evenodd" />
                    </svg>
                </x-slot:icon>
                <x-slot:label>Total Evaluasi Diverifikasi</x-slot:label>
                <x-slot:value>{{ $dataCard['totalEvaluasiDiverifikasi'] }}</x-slot:value>
            </x-card>
        </div>

        <x-dropdown onchange="this.form.submit()" name="kategori-se" label="Kategori Sistem Elektronik" class="!w-fit">
            <x-dropdown.option value="semua">Semua</x-dropdown.option>
            @foreach (NilaiEvaluasi::getKategoriSeOptions() as $kategoriSe)
                <x-dropdown.option :value="Str::lower($kategoriSe)" :selected="Str::lower($kategoriSe) === request('kategori-se')">{{ $kategoriSe }}</x-dropdown.option>
            @endforeach
        </x-dropdown>
    </form>

    <section class="mt-4 mb-6 border-b-2 border-gray-200">
        <div id="diagram"></div>
    </section>

    <h1 class="mb-3 font-bold text-xl">Daftar Evaluasi Terverifikasi Terbaru</h1>
    <x-table>
        <x-table.thead>
            <x-table.th>No.</x-table.th>
            <x-table.th>Nama Instansi</x-table.th>
            <x-table.th>Verifikator</x-table.th>
            <x-table.th>Evaluasi Ke</x-table.th>
            <x-table.th>Kategori Sistem Elektronik</x-table.th>
            <x-table.th>Hasil Evaluasi Akhir</x-table.th>
            <x-table.th>Tanggal Mulai</x-table.th>
            <x-table.th>Tanggal Diserahkan</x-table.th>
            <x-table.th>Tanggal Diverifikasi</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            @if ($daftarEvaluasiDiverifikasi->count() > 0)
                @foreach ($daftarEvaluasiDiverifikasi as $index => $evaluasiDiverifikasi)
                    <x-table.tr>
                        <x-table.td>{{ ($daftarEvaluasiDiverifikasi->currentPage() - 1) * $daftarEvaluasiDiverifikasi->perPage() + $index + 1 }}</x-table.td>
                        <x-table.td class="font-bold">{{ $evaluasiDiverifikasi->responden->user->nama }}</x-table.td>
                        <x-table.td>{{ $evaluasiDiverifikasi->verifikator->user->nama }}</x-table.td>
                        <x-table.td>{{ $evaluasiDiverifikasi->evaluasi_ke }}</x-table.td>
                        <x-table.td>{{ $evaluasiDiverifikasi->nilaiEvaluasi->kategori_se }}</x-table.td>
                        <x-table.td>{{ $evaluasiDiverifikasi->nilaiEvaluasi->hasil_evaluasi_akhir }}</x-table.td>
                        <x-table.td>{{ Carbon\Carbon::parse($evaluasiDiverifikasi->created_at)->translatedFormat('l, d F Y, H:i:s') }}</x-table.td>
                        <x-table.td>{{ Carbon\Carbon::parse($evaluasiDiverifikasi->tanggal_diserahkan)->translatedFormat('l, d F Y, H:i:s') }}</x-table.td>
                        <x-table.td>{{ Carbon\Carbon::parse($evaluasiDiverifikasi->tanggal_diverifikasi)->translatedFormat('l, d F Y, H:i:s') }}</x-table.td>
                        <x-table.td>
                            <x-button
                                href="{{ route('manajemen.evaluasi.dashboard.cetak-laporan', $evaluasiDiverifikasi->id) }}"
                                color="blue" class="w-fit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Cetak
                            </x-button>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            @else
                <x-table.tr>
                    <x-table.td colspan="12" class="text-center">Data kosong!</x-table.td>
                </x-table.tr>
            @endif
        </x-table.tbody>
    </x-table>

    <div class="mt-4">
        {{ $daftarEvaluasiDiverifikasi->links() }}
    </div>
@endsection

@push('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        Highcharts.chart('diagram', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Daftar SKPD Skor ISO27001 Tertinggi'
            },
            subtitle: {
                text: 'Kategori Sistem Elektronik: <strong>' +
                    "{{ Str::title(request('kategori-se') ?? 'Semua') }}" +
                    '</strong>'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Skor ISO27001'
                },
                max: {{ NilaiEvaluasi::getSkorMaksimalIso() }}
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.0f}' // tanpa desimal
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: ' +
                    '<b>{point.y:.0f}</b> Skor ISO27001 <br> {point.tanggal_diverifikasi}'
            },
            series: [{
                name: 'Responden',
                colorByPoint: true,
                data: @json($daftarRespondenChartEvaluasiDiverifikasi),
            }],
        });
    </script>
@endpush
