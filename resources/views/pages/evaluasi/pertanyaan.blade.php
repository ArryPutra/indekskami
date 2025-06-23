@extends('layouts.layout', [
    'class' => 'mb-18',
])

@php
    use App\Models\Responden\StatusHasilEvaluasi;
@endphp

@section('content')

    <h1 class="font-bold text-2xl">{{ $areaEvaluasi->judul }}</h1>
    <p>{{ $areaEvaluasi->deskripsi }}</p>
    {{-- Alert: Informasi pertanyaan kesalahan --}}
    @if (session('pesanError'))
        <x-alert class="mt-2" :isClosed=true>
            <b>Pesan kesalahan:</b>
            <p>{{ session('pesanError') }}</p>
        </x-alert>
    @endif
    @if (session('daftarInformasiPertanyaanKesalahan'))
        @foreach (session('daftarInformasiPertanyaanKesalahan') as $daftarPertanyaanKesalahan)
            <x-alert class="mt-2" :isClosed=true>
                <b>{{ $daftarPertanyaanKesalahan['pesan'] }}</b>
                <p>Berikut nomor pertanyaan yang harus diperbaiki: {{ $daftarPertanyaanKesalahan['daftarNomor'] }}
                </p>
            </x-alert>
        @endforeach
    @endif

    <form onsubmit="formSimpanJawaban(event)" id="formSimpanJawaban" action="{{ $routeSimpanJawaban }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <x-table class="mt-4">
            <x-table.thead class="!bg-black !text-white">
                <x-table.th>#</x-table.th>
                <x-table.th>Pertanyaan</x-table.th>
                <x-table.th>Skor</x-table.th>
                <x-table.th class="!text-center">Dokumen</x-table.th>
                <x-table.th>Keterangan</x-table.th>
            </x-table.thead>
            <x-table.tbody>
                {{-- Looping pertanyaan --}}
                @foreach ($daftarPertanyaanDanJawaban as $index => $pertanyaanDanJawaban)
                    {{-- Looping judul tema pertanyaan --}}
                    @foreach ($daftarJudulTemaPertanyaan as $judulTemaPertanyaan)
                        {{-- Menyesuaikan judul tema pertanyaan --}}
                        @if ($judulTemaPertanyaan->letakkan_sebelum_nomor == $pertanyaanDanJawaban['nomor'])
                            <x-table.tr class="!bg-gray-200">
                                <x-table.td class="font-bold uppercase text-xs" colspan="7">
                                    {{ $judulTemaPertanyaan->judul }}
                                </x-table.td>
                            </x-table.tr>
                        @endif
                    @endforeach
                    <x-table.tr
                        id="{{ isset($pertanyaanDanJawaban['pertanyaan_tahap']) && $pertanyaanDanJawaban['pertanyaan_tahap'] == 3 ? 'pertanyaanTahap3' : false }}"
                        class="{{ $pertanyaanDanJawaban['apakah_terkunci'] ?? false ? '!bg-red-50 pointer-events-none' : false }}">
                        <input type="hidden" name="{{ $pertanyaanDanJawaban['nomor'] }}[pertanyaan_id]"
                            value="{{ $pertanyaanDanJawaban['pertanyaan_id'] }}">
                        {{-- Kolom: Nomor --}}
                        <x-table.td>
                            @if ($namaTipeEvaluasi == 'Evaluasi Utama')
                                <div class="flex gap-1">
                                    <span>{{ $areaEvaluasi->id }}.{{ $pertanyaanDanJawaban['nomor'] }}</span>
                                    <span>{{ $pertanyaanDanJawaban['tingkat_kematangan'] }}</span>
                                    <span>{{ $pertanyaanDanJawaban['pertanyaan_tahap'] }}</span>
                                </div>
                            @else
                                <span>{{ $areaEvaluasi->id }}.{{ $pertanyaanDanJawaban['nomor'] }}</span>
                            @endif
                            @if ($pertanyaanDanJawaban['catatan'])
                                <div x-data="{ isOpen: false }" x-on:mouseenter="isOpen = true"
                                    x-on:mouseleave="isOpen = false">
                                    <svg class="mt-1.5 cursor-pointer fill-gray-400 hover:fill-gray-700 hover:scale-110 duration-150"
                                        xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z">
                                        </path>
                                        <path d="M11 11h2v6h-2zm0-4h2v2h-2z"></path>
                                    </svg>
                                    <div x-cloak x-show="isOpen"
                                        class=" bg-white p-3 rounded-lg absolute max-w-5/6 translate-x-5
                                        duration-150 border border-gray-200 w-fit -translate-y-1/2">
                                        <h1 class="font-semibold">Catatan:</h1>
                                        <p>{{ $pertanyaanDanJawaban['catatan'] }}</p>
                                    </div>
                                </div>
                            @endif
                        </x-table.td>
                        {{-- Kolom: Pertanyaan --}}
                        <x-table.td class="min-w-56">
                            <x-radio label="{{ $pertanyaanDanJawaban['pertanyaan'] }}">
                                <x-radio.option :disabled="!$apakahEvaluasiDapatDikerjakan" :checked="$pertanyaanDanJawaban['status_jawaban'] === 'status_pertama'"
                                    onclick="pilihOpsiJawaban(
                                    {{ $index }},
                                    {{ $pertanyaanDanJawaban['skor_status_pertama'] }},
                                    )"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusPertama"
                                    value="status_pertama">
                                    {{ $pertanyaanDanJawaban['status_pertama'] }}
                                </x-radio.option>
                                <x-radio.option :disabled="!$apakahEvaluasiDapatDikerjakan" :checked="$pertanyaanDanJawaban['status_jawaban'] === 'status_kedua'"
                                    onclick="pilihOpsiJawaban(
                                    {{ $index }},
                                    {{ $pertanyaanDanJawaban['skor_status_kedua'] }},
                                    )"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKedua" value="status_kedua">
                                    {{ $pertanyaanDanJawaban['status_kedua'] }}
                                </x-radio.option>
                                <x-radio.option :disabled="!$apakahEvaluasiDapatDikerjakan" :checked="$pertanyaanDanJawaban['status_jawaban'] === 'status_ketiga'"
                                    onclick="pilihOpsiJawaban(
                                    {{ $index }},
                                    {{ $pertanyaanDanJawaban['skor_status_ketiga'] }},
                                    )"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKetiga" value="status_ketiga">
                                    {{ $pertanyaanDanJawaban['status_ketiga'] }}
                                </x-radio.option>
                                {{-- Khusus Evaluasi Utama --}}
                                @if ($namaTipeEvaluasi !== 'Kategori Sistem Elektronik')
                                    <x-radio.option :disabled="!$apakahEvaluasiDapatDikerjakan" :checked="$pertanyaanDanJawaban['status_jawaban'] === 'status_keempat'"
                                        onclick="pilihOpsiJawaban(
                                        {{ $index }},
                                        {{ $pertanyaanDanJawaban['skor_status_keempat'] }},
                                        )"
                                        name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                        id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKeempat"
                                        value="status_keempat">
                                        {{ $pertanyaanDanJawaban['status_keempat'] }}
                                    </x-radio.option>
                                    {{-- Jika ternyata opsi status kelima --}}
                                    @if ($namaTipeEvaluasi === 'Evaluasi Utama' && $pertanyaanDanJawaban['status_kelima'])
                                        <x-radio.option :disabled="!$apakahEvaluasiDapatDikerjakan" :checked="$pertanyaanDanJawaban['status_jawaban'] === 'status_kelima'"
                                            onclick="pilihOpsiJawaban(
                                            {{ $index }},
                                            {{ $pertanyaanDanJawaban['skor_status_kelima'] }},
                                            )"
                                            name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                            id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKelima"
                                            value="status_kelima">
                                            {{ $pertanyaanDanJawaban['status_kelima'] }}
                                        </x-radio.option>
                                    @endif
                                @endif
                            </x-radio>
                        </x-table.td>
                        {{-- Kolom: Skor --}}
                        <x-table.td>
                            <span
                                id="skorPertanyaan{{ $index }}">{{ $pertanyaanDanJawaban['skor_jawaban'] }}</span>
                        </x-table.td>
                        {{-- Kolom: Dokumen --}}
                        <x-table.td>
                            @if ($isResponden)
                                {{-- Jika status evaluasi dapat dikerjakan --}}
                                @if ($statusHasilEvaluasiSaatIni === StatusHasilEvaluasi::STATUS_DIKERJAKAN)
                                    {{-- <x-file-upload :disabled="$statusHasilEvaluasiSaatIni !== StatusHasilEvaluasi::STATUS_DIKERJAKAN"
                                        name="{{ $pertanyaanDanJawaban['nomor'] }}[unggah_dokumen_baru]"
                                        oninput="tampilkanSaveButton()" /> --}}
                                    <div class="flex items-center justify-center w-60 overflow-clip">
                                        <label for="dropzone-file{{ $pertanyaanDanJawaban['nomor'] }}"
                                            class="flex items-center w-full h-fit border-2 border-gray-300 border-dashed rounded-lg cursor-pointer p-3 bg-gray-50 hover:bg-gray-100">
                                            <div x-data="{ fileName: '' }" class="flex gap-3 items-center">
                                                <div class="w-6 h-6">
                                                    <svg class="w-6 h-6 text-gray-500" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                    </svg>
                                                </div>

                                                <p x-text="fileName ? fileName : 'Klik untuk unggah dokumen'"
                                                    class="text-sm text-gray-500 font-medium line-clamp-2">
                                                </p>

                                                <input name="{{ $pertanyaanDanJawaban['nomor'] }}[unggah_dokumen_baru]"
                                                    id="dropzone-file{{ $pertanyaanDanJawaban['nomor'] }}" type="file"
                                                    class="hidden" oninput="tampilkanSaveButton();"
                                                    @disabled($statusHasilEvaluasiSaatIni !== StatusHasilEvaluasi::STATUS_DIKERJAKAN)
                                                    @change="fileName = $event.target.files.length ? $event.target.files[0].name : ''">
                                            </div>
                                        </label>
                                    </div>
                                @endif
                            @endif
                            @if ($pertanyaanDanJawaban['dokumen'])
                                {{-- Dokumen Lama (hanya berupa hidden untuk keperluan menghapus dokumen lama di database) --}}
                                <input type="hidden" name="{{ $pertanyaanDanJawaban['nomor'] }}[path_dokumen_lama]"
                                    value="{{ $pertanyaanDanJawaban['dokumen'] }}">
                                <x-button href="/file/{{ $pertanyaanDanJawaban['dokumen'] }}" target="_blank"
                                    class="w-fit mt-2">Lihat
                                    Dokumen
                                </x-button>
                            @endif
                        </x-table.td>
                        {{-- Kolom: Keterangan --}}
                        <x-table.td>
                            @if ($isResponden)
                                <x-text-area :readonly="!$apakahEvaluasiDapatDikerjakan" name="{{ $pertanyaanDanJawaban['nomor'] }}[keterangan]"
                                    placeholder="Keterangan" :required=false oninput="tampilkanSaveButton()"
                                    :value="$pertanyaanDanJawaban['keterangan']" />
                            @else
                                <x-text-area :readonly="true" name="{{ $pertanyaanDanJawaban['nomor'] }}[keterangan]"
                                    placeholder="Keterangan" :required=false
                                    value="{{ $pertanyaanDanJawaban['keterangan'] }}" />
                            @endif
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table>
        <x-button type="submit" id="saveButton"
            class="w-fit !rounded-full py-3 px-3.5 fixed bottom-[5.5rem] right-10 max-md:right-4 shadow-2xl border-black/20 border-4
        opacity-0 pointer-events-none scale-50 z-10">
            <svg class="fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path
                    d="M5 21h14a2 2 0 0 0 2-2V8l-5-5H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2zM7 5h4v2h2V5h2v4H7V5zm0 8h10v6H7v-6z">
                </path>
            </svg>
            Simpan
        </x-button>
    </form>

    <div class="fixed bottom-0 left-0 w-full duration-300"
        @if (!$isResponden) :class="{ 'md:pl-[16rem]': isOpenSidebar, 'md:pl-[4rem]': !isOpenSidebar }" @endif
        x-data="{ isOpenHasilNilaiEvaluasiPanel: (localStorage.getItem('isOpenHasilNilaiEvaluasiPanel') ?? 'true') === 'true' ? true : false }">
        {{-- Tombol Hasil Nilai Evaluasi Panel --}}
        <x-button
            @click="
            isOpenHasilNilaiEvaluasiPanel = !isOpenHasilNilaiEvaluasiPanel,
            localStorage.setItem('isOpenHasilNilaiEvaluasiPanel', isOpenHasilNilaiEvaluasiPanel)"
            color="gray" class="bg-white rounded-b-none border border-gray-200 ml-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6 duration-300"
                x-bind:class="{ 'rotate-180': isOpenHasilNilaiEvaluasiPanel, 'rotate-0': !isOpenHasilNilaiEvaluasiPanel }">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
            </svg>
        </x-button>
        {{-- Hasil Nilai Evaluasi Panel --}}
        <div x-cloak class="bg-white border-t border-gray-200 px-6 max-md:px-4 pt-4"
            :class="{ 'block shadow-2xl': isOpenHasilNilaiEvaluasiPanel, 'hidden': !isOpenHasilNilaiEvaluasiPanel }">
            <h1 class="font-bold mb-1.5">Hasil Nilai Evaluasi</h1>
            <x-table class="-mx-6">
                <x-table.tbody>
                    <x-table.tr>
                        <x-table.td>Pertanyaan Dijawab</x-table.td>
                        <x-table.td><strong id="pertanyaanDijawab"></strong></x-table.td>
                    </x-table.tr>
                    <x-table.tr>
                        <x-table.td>Total Skor</x-table.td>
                        <x-table.td><strong id="totalSkor"></strong></x-table.td>
                    </x-table.tr>
                    {{-- TIPE EVALUASI: Kategori Sistem Elektronik --}}
                    @if ($namaTipeEvaluasi == 'Kategori Sistem Elektronik')
                        <x-table.tr class="!border-b-0">
                            <x-table.td>Tingkat Ketergantungan</x-table.td>
                            <x-table.td><strong id="tingkatKetergantungan"></strong></x-table.td>
                        </x-table.tr>
                    @elseif ($namaTipeEvaluasi == 'Evaluasi Utama')
                        <x-table.tr>
                            <x-table.td>Batas Skor Min untuk Skor Tahap Penerapan 3</x-table.td>
                            <x-table.td><strong id="batasSkorMinUntukSkorTahapPenerapan3"></strong></x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.td>Total Skor Tahap Penerapan 1 & 2</x-table.td>
                            <x-table.td><strong id="totalSkorTahapPenerapan1Dan2"></strong></x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.td>Status Validitas Seluruh Tahap</x-table.td>
                            <x-table.td><strong id="statusValiditasTahap"></strong></x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.td>Status Peniliaian Tahap Penerapan 3</x-table.td>
                            <x-table.td><strong id="statusPeniliaianTahapPenerapan3"></strong></x-table.td>
                        </x-table.tr>
                    @elseif ($namaTipeEvaluasi == 'Suplemen')
                        <x-table.tr>
                            <x-table.td>Total Skor Suplemen</x-table.td>
                            <x-table.td><strong id="totalSkorSuplemen"></strong><strong>%</strong></x-table.td>
                        </x-table.tr>
                    @endif
                </x-table.tbody>
            </x-table>
        </div>
        {{-- Daftar Area Evaluasi --}}
        @if ($isResponden)
            <footer class="bg-white px-6 max-md:px-4 py-4 border-t border-gray-200 flex gap-2 overflow-x-auto">
                @if ($statusHasilEvaluasiSaatIni === StatusHasilEvaluasi::STATUS_DIKERJAKAN)
                    <x-button color="gray"
                        href="{{ route('responden.evaluasi.identitas-responden.edit', $hasilEvaluasi->identitas_responden_id) }}">Identitas</x-button>
                @endif
                @foreach ($daftarAreaEvaluasiUtama as $areaEvaluasiUtama)
                    <x-button
                        href="{{ route('responden.evaluasi.pertanyaan', [$areaEvaluasiUtama->id, $hasilEvaluasi->id]) }}"
                        color="{{ $areaEvaluasiUtama->id === $areaEvaluasi->id ? 'primary' : 'gray' }}">
                        {{ $areaEvaluasiUtama->nama_area_evaluasi }}
                    </x-button>
                @endforeach
                <x-button color="gray"
                    href="{{ route('responden.evaluasi.dashboard', $hasilEvaluasi->id) }}">Dashboard</x-button>
            </footer>
        @else
            <footer class="bg-white px-6 max-md:px-4 py-4 border-t border-gray-200 flex gap-2 overflow-x-auto">
                @foreach ($daftarAreaEvaluasiUtama as $areaEvaluasiUtama)
                    <x-button
                        href="{{ route('verifikator.evaluasi.pertanyaan', [$areaEvaluasiUtama->id, $hasilEvaluasi->id]) }}"
                        color="{{ $areaEvaluasiUtama->id === $areaEvaluasi->id ? 'primary' : 'gray' }}">
                        {{ $areaEvaluasiUtama->nama_area_evaluasi }}
                    </x-button>
                @endforeach
                <x-button color="gray"
                    href="{{ route('verifikator.evaluasi.dashboard', $hasilEvaluasi->id) }}">Dashboard</x-button>
            </footer>
        @endif
    </div>

