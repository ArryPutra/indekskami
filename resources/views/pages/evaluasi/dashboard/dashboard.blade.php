@extends('layouts.layout', [
    'class' => 'mb-18',
])

@php
    use App\Models\Responden\StatusHasilEvaluasi;
    use App\Models\Responden\NilaiEvaluasi;
@endphp

@section('content')
    <section class="md:flex gap-2">
        <h1>Tanggal Waktu Mulai Evaluasi:</h1>
        <b>{{ Carbon\Carbon::parse($hasilEvaluasi->created_at)->translatedFormat('l, d F Y, H:i:s') }}</b>
    </section>

    <section class="md:flex gap-2 mb-4">
        <h1>Status Evaluasi Anda Saat Ini:</h1>
        @switch($statusHasilEvaluasiSaatIni)
            @case(StatusHasilEvaluasi::STATUS_DIKERJAKAN)
                <b class="text-blue-600">Sedang {{ $statusHasilEvaluasiSaatIni }}</b>
            @break

            @case(StatusHasilEvaluasi::STATUS_DITINJAU)
                <b class="text-yellow-600">Sedang {{ $statusHasilEvaluasiSaatIni }}</b>
            @break

            @case(StatusHasilEvaluasi::STATUS_DIVERIFIKASI)
                <b class="text-primary">Telah {{ $statusHasilEvaluasiSaatIni }}</b>
            @break
        @endswitch
    </section>

    @if ($hasilEvaluasi->catatan)
        @switch($hasilEvaluasi->status_hasil_evaluasi_id)
            @case(StatusHasilEvaluasi::STATUS_DIKERJAKAN_ID)
                <x-alert type="error" class="mb-4">
                    <b>Catatan revisi dari verifikator:</b>
                    <br>
                    <span>{{ $hasilEvaluasi->catatan }}</span>
                </x-alert>
            @break

            @case(StatusHasilEvaluasi::STATUS_DIVERIFIKASI_ID)
                <x-alert type="success" class="mb-4">
                    <b>Catatan verifikasi dari verifikator:</b>
                    <br>
                    <span>{{ $hasilEvaluasi->catatan }}</span>
                </x-alert>
            @break

            @default
                <x-alert type="warning" class="mb-4">
                    <b>Catatan terakhir dari verifikator:</b>
                    <br>
                    <span>{{ $hasilEvaluasi->catatan }}</span>
                </x-alert>
        @endswitch
    @endif

    <div class="border p-3 border-gray-200 rounded-lg mb-4">
        <h1 class="mb-4 font-bold text-xl">Identitas Responden</h1>
        <div class="gap-3 grid md:grid-cols-2">
            <section>
                <h1>Nomor Telepon:</h1>
                <b>{{ $identitasResponden->nomor_telepon }}</b>
            </section>
            <section>
                <h1>Email:</h1>
                <b>{{ $identitasResponden->email }}</b>
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
                <h1>Alamat:</h1>
                <b>{{ $responden->alamat }}</b>
            </section>
            <section>
                <h1>Deskripsi Ruang Lingkup:</h1>
                <b>{{ $identitasResponden->deskripsi_ruang_lingkup }}</b>
            </section>
        </div>
    </div>

    <div class="mb-4">
        <h1 class="text-xl font-semibold mb-2">
            <span>Progres Evaluasi Terjawab</span>
        </h1>
        <div class="w-full h-9 bg-gray-100 border border-gray-300 rounded-md overflow-hidden mb-2">
            <div x-cloak x-data="{ width: 0 }" x-init="setTimeout(() => {
                width = {{ $progresEvaluasiTerjawab['persen'] }};
            }, 150)" class="bg-primary h-full duration-[3s] ease-in-out"
                :style="`width: ${width}%;`">
            </div>
        </div>
        <span>{{ $progresEvaluasiTerjawab['label'] }}</span>
    </div>

    <div class="mb-6 -mx-4">
        <div class="bg-black p-3 text-white grid md:grid-cols-2 gap-2">
            <section>
                <span>Skor Kategori SE:</span>
                <strong>{{ $nilaiEvaluasi->skor_kategori_se }}</strong>
            </section>
            <section>
                <span>Kategori SE:</span>
                <strong>{{ $nilaiEvaluasi->kategori_se }}</strong>
            </section>
        </div>
        <div class="w-full grid md:grid-cols-2 gap-2 items-center border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1 class="whitespace-nowrap">Hasil Evaluasi Akhir:</h1>
            <div
                class="{{ $hasilEvaluasiAkhir['color'] }} text-white h-12 flex items-center justify-center w-full text-center font-bold">
                {{ $hasilEvaluasiAkhir['label'] }}
            </div>
        </div>
        <div class="w-full grid md:grid-cols-2 gap-2 items-center border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1>Tingkat Kelengkapan Penerapan Standar ISO27001 sesuai Kategori SE</h1>
            <div class="flex gap-2 items-center">
                <div class="h-12 flex w-full relative">
                    @switch($nilaiEvaluasi->kategori_se)
                        @case(NilaiEvaluasi::KATEGORI_SE_RENDAH)
                            <div class="bg-red-600 w-[26.67%] h-full"></div>
                            <div class="bg-yellow-500 w-[20%] h-full"></div>
                            <div class="bg-lime-400 w-[33.33%] h-full"></div>
                            <div class="bg-lime-600 w-[20%] h-full"></div>
                        @break

                        @case(NilaiEvaluasi::KATEGORI_SE_TINGGI)
                            <div class="bg-red-600 w-[40%] h-full"></div>
                            <div class="bg-yellow-500 w-[30%] h-full"></div>
                            <div class="bg-lime-400 w-[20%] h-full"></div>
                            <div class="bg-lime-600 w-[10%] h-full"></div>
                        @break

                        @default
                            <div class="bg-red-600 w-[50%] h-full"></div>
                            <div class="bg-yellow-500 w-[30%] h-full"></div>
                            <div class="bg-lime-400 w-[13.33%] h-full"></div>
                            <div class="bg-lime-600 w-[6.67%] h-full"></div>
                    @endswitch
                    <div x-data="{ persentase: 0 }" x-init="setTimeout(() => {
                        persentase = {{ $tingkatKelengkapanIso['persentase'] }}
                    })" :style="`width: ${persentase}%;`"
                        class="bg-black left-0 h-3 absolute top-1/2 -translate-y-1/2 duration-[3s] ease-in-out">
                    </div>
                </div>
                <strong>
                    {{ $tingkatKelengkapanIso['skor'] }}
                </strong>
            </div>
        </div>
        @foreach ($nilaiEvaluasi->nilaiEvaluasiUtamaResponden as $nilaiEvaluasiUtamaResponden)
            <section class="w-full grid md:grid-cols-2 gap-1 border-b border-gray-200 p-4 hover:bg-gray-50">
                <h1>{{ $nilaiEvaluasiUtamaResponden->nilaiEvaluasiUtama->nama_nilai_evaluasi_utama }}:
                    <b>{{ $nilaiEvaluasiUtamaResponden->total_skor }}</b>
                </h1>
                <h1>Tingkat Kematangan: <b>{{ $nilaiEvaluasiUtamaResponden->status_tingkat_kematangan }}</b></h1>
            </section>
        @endforeach
        <section class="w-full grid md:grid-cols-2 gap-1 border-b border-gray-200 p-4 hover:bg-gray-50">
            <h1>
                Pengamanan Keterlibatan Pihak Ketiga:
                <b>{{ $nilaiEvaluasi->pengamanan_keterlibatan_pihak_ketiga }}%</b>
            </h1>
        </section>
        <section class="w-full border-b border-gray-200 p-4">
            <div id="diagram"></div>
        </section>
    </div>

    <div class="flex gap-3 flex-wrap">
        <x-button color="gray"
            href="{{ $isResponden
                ? route('responden.evaluasi.dashboard.cetak-laporan', $hasilEvaluasiId)
                : route('verifikator.evaluasi.dashboard.cetak-laporan', $hasilEvaluasiId) }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd"
                    d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                    clip-rule="evenodd" />
            </svg>
            Cetak Laporan Evaluasi
        </x-button>
        @if ($isResponden)
            @if ($apakahEvaluasiDapatDikerjakan)
                <form action="{{ route('responden.evaluasi.dashboard.kirim-evaluasi', $hasilEvaluasiId) }}"
                    id="formKirimEvaluasi" method="post">
                    @csrf
                    <x-button onclick="kirimEvaluasi()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M9 15.59 4.71 11.3 3.3 12.71l5 5c.2.2.45.29.71.29s.51-.1.71-.29l11-11-1.41-1.41L9.02 15.59Z">
                            </path>
                        </svg>
                        Kirim & Selesaikan Evaluasi
                    </x-button>
                </form>
            @endif
        @else
            @if ($statusHasilEvaluasiSaatIni === StatusHasilEvaluasi::STATUS_DITINJAU)
                <form action="{{ route('verifikator.evaluasi.dashboard.verifikasi-evaluasi', $hasilEvaluasiId) }}"
                    id="formVerifikasiEvaluasi" method="post">
                    @csrf
                    <input type="hidden" name="catatan" id="formVerifikasiEvaluasi-catatan">
                    <input type="hidden" name="akses_evaluasi_responden"
                        id="formVerifikasiEvaluasi-aksesEvaluasiResponden">
                    <x-button type="submit" onclick="verifikasiEvaluasi()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M9 15.59 4.71 11.3 3.3 12.71l5 5c.2.2.45.29.71.29s.51-.1.71-.29l11-11-1.41-1.41L9.02 15.59Z">
                            </path>
                        </svg>
                        Verifikasi Evaluasi
                    </x-button>
                </form>
            @endif
            @if ($statusHasilEvaluasiSaatIni !== StatusHasilEvaluasi::STATUS_DIKERJAKAN)
                <form action="{{ route('verifikator.evaluasi.dashboard.revisi-evaluasi', $hasilEvaluasiId) }}"
                    id="formRevisiEvaluasi" method="post">
                    @csrf
                    <input type="hidden" name="catatan" id="formRevisiEvaluasi-catatan">
                    <x-button color="red" onclick="revisiEvaluasi()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M19.07 4.93a9.9 9.9 0 0 0-3.18-2.14 10.12 10.12 0 0 0-7.79 0c-1.19.5-2.26 1.23-3.18 2.14S3.28 6.92 2.78 8.11A9.95 9.95 0 0 0 1.99 12h2c0-1.08.21-2.13.63-3.11.4-.95.98-1.81 1.72-2.54.73-.74 1.59-1.31 2.54-1.71 1.97-.83 4.26-.83 6.23 0 .95.4 1.81.98 2.54 1.72.17.17.33.34.48.52L16 9.01h6V3l-2.45 2.45c-.15-.18-.31-.36-.48-.52M19.37 15.11c-.4.95-.98 1.81-1.72 2.54-.73.74-1.59 1.31-2.54 1.71-1.97.83-4.26.83-6.23 0-.95-.4-1.81-.98-2.54-1.72-.17-.17-.33-.34-.48-.52l2.13-2.13H2v6l2.45-2.45c.15.18.31.36.48.52.92.92 1.99 1.64 3.18 2.14 1.23.52 2.54.79 3.89.79s2.66-.26 3.89-.79c1.19-.5 2.26-1.23 3.18-2.14s1.64-1.99 2.14-3.18c.52-1.23.79-2.54.79-3.89h-2c0 1.08-.21 2.13-.63 3.11Z">
                            </path>
                        </svg>
                        Revisi Evaluasi
                    </x-button>
                </form>
            @endif
        @endif
    </div>

    @if ($isResponden)
        <footer
            class="fixed bottom-0 left-0 w-full bg-white px-6 max-md:px-4 py-4 border-t border-gray-200 flex gap-2 overflow-x-auto">
            @if ($apakahEvaluasiDapatDikerjakan)
                <x-button color="gray"
                    href="{{ route('responden.evaluasi.identitas-responden.edit', $hasilEvaluasi->identitas_responden_id) }}">Identitas</x-button>
            @endif
            @foreach ($daftarAreaEvaluasi as $areaEvaluasi)
                <x-button href="{{ route('responden.evaluasi.pertanyaan', [$areaEvaluasi->id, $hasilEvaluasiId]) }}"
                    color="gray">
                    {{ $areaEvaluasi->nama_area_evaluasi }}
                </x-button>
            @endforeach
            <x-button>Dashboard</x-button>
        </footer>
    @else
        <footer
            class="fixed bottom-0 left-0 w-full bg-white px-6 max-md:px-4 py-4 border-t border-gray-200 flex gap-2 overflow-x-auto duration-300"
            :class="{ 'md:pl-[17rem]': isOpenSidebar, 'md:pl-[5rem]': !isOpenSidebar }">
            @foreach ($daftarAreaEvaluasi as $areaEvaluasi)
                <x-button href="{{ route('verifikator.evaluasi.pertanyaan', [$areaEvaluasi->id, $hasilEvaluasiId]) }}"
                    color="gray">
                    {{ $areaEvaluasi->nama_area_evaluasi }}
                </x-button>
            @endforeach
            <x-button>Dashboard</x-button>
        </footer>
    @endif
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @can('responden')
            @if ($apakahEvaluasiDapatDikerjakan)
                function kirimEvaluasi() {
                    window.event.preventDefault();

                    Swal.fire({
                        title: "Kirim & Selesaikan Evaluasi",
                        text: "Data evaluasi tidak dapat diubah setelah dikirim!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "{{ config('app.primary_color') }}",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, kirim evaluasi",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Ketikkan Konfirmasi untuk Mengirim Evaluasi",
                                input: "text",
                                inputAttributes: {
                                    autocapitalize: "off"
                                },
                                showCancelButton: true,
                                confirmButtonText: "Konfirmasi & Kirim",
                                confirmButtonColor: "{{ config('app.primary_color') }}",
                                cancelButtonColor: "#d33",
                                cancelButtonText: "Batal",
                                allowOutsideClick: () => !Swal.isLoading()
                            }).then((result) => {
                                if (result.isConfirmed && result.value.toLowerCase() == 'konfirmasi') {
                                    const form = document.getElementById('formKirimEvaluasi');
                                    form.submit();
                                } else {
                                    Swal.fire({
                                        title: "Konfirmasi Gagal",
                                        text: "Input tidak sesuai! Proses pengiriman evaluasi dibatalkan.",
                                        icon: "error",
                                        confirmButtonColor: "{{ config('app.primary_color') }}",
                                    });
                                }
                            });

                        }
                    });
                }
            @endif
        @endcan

        @can('verifikator')
            @if ($statusHasilEvaluasiSaatIni === StatusHasilEvaluasi::STATUS_DITINJAU)

                function verifikasiEvaluasi() {
                    window.event.preventDefault();

                    // Tampilkan pesan konfirmasi verifikasi
                    Swal.fire({
                        title: "Verifikasi Evaluasi",
                        html: "Verifikasi evaluasi responden <b>{{ $responden->user->nama }}</b>?",
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: "{{ config('app.primary_color') }}",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, verifikasi!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        // Jika verifikasi dikonfirmasi
                        if (result.isConfirmed) {
                            // Tampilkan pesan apakah nonaktif evaluasi responden
                            Swal.fire({
                                title: "Berikan Akses Evaluasi Responden?",
                                html: "Apakah Anda ingin memberikan akses evaluasi kepada responden <b>{{ $responden->user->nama }}</b>?",
                                icon: "question",
                                showCancelButton: true,
                                confirmButtonColor: "{{ config('app.primary_color') }}",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Ya, berikan!",
                                cancelButtonText: "Jangan berikan"
                            }).then((result) => {
                                // Menetapkan data apakah responden selanjutnya
                                // dapat melakukan akses evaluasi lagi
                                const aksesEvaluasiRespondenInput = document.getElementById(
                                    'formVerifikasiEvaluasi-aksesEvaluasiResponden');
                                // Jika akses evaluasi responden diberikan 
                                if (result.isConfirmed) {
                                    aksesEvaluasiRespondenInput.value = true;
                                }
                                // Jika akses evaluasi responden tidak diberikan 
                                else {
                                    aksesEvaluasiRespondenInput.value = false;
                                }
                                // Tampilkan catatan verifikasi
                                Swal.fire({
                                    title: "Pesan catatan verifikasi untuk responden (opsional)",
                                    input: "text",
                                    inputAttributes: {
                                        autocapitalize: "off"
                                    },
                                    showCancelButton: true,
                                    confirmButtonText: "Konfirmasi & Kirim",
                                    confirmButtonColor: "{{ config('app.primary_color') }}",
                                    cancelButtonColor: "#d33",
                                    cancelButtonText: "Batal",
                                    allowOutsideClick: () => !Swal.isLoading()
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        if (result.value.length > 255) {
                                            Swal.fire({
                                                title: "Catatan Verifikasi Gagal",
                                                text: "Catatan evaluasi berisikan maksimal 255 karakter! Verifikasi dibatalkan.",
                                                icon: "error",
                                                confirmButtonColor: "{{ config('app.primary_color') }}",
                                            });
                                        } else {
                                            const form = document.getElementById(
                                                'formVerifikasiEvaluasi');

                                            const catatanInput = document.getElementById(
                                                'formVerifikasiEvaluasi-catatan');
                                            catatanInput.value = result.value;

                                            form.submit();
                                        }
                                    }
                                });

                            });
                        }
                    });
                }
            @endif
            @if ($statusHasilEvaluasiSaatIni !== StatusHasilEvaluasi::STATUS_DIKERJAKAN)
                function revisiEvaluasi() {
                    window.event.preventDefault();

                    Swal.fire({
                        title: "Revisi Evaluasi",
                        html: "Revisi evaluasi responden <b>{{ $responden->user->nama }}</b>?",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonColor: "{{ config('app.primary_color') }}",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "Ya, revisi!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Pesan catatan revisi untuk responden (opsional)",
                                input: "text",
                                inputAttributes: {
                                    autocapitalize: "off"
                                },
                                showCancelButton: true,
                                confirmButtonText: "Konfirmasi & Kirim",
                                cancelButtonColor: "{{ config('app.primary_color') }}",
                                confirmButtonColor: "#d33",
                                cancelButtonText: "Batal",
                                allowOutsideClick: () => !Swal.isLoading()
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if (result.value.length > 255) {
                                        Swal.fire({
                                            title: "Catatan Revisi Gagal",
                                            text: "Catatan revisi berisikan maksimal 255 karakter! Revisi dibatalkan.",
                                            icon: "error",
                                            confirmButtonColor: "{{ config('app.primary_color') }}",
                                        });
                                    } else {
                                        const form = document.getElementById('formRevisiEvaluasi');

                                        const catatanInput = document.getElementById(
                                            'formRevisiEvaluasi-catatan');
                                        catatanInput.value = result.value;

                                        form.submit();
                                    }
                                }
                            });
                        }
                    });
                }
            @endif
        @endcan
    </script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        Highcharts.chart('diagram', {
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

            series: [{
                    name: 'Kepatuhan ISO/SNI 27001',
                    data: [4, 5, 5, 3, 4, 3],
                    pointPlacement: 'on',
                    color: '#7cb342',
                    fillOpacity: 1,
                    lineWidth: 0,
                    zIndex: 1
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
@endpush
