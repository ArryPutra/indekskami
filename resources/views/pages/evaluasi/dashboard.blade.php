@extends('layouts.layout')

@section('content')
    <section class="md:flex gap-2 mb-4">
        <h1>Tanggal Waktu Mulai Pengisian:</h1>
        <b>{{ Carbon\Carbon::parse($hasilEvaluasi->created_at)->translatedFormat('l, d F Y, H:i:s') }}</b>
    </section>

    <div class="border p-3 border-gray-200 rounded-lg mb-4">
        <h1 class="mb-4 font-bold text-xl">Identitas Responden</h1>
        <div class="gap-3 grid md:grid-cols-2">
            <section>
                <h1>Identitas Instansi:</h1>
                <b>Satuan Kerja</b>
            </section>
            <section>
                <h1>Alamat:</h1>
                <b>{{ $responden->alamat }}</b>
            </section>
            <section>
                <h1>Nomor Telepon:</h1>
                <b>{{ $responden->user->nomor_telepon }}</b>
            </section>
            <section>
                <h1>Email:</h1>
                <b>{{ $responden->user->email }}</b>
            </section>
            <section>
                <h1>Pengisi Lembar Evaluasi:</h1>
                <b>{{ $identitasResponden->pengisi_lembar_evaluasi }}</b>
            </section>
            <section>
                <h1>Jabatan:</h1>
                <b>{{ $identitasResponden->jabatan }}</b>
            </section>
            <section>
                <h1>Deskripsi Ruang Lingkup:</h1>
                <b>{{ $identitasResponden->deskripsi_ruang_lingkup }}</b>
            </section>
        </div>
    </div>

    <div class="mb-6 -mx-4">
        <div class="bg-black p-3 text-white grid md:grid-cols-2 gap-2">
            <section>
                <span>Skor Kategori SE:</span>
                <strong>14</strong>
            </section>
            <section>
                <span>Kategori SE:</span>
                <strong>Rendah</strong>
            </section>
        </div>
        <div class="w-full grid md:grid-cols-2 gap-2 items-center border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1 class="whitespace-nowrap">Hasil Evaluasi Akhir:</h1>
            <div class="bg-lime-600 text-white h-12 flex items-center justify-center w-full text-center font-bold">
                Baik
            </div>
        </div>
        <div class="w-full grid md:grid-cols-2 gap-2 items-center border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1>Tingkat Kelengkapan Penerapan Standar ISO27001 sesuai Kategori SE</h1>
            <div class="flex gap-2 items-center relative">
                <div class="h-12 flex w-full">
                    <div class="bg-red-600 w-full h-full"></div>
                    <div class="bg-yellow-500 w-full h-full"></div>
                    <div class="bg-lime-300 w-full h-full"></div>
                    <div class="bg-lime-600 w-full h-full"></div>
                    <div class="bg-black w-1/3 h-3 absolute top-1/2 -translate-y-1/2"></div>
                </div>
                <strong>918</strong>
            </div>
        </div>
        <section class="w-full grid md:grid-cols-2 gap-1 border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1>Tata Kelola: <b>126</b></h1>
            <h1>T. Kematangan: <b>IV</b></h1>
        </section>
        <section class="w-full grid md:grid-cols-2 gap-1 border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1>Pengelolaan Risiko: <b>126</b></h1>
            <h1>T. Kematangan: <b>IV</b></h1>
        </section>
        <section class="w-full grid md:grid-cols-2 gap-1 border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1>Kerangka Kerja Keamanan Informasi: <b>126</b></h1>
            <h1>T. Kematangan: <b>IV</b></h1>
        </section>
        <section class="w-full grid md:grid-cols-2 gap-1 border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1>Pengelolaan Aset: <b>126</b></h1>
            <h1>T. Kematangan: <b>IV</b></h1>
        </section>
        <section class="w-full grid md:grid-cols-2 gap-1 border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1>Teknologi dan Keamanan Informasi: <b>126</b></h1>
            <h1>T. Kematangan: <b>IV</b></h1>
        </section>
        <section class="w-full grid md:grid-cols-2 gap-1 border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1>Perlindungan Data Pribadi: <b>126</b></h1>
            <h1>T. Kematangan: <b>IV</b></h1>
        </section>
        <section class="w-full grid md:grid-cols-2 gap-1 border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1>Pengamanan Keterlibatan Pihak Ketiga: <b>100%</b></h1>
        </section>
        <section class="w-full border-b border-gray-200 p-4">
            <div id="container"></div>
        </section>
    </div>

    <div class="flex gap-4 flex-wrap">
        <x-button color="gray">
            Cetak Laporan Evaluasi
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd"
                    d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                    clip-rule="evenodd" />
            </svg>
        </x-button>
        <x-button>Kirim & Selesaikan Evaluasi</x-button>
    </div>

    <footer
        class="
