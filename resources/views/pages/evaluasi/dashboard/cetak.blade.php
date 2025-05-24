<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    #headerPrint {
        width: 42rem;
    }

    #mainPrint {
        width: 42rem;
    }

    @media print {
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        #headerPrint,
        #mainPrint {
            width: 100%;
        }

    }
</style>

@php
    use App\Models\Responden\StatusHasilEvaluasi;
    use App\Models\Responden\NilaiEvaluasi;
@endphp

<body>
    <header id="header"
        class="border-b border-gray-200 flex items-center justify-between md:px-8 max-md:px-4 py-4 mb-8 flex-wrap gap-4">
        <h1 class="font-semibold text-2xl">{{ $title }}</h1>
        <div class="flex gap-2">
            <x-button.back />
            <x-button onclick="cetakLaporan()" id="cetakButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="m19,7h-1V2H6v5h-1c-1.65,0-3,1.35-3,3v7c0,1.1.9,2,2,2h2v3h12v-3h2c1.1,0,2-.9,2-2v-7c0-1.65-1.35-3-3-3Zm-11-3h8v3h-8v-3Zm8,16h-8v-4h8v4Zm3-8h-4v-2h4v2Z">
                    </path>
                </svg>
                Cetak
            </x-button>
        </div>
    </header>

    <header id="headerPrint" class="flex justify-between items-center border-b-[3px] pb-2 mb-3 m-auto">
        <img class="h-24" src="{{ asset('images/logo/prov-kalsel.png') }}">
        <div class="text-center w-full">
            <h1 class="text-2xl font-bold leading-none">
                DINAS KOMUNIKASI DAN INFORMATIKA
            </h1>
            <h1 class="text-2xl font-bold leading-none mb-1.5">
                PROVINSI KALIMANTAN SELATAN
            </h1>
            <h1 class="text-lg leading-none mb-0.5">BIDANG PERSANDIAN DAN KEAMANAN INFORMASI</h1>
            <h1 class="leading-none">Jl. Dharma Praja II No. 2 Banjarbaru, Kalimantan Selatan</h1>
            <h1 class="leading-none">Telp: 0511-6749844, Pos-el: diskominfo@kalselprov.go.id</h1>
        </div>
    </header>

    <main id="mainPrint" class="m-auto">
        <h1 class="font-bold text-2xl text-center mb-6">LAPORAN HASIL EVALUASI</h1>

        {{-- DATA UTAMA --}}
        <section class="mb-6 flex gap-2">
            <div>
                <h1>Nama Instansi</h1>
                <h1>Evaluasi Ke</h1>
                <h1>Tanggal Mulai Evaluasi</h1>
                <h1>Tanggal Diserahkan</h1>
                <h1>Tanggal Diverifikasi</h1>
                <h1>Ditinjau Oleh:</h1>
            </div>

            <div>
                <h1>: <b>{{ $responden->user->nama }}</b></h1>
                <h1>: <b>{{ $hasilEvaluasi->evaluasi_ke }}</b> </h1>
                <h1>: <b>{{ Carbon\Carbon::parse($hasilEvaluasi->created_at)->translatedFormat('l, d F Y, H:i:s') }}</b>
                </h1>
                <h1>:
                    @if ($hasilEvaluasi->tanggal_diserahkan)
                        <b>{{ Carbon\Carbon::parse($hasilEvaluasi->tanggal_diserahkan)->translatedFormat('l, d F Y, H:i:s') }}</b>
                    @elseif ($hasilEvaluasi->tanggal_diserahkan)
                        <b class="text-blue-600">Dalam Proses Peninjauan</b>
                    @else
                        <b class="text-red-600">Belum Diserahkan</b>
                    @endif
                </h1>
                <h1>:
                    @if ($hasilEvaluasi->tanggal_diverifikasi)
                        <b>{{ Carbon\Carbon::parse($hasilEvaluasi->tanggal_diverifikasi)->translatedFormat('l, d F Y, H:i:s') }}</b>
                    @else
                        <b class="text-red-600">Belum Diverifikasi</b>
                    @endif
                </h1>
                <h1>:
                    @if ($hasilEvaluasi->verifikator)
                        <b>{{ $hasilEvaluasi->verifikator->user->nama }}</b>
                    @else
                        <b class="text-red-600">Belum Ditinjau</b>
                    @endif
                </h1>
            </div>
        </section>

        {{-- DATA IDENTITAS --}}
        <h1 class="font-semibold text-xl mb-3">Identitas Responden</h1>
        <section class="border border-gray-200 p-4 grid grid-cols-2 gap-2 mb-6">
            <div>
                <h1>Nomor Telepon:</h1>
                <h1 class="font-bold">{{ $identitasResponden->nomor_telepon }}</h1>
            </div>
            <div>
                <h1>Email:</h1>
                <h1 class="font-bold">{{ $identitasResponden->email }}</h1>
            </div>
            <div>
                <h1>Pengisi Lembar Evaluasi:</h1>
                <h1 class="font-bold">{{ $identitasResponden->pengisi_lembar_evaluasi }}</h1>
            </div>
            <div>
                <h1>Jabatan:</h1>
                <h1 class="font-bold">{{ $identitasResponden->jabatan }}</h1>
            </div>
            <div>
                <h1>Alamat:</h1>
                <h1 class="font-bold">{{ $responden->alamat }}</h1>
            </div>
            <div>
                <h1>Deskripsi Ruang Lingkup:</h1>
                <h1 class="font-bold">{{ $identitasResponden->deskripsi_ruang_lingkup }}</h1>
            </div>
        </section>

        {{-- NILAI EVALUASI --}}
        <div>
            <section class="bg-black text-white grid grid-cols-2 gap-2 p-2 px-4">
                <div class="flex">
                    <h1>Skor Kategori SE</h1>
                    <h1 class="font-bold">: <span>{{ $nilaiEvaluasi->skor_kategori_se }}</span></h1>
                </div>
                <div class="flex">
                    <h1>Kategori SE</h1>
                    <h1 class="font-bold">: <span>{{ $nilaiEvaluasi->kategori_se }}</span></h1>
                </div>
            </section>
            <section class="grid grid-cols-2 items-center border-b border-gray-200 py-4">
                <h1>Hasil Evaluasi Akhir:</h1>
                <div
                    class="{{ $hasilEvaluasiAkhir['color'] }} w-full text-center h-10 flex items-center justify-center text-white">
                    <b>{{ $hasilEvaluasiAkhir['label'] }}</b>
                </div>
            </section>
            <section class="grid grid-cols-2 gap-2 items-center border-b border-gray-200 py-4">
                <h1>Tingkat Kelengkapan Penerapan Standar ISO27001 sesuai Kategori SE:</h1>
                <div class="flex gap-2 items-center">
                    <div class="h-10 flex w-full relative">
                        @switch($nilaiEvaluasi->kategori_se)
                            @case(NilaiEvaluasi::SKOR_KATEGORI_SE_RENDAH)
                                <div class="bg-red-600 w-[26.67%] h-full"></div>
                                <div class="bg-yellow-500 w-[20%] h-full"></div>
                                <div class="bg-lime-400 w-[33.33%] h-full"></div>
                                <div class="bg-lime-600 w-[20%] h-full"></div>
                            @break

                            @case(NilaiEvaluasi::SKOR_KATEGORI_SE_TINGGI)
                                <div class="bg-red-600 w-[40%] h-full"></div>
                                <div class="bg-yellow-500 w-[30%] h-full"></div>
                                <div class="bg-lime-400 w-[20%] h-full"></div>
                                <div class="bg-lime-600 w-[10%] h-full"></div>
                            @break

                            @case(NilaiEvaluasi::SKOR_KATEGORI_SE_STRATEGIS)
                                <div class="bg-red-600 w-[40%] h-full"></div>
                                <div class="bg-yellow-500 w-[30%] h-full"></div>
                                <div class="bg-lime-400 w-[20%] h-full"></div>
                                <div class="bg-lime-600 w-[10%] h-full"></div>
                            @break
                        @endswitch
                        <div style="width: {{ $tingkatKelengkapanIso['persentase'] }}%;"
                            class="bg-black left-0 h-3 absolute top-1/2 -translate-y-1/2 duration-[3s] ease-in-out">
                        </div>
                    </div>
                    <strong>
                        {{ $tingkatKelengkapanIso['skor'] }}
                    </strong>
                </div>
            </section>
            @foreach ($nilaiEvaluasi->nilaiEvaluasiUtamaResponden as $nilaiEvaluasiUtamaResponden)
                <section class="grid grid-cols-2 gap-2 items-center border-b border-gray-200 py-4">
                    <h1>{{ $nilaiEvaluasiUtamaResponden->nilaiEvaluasiUtama->nama_nilai_evaluasi_utama }}:
                        <b>{{ $nilaiEvaluasiUtamaResponden->total_skor }}</b>
                    </h1>
                    <h1>Tingkat Kematangan: <b>{{ $nilaiEvaluasiUtamaResponden->status_tingkat_kematangan }}</b>
                    </h1>
                </section>
            @endforeach

            <section class="grid grid-cols-2 gap-2 items-center border-b border-gray-200 py-4">
                <h1>Pengamanan Keterlibatan Pihak Ketiga:
                    <b>{{ $nilaiEvaluasi->pengamanan_keterlibatan_pihak_ketiga }}%</b>
                </h1>
            </section>
            <section class="border-b border-gray-200 py-4">
                <div id="container"></div>
            </section>
        </div>
    </main>

    <script>
        const header = document.getElementById('header');

        function cetakLaporan() {
            header.style.display = 'none';
            window.print();
        }

        window.onafterprint = function() {
            header.style.display = 'flex';
        }
    </script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
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
                categories: {!! json_encode($daftarNilaiEvaluasiUtama->pluck('namaNilaiEvaluasiUtama')) !!},
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
            plotOptions: {
                series: {
                    animation: false // Nonaktifkan animasi pada semua seri
                }
            },
            series: [{
                    name: 'Kepatuhan ISO/SNI 27001',
                    data: [4, 5, 5, 3, 4, 3],
                    pointPlacement: 'on',
                    color: '#7cb342',
                    fillOpacity: 1,
                    lineWidth: 0,
                    zIndex: 1,
                },
                {
                    name: 'Penerapan Operasional',
                    data: [3, 4, 3, 3, 3, 3],
                    pointPlacement: 'on',
                    color: '#aed581',
                    fillOpacity: 1,
                    lineWidth: 0,
                    zIndex: 2
                },
                {
                    name: 'Kerangka Kerja Dasar',
                    data: [2, 2, 3, 2, 2, 2],
                    pointPlacement: 'on',
                    color: '#dcedc8',
                    fillOpacity: 1,
                    lineWidth: 0,
                    zIndex: 3
                },
                {
                    name: 'responden',
                    data: {!! json_encode($daftarNilaiEvaluasiUtama->pluck('skorStatusTingkatKematangan')) !!},
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

</body>

</html>