@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let daftarPertanyaanDanJawaban = {!! json_encode($dataScript['daftarPertanyaanDanJawaban']) !!};
        let totalSkor = daftarPertanyaanDanJawaban.reduce((total, item) => total + item['skor_jawaban'], 0);

        perbaruiScrollPosisi();

        hitungTotalPertanyaanDijawab();
        hitungTotalSkor();

        @if ($namaTipeEvaluasi == 'Kategori Sistem Elektronik')
            hitungTingkatKeterangantungan();
        @elseif ($namaTipeEvaluasi == 'Evaluasi Utama')
            let batasSkorMinUntukSkorTahap3 = 0;
            hitungBatasSkorMinUntukSkorTahap3();

            let totalSkorTahapPenerapan1Dan2 = daftarPertanyaanDanJawaban
                .filter(item => item['pertanyaan_tahap'] === 1 || item['pertanyaan_tahap'] === 2)
                .reduce((total, item) => total + item['skor_jawaban'], 0);

            // Proses validitas seluruh tahap
            let totalSkorJawabanTahapPenerapan1 = 0;
            hitungTotalSkorJawabanTahapPenerapan1()

            const totalJawabanTahap1 = {
                statusPertama: 0, // Tidak Diterapkan
                statusKedua: 0, // Dalam Perencanaan
                statusKetiga: 0, // Diterapkan Sebagian,
                statusKeempat: 0 // Diterapkan Secara Menyeluruh
            };
            hitungTotalJawabanTahap1();

            let totalSkorJawabanTahapPenerapan1StatusKeempat =
                daftarPertanyaanDanJawaban
                .filter(item => item['pertanyaan_tahap'] === 1)
                .length * 3;

            let statusValiditasSeluruhTahap = false;
            perbaruiStatusValiditasSeluruhTahap();
            // End Proses validitas seluruh tahap

            hitungTotalSkorTahap1Dan2();

            let statusPenilaianTahapPenerapan3 = false;
            perbaruiStatusPenilaianTahapPenerapan3();
        @elseif ($namaTipeEvaluasi == 'Suplemen')
            let totalSkorSuplemen = ((totalSkor / 27 * 3) / 9 * 100).toFixed(2);
            hitungTotalSkorSuplemen();
        @endif

        function pilihOpsiJawaban(pertanyaanIndex, skorBaru) {
            const pertanyaanObject = daftarPertanyaanDanJawaban[pertanyaanIndex];

            perbaruiPertanyaanDijawab(pertanyaanObject);
            perbaruiPertanyaanSkor(pertanyaanObject, pertanyaanIndex, skorBaru);
            @if ($namaTipeEvaluasi == 'Kategori Sistem Elektronik')
                hitungTingkatKeterangantungan();
            @elseif ($namaTipeEvaluasi == 'Evaluasi Utama')
                hitungTotalSkorTahap1Dan2();
                // biru
                hitungTotalSkorJawabanTahapPenerapan1();
                hitungTotalJawabanTahap1();
                perbaruiStatusValiditasSeluruhTahap();
                // end biru
                perbaruiStatusPenilaianTahapPenerapan3();
                console.log('<< ============= >>')
            @elseif ($namaTipeEvaluasi == 'Suplemen')
                hitungTotalSkorSuplemen();
            @endif

            tampilkanSaveButton();
        }

        function perbaruiPertanyaanDijawab(pertanyaanObject) {
            // Perbarui status apakah_pertanyaan_baru
            pertanyaanObject['apakah_pertanyaan_baru'] = false;
            hitungTotalPertanyaanDijawab();
        }

        function hitungTotalPertanyaanDijawab() {
            const pertanyaanDijawabElement = document.getElementById('pertanyaanDijawab');

            const totalPertanyaan = daftarPertanyaanDanJawaban.length;

            totalPertanyaanDijawab = daftarPertanyaanDanJawaban
                .filter(item => item['apakah_pertanyaan_baru'] === false).length;
            pertanyaanDijawabElement.textContent = totalPertanyaanDijawab + "/" + totalPertanyaan;

            pertanyaanDijawabElement.classList.remove('text-red-600');
            pertanyaanDijawabElement.classList.remove('text-primary');
            if (totalPertanyaanDijawab === 0) {
                pertanyaanDijawabElement.classList.add('text-red-600');
            } else if (totalPertanyaanDijawab === totalPertanyaan) {
                pertanyaanDijawabElement.classList.add('text-primary');
            }
        }

        function perbaruiPertanyaanSkor(pertanyaanObject, pertanyaanIndex, skorBaru) {
            // Mengambil skor lama object
            const pertanyaanSkorLama = pertanyaanObject['skor_jawaban'];
            // Mengambil elemen skor pertanyaan
            let pertanyaanSkorElement = document.getElementById('skorPertanyaan' + pertanyaanIndex);
            // Perbarui isi skor elemen tersebut dengan skor baru
            pertanyaanSkorElement.textContent = skorBaru;
            // Perbarui skor pertanyaan object
            pertanyaanObject['skor_jawaban'] = skorBaru;
            hitungTotalSkor();
        }

        function hitungTotalSkor() {
            totalSkor = daftarPertanyaanDanJawaban.reduce((total, item) => total + item['skor_jawaban'], 0);

            const totalSkorElement = document.getElementById('totalSkor');
            totalSkorElement.textContent = totalSkor;
        }

        @if ($namaTipeEvaluasi == 'Kategori Sistem Elektronik')
            function hitungTingkatKeterangantungan() {
                let tingkatKeterangantunganElement = document.getElementById('tingkatKetergantungan');

                if (totalSkor <= 15) {
                    tingkatKeterangantunganElement.textContent = 'Rendah';
                } else if (totalSkor <= 34) {
                    tingkatKeterangantunganElement.textContent = 'Tinggi';
                } else {
                    tingkatKeterangantunganElement.textContent = 'Strategis';
                }
            }
        @elseif ($namaTipeEvaluasi == 'Evaluasi Utama')

            function hitungBatasSkorMinUntukSkorTahap3() {
                const totalPertanyaanTahap1 = daftarPertanyaanDanJawaban.filter(item => item['pertanyaan_tahap'] === 1)
                    .length;
                const totalPertanyaanTahap2 = daftarPertanyaanDanJawaban.filter(item => item['pertanyaan_tahap'] === 2)
                    .length;

                batasSkorMinUntukSkorTahap3 = (2 * totalPertanyaanTahap1) + (4 * totalPertanyaanTahap2);

                const batasSkorMinUntukSkorTahapPenerapan3Element = document.getElementById(
                    'batasSkorMinUntukSkorTahapPenerapan3');
                batasSkorMinUntukSkorTahapPenerapan3Element.textContent = batasSkorMinUntukSkorTahap3;
            }

            // BIRU
            function hitungTotalSkorJawabanTahapPenerapan1() {

                totalSkorJawabanTahapPenerapan1 = daftarPertanyaanDanJawaban
                    .filter(item => item['pertanyaan_tahap'] === 1)
                    .reduce((total, item) => total + item['skor_jawaban'], 0);
                console.log(
                    'Total Skor Tahap Penerapan 1: ' +
                    totalSkorJawabanTahapPenerapan1
                );
            }

            function hitungTotalJawabanTahap1() {
                // Reset nilai
                totalJawabanTahap1.statusPertama = 0;
                totalJawabanTahap1.statusKedua = 0;
                totalJawabanTahap1.statusKetiga = 0;
                totalJawabanTahap1.statusKeempat = 0;

                // Loop sekali saja dan hitung berdasarkan skor
                daftarPertanyaanDanJawaban.forEach(item => {
                    if (item.pertanyaan_tahap === 1) {
                        switch (item.skor_jawaban) {
                            case 0:
                                totalJawabanTahap1.statusPertama++;
                                break;
                            case 1:
                                totalJawabanTahap1.statusKedua++;
                                break;
                            case 2:
                                totalJawabanTahap1.statusKetiga++;
                                break;
                            case 3:
                                totalJawabanTahap1.statusKeempat++;
                                break;
                        }
                    }
                });

                // Logging hasil
                console.log(
                    totalJawabanTahap1
                );
            }

            function perbaruiStatusValiditasSeluruhTahap() {
                const statusValiditasTahapElement = document.getElementById('statusValiditasTahap');

                if (totalJawabanTahap1.statusKedua == 0 &&
                    totalSkorJawabanTahapPenerapan1 >= (totalSkorJawabanTahapPenerapan1StatusKeempat - 2) &&
                    totalJawabanTahap1.statusKetiga <= 2
                ) {
                    statusValiditasSeluruhTahap = true;

                    statusValiditasTahapElement.textContent = 'Valid';
                    statusValiditasTahapElement.classList.add('text-primary');
                    statusValiditasTahapElement.classList.remove('text-red-600');
                } else {
                    statusValiditasSeluruhTahap = false;

                    statusValiditasTahapElement.textContent = 'Tidak Valid';
                    statusValiditasTahapElement.classList.add('text-red-600');
                    statusValiditasTahapElement.classList.remove('text-primary');
                }
            }
            // END BIRU

            function hitungTotalSkorTahap1Dan2() {
                totalSkorTahapPenerapan1Dan2 = daftarPertanyaanDanJawaban
                    .filter(item => item['pertanyaan_tahap'] === 1 || item['pertanyaan_tahap'] === 2)
                    .reduce((total, item) => total + item['skor_jawaban'], 0);

                const totalSkorTahapPenerapan1Dan2Element = document.getElementById('totalSkorTahapPenerapan1Dan2');
                totalSkorTahapPenerapan1Dan2Element.textContent = totalSkorTahapPenerapan1Dan2;
            }

            function perbaruiStatusPenilaianTahapPenerapan3() {
                const statusPenilaianTahapPenerapan3Element = document.getElementById('statusPeniliaianTahapPenerapan3');

                if ((totalSkorTahapPenerapan1Dan2 >= batasSkorMinUntukSkorTahap3) && statusValiditasSeluruhTahap) {
                    statusPenilaianTahapPenerapan3 = true;

                    statusPenilaianTahapPenerapan3Element.textContent = statusPenilaianTahapPenerapan3 ? 'Valid' :
                        'Tidak Valid';
                    statusPenilaianTahapPenerapan3Element.classList.add('text-primary');
                    statusPenilaianTahapPenerapan3Element.classList.remove('text-red-600');

                    apakahBukaKunciPertanyaanTahap3(true);
                } else {
                    statusPenilaianTahapPenerapan3 = false;

                    statusPenilaianTahapPenerapan3Element.textContent = statusPenilaianTahapPenerapan3 ? 'Tidak Valid' :
                        'Valid';
                    statusPenilaianTahapPenerapan3Element.classList.add('text-red-600');
                    statusPenilaianTahapPenerapan3Element.classList.remove('text-primary');

                    apakahBukaKunciPertanyaanTahap3(false);
                }
            }

            function apakahBukaKunciPertanyaanTahap3(apakahBukaKunci) {
                // Ambil semua elemen pertanyaan tahap 3
                const pertanyaanTahap3 = document.querySelectorAll('#pertanyaanTahap3');

                // Jika buka kunci
                if (apakahBukaKunci) {
                    // Hapus setiap kelas pointer-events-none dan bg-red-50 dari semua elemen pertanyaan
                    pertanyaanTahap3.forEach(item => {
                        item.classList.remove('pointer-events-none');
                        item.classList.remove('!bg-red-50');
                    });
                }
                // Jika tidak buka kunci
                else {
                    // Tambahkan setiap kelas pointer-events-none dan bg-red-50 ke semua elemen pertanyaan
                    pertanyaanTahap3.forEach(item => {
                        item.classList.add('pointer-events-none');
                        item.classList.add('!bg-red-50');
                    });
                }
            }
        @elseif ($namaTipeEvaluasi == 'Suplemen')

            function hitungTotalSkorSuplemen() {
                const totalSkorSuplemenElement = document.getElementById('totalSkorSuplemen');
                totalSkorSuplemen = ((totalSkor / 27 * 3) / 9 * 100).toFixed();
                totalSkorSuplemenElement.textContent = totalSkorSuplemen;
            }
        @endif

        function perbaruiScrollPosisi() {
            // Mengambil posisi scroll di local storage
            const scrollPosition = localStorage.getItem('scrollPosition');

            // Mengecek apakah tidak ada pesan gagal yang masuk melalui session (kode di PertanyaanController.php)
            const apakahTidakAdaPesanGagal =
                {{ session('daftarInformasiPertanyaanKesalahan') || session('pesanError') ? 'false' : 'true' }};

            // Jika tidak ada pesan gagal dan mendapatkan data posisi scroll di local storage
            if (apakahTidakAdaPesanGagal && scrollPosition) {
                // Memperbarui posisi scroll sesuai dengan data posisi scroll di local storage
                window.scrollTo(0, scrollPosition);
                // Menampilkan alert pesan sukses
                Swal.fire({
                    title: "Data Telah Disimpan",
                    text: "Data evaluasi Anda telah tercatat di sistem database.",
                    icon: "success",
                    confirmButtonColor: "#d33",
                    confirmButtonColor: "{{ config('app.primary_color') }}",
                });
            }
            // Menghapus data posisi scroll di local storage
            localStorage.removeItem('scrollPosition');
        }

        @if ($apakahEvaluasiDapatDikerjakan)
            function tampilkanSaveButton() {
                // Mengambil elemen tombol simpan
                const saveButtonElement = document.getElementById('saveButton');
                // Modifikasi menampilkan elemen tombol simpan
                saveButtonElement.classList.remove('opacity-0');
                saveButtonElement.classList.remove('pointer-events-none');
                saveButtonElement.classList.add('scale-100');
            }

            // Fungsi ketika menyimpan jawaban
            function formSimpanJawaban(event) {
                // Mengecek apakah ada jawaban tahap 3
                $apakahAdaSkorLebihDari0Tahap3 =
                    daftarPertanyaanDanJawaban.filter(item => item['pertanyaan_tahap'] === 3)
                    .reduce((total, item) => total + item['skor_jawaban'], 0) > 0;

                // Jika status penilaian tahap 3 adalah valid
                if (!statusPenilaianTahapPenerapan3 && $apakahAdaSkorLebihDari0Tahap3) {
                    window.event.preventDefault();
                    // Menampilkan pesan pertanyaan tahap 3 akan dihapus semua
                    Swal.fire({
                        title: "Apakah Anda yakin?",
                        text: "Jawaban pada pertanyaan tahap penerapan 3 akan dihapus semua",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "{{ config('app.primary_color') }}",
                        confirmButtonText: "Simpan",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            localStorage.setItem('scrollPosition', window.scrollY);
                            const form = document.getElementById('formSimpanJawaban');
                            form.submit();
                        }
                    });
                } else {
                    // Simpan data posisi scroll di local storage
                    localStorage.setItem('scrollPosition', window.scrollY);
                }
            }
        @endif
    </script>
@endpush