fixed bottom-0 left-0 w-full
bg-white px-6 max-md:px-4 py-4 border-t border-gray-200 flex gap-2 overflow-x-auto">
        <x-button color="gray"
            href="{{ route('responden.evaluasi.identitas-responden.edit', $hasilEvaluasi->identitas_responden_id) }}">Identitas</x-button>
        @foreach ($daftarAreaEvaluasiUtama as $areaEvaluasiUtama)
            <x-button href="{{ route('responden.evaluasi.pertanyaan', [$areaEvaluasiUtama->id, $hasilEvaluasi->id]) }}"
                color="gray">
                {{ $areaEvaluasiUtama->nama_evaluasi }}
            </x-button>
        @endforeach
        <x-button>Dashboard</x-button>
    </footer>
@endsection
@push('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        Highcharts.chart('container', {
            chart: {
                polar: true,
                type: 'area',
            },

            title: {
                text: ''
            },

            pane: {
                size: '90%'
            },

            xAxis: {
                categories: [
                    'Tata Kelola', 'Pengelolaan Risiko', 'Kerangka Kerja', 'Pengelolaan Aset',
                    'Aspek Teknologi', 'PDP'
                ],
                tickmarkPlacement: 'on',
                lineWidth: 0,
                labels: {
                    style: {
                        fontWeight: 'bold',
                        fontSize: '14px'
                    }
                }
            },

            yAxis: {
                gridLineInterpolation: 'polygon',
                lineWidth: 1.5,
                lineColor: '#cc6600',
                min: 0,
                max: 5,
                tickInterval: 0.5,
                tickPositions: [0, 0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5],
                allowDecimals: true,
                labels: {
                    style: {
                        color: '#a52a2a', // merah coklat
                        fontWeight: 'bold'
                    }
                },
                gridLineColor: '#cc6600',
                gridLineDashStyle: 'Dash'
            },

            tooltip: {
                shared: true
            },

            legend: {
                align: 'right',
                verticalAlign: 'middle',
                layout: 'vertical'
            },

            series: [{
                    name: 'Kepatuhan ISO/SNI 27001',
                    data: [4, 5, 5, 3.5, 4.5, 3],
                    pointPlacement: 'on',
                    color: '#7cb342',
                    fillOpacity: 1,
                    lineWidth: 0,
                    zIndex: 1
                },
                {
                    name: 'Penerapan Operasional',
                    data: [3, 3.5, 3, 2.5, 3, 2.5],
                    pointPlacement: 'on',
                    color: '#aed581',
                    fillOpacity: 1,
                    lineWidth: 0,
                    zIndex: 2
                },
                {
                    name: 'Kerangka Kerja Dasar',
                    data: [2, 2.5, 2, 1.5, 2, 2],
                    pointPlacement: 'on',
                    color: '#dcedc8',
                    fillOpacity: 1,
                    lineWidth: 0,
                    zIndex: 3
                },
                {
                    name: 'responden',
                    data: [4, 5, 5, 3.5, 4.5, 3],
                    pointPlacement: 'on',
                    type: 'line',
                    color: '#f44336',
                    lineWidth: 4,
                    zIndex: 4,
                    marker: {
                        enabled: true,
                        symbol: 'square',
                        radius: 4,
                        fillColor: '#fff',
                        lineColor: '#f44336',
                        lineWidth: 2
                    }
                }
            ]
        });
    </script>
@endpush
