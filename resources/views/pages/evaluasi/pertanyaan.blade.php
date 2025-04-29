@extends('layouts.layout')

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
                <p>Berikut nomor pertanyaan yang harus diperbaiki: {{ $daftarPertanyaanKesalahan['daftarNomor'] }}</p>
            </x-alert>
        @endforeach
    @endif

    <form onsubmit="formSimpanJawaban(event)"
        action="{{ route('responden.evaluasi.pertanyaan.simpan', [$areaEvaluasi->id, $hasilEvaluasi->id]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <x-table class="mt-4">
            <x-table.thead class="!bg-black !text-white">
                <x-table.th>#</x-table.th>
                <x-table.th>Pertanyaan</x-table.th>
                <x-table.th>Skor</x-table.th>
                <x-table.th>Dokumen</x-table.th>
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
                        class="{{ $pertanyaanDanJawaban['apakah_terkunci'] ?? false ? '!bg-red-50 pointer-events-none' : false }}
                        {{ $pertanyaanDanJawaban['apakah_terkunci'] ?? false ? 'pertanyaanTahap3' : false }}">
                        <input type="hidden" name="{{ $pertanyaanDanJawaban['nomor'] }}[pertanyaan_id]"
                            value="{{ $pertanyaanDanJawaban['pertanyaan_id'] }}">
                        {{-- Kolom: Nomor --}}
                        <x-table.td>
                            @if ($tipeEvaluasi == 'Evaluasi Utama')
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
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_pertama'"
                                    onclick="pilihOpsiJawaban(
                                    {{ $index }},
                                    {{ $pertanyaanDanJawaban['skor_status_pertama'] }},
                                    )"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusPertama"
                                    value="skor_status_pertama">
                                    {{ $pertanyaanDanJawaban['status_pertama'] }}
                                </x-radio.option>
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_kedua'"
                                    onclick="pilihOpsiJawaban(
                                    {{ $index }},
                                    {{ $pertanyaanDanJawaban['skor_status_kedua'] }},
                                    )"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKedua"
                                    value="skor_status_kedua">
                                    {{ $pertanyaanDanJawaban['status_kedua'] }}
                                </x-radio.option>
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_ketiga'"
                                    onclick="pilihOpsiJawaban(
                                    {{ $index }},
                                    {{ $pertanyaanDanJawaban['skor_status_ketiga'] }},
                                    )"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKetiga"
                                    value="skor_status_ketiga">
                                    {{ $pertanyaanDanJawaban['status_ketiga'] }}
                                </x-radio.option>
                                {{-- Khusus Evaluasi Utama --}}
                                @if ($tipeEvaluasi !== 'Kategori Sistem Elektronik')
                                    <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_keempat'"
                                        onclick="pilihOpsiJawaban(
                                        {{ $index }},
                                        {{ $pertanyaanDanJawaban['skor_status_keempat'] }},
                                        )"
                                        name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                        id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKeempat"
                                        value="skor_status_keempat">
                                        {{ $pertanyaanDanJawaban['status_keempat'] }}
                                    </x-radio.option>
                                    {{-- Jika ternyata opsi status kelima --}}
                                    @if ($tipeEvaluasi === 'Evaluasi Utama' && $pertanyaanDanJawaban['status_kelima'])
                                        <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_kelima'"
                                            onclick="pilihOpsiJawaban(
                                            {{ $index }},
                                            {{ $pertanyaanDanJawaban['skor_status_kelima'] }},
                                            )"
                                            name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                            id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKelima"
                                            value="skor_status_kelima">
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
                            <x-file-upload name="{{ $pertanyaanDanJawaban['nomor'] }}[unggah_dokumen_baru]"
                                oninput="tampilkanSaveButton()" />
                            @if ($pertanyaanDanJawaban['dokumen'])
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
                            <x-text-area name="{{ $pertanyaanDanJawaban['nomor'] }}[keterangan]" placeholder="Keterangan"
                                :required=false oninput="tampilkanSaveButton()"
                                value="{{ $pertanyaanDanJawaban['keterangan'] }}" />
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

    <div class="fixed bottom-0 left-0 w-full" x-data="{ isOpen: (localStorage.getItem('isOpenHasilNilaiEvaluasiPanel') ?? 'true') === 'true' ? true : false }">
        {{-- Tombol Hasil Nilai Evaluasi Panel --}}
        <x-button
            @click="
            isOpen = !isOpen,
            localStorage.setItem('isOpenHasilNilaiEvaluasiPanel', isOpen)"
            color="gray" class="bg-white rounded-b-none border border-gray-200 ml-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6 duration-300"
                x-bind:class="{ 'rotate-180': isOpen, 'rotate-0': !isOpen }">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
            </svg>
        </x-button>
        {{-- Hasil Nilai Evaluasi Panel --}}
        <div x-cloak class="bg-white border-t border-gray-200 px-6 max-md:px-4 pt-4 overflow-hidden"
            :class="{ 'block shadow-2xl': isOpen, 'hidden': !isOpen }">
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
                    @if ($tipeEvaluasi == 'Kategori Sistem Elektronik')
                        <x-table.tr class="!border-b-0">
                            <x-table.td>Tingkat Ketergantungan</x-table.td>
                            <x-table.td><strong id="tingkatKetergantungan"></strong></x-table.td>
                        </x-table.tr>
                    @elseif ($tipeEvaluasi == 'Evaluasi Utama')
                        <x-table.tr>
                            <x-table.td>Batas Skor Min untuk Skor Tahap Penerapan 3</x-table.td>
                            <x-table.td><strong id="batasSkorMinUntukSkorTahapPenerapan3"></strong></x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.td>Total Skor Tahap Penerapan 1 & 2</x-table.td>
                            <x-table.td><strong id="totalSkorTahapPenerapan1Dan2"></strong></x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.td>Status Peniliaian Tahap Penerapan 3</x-table.td>
                            <x-table.td><strong id="statusPeniliaianTahapPenerapan3"></strong></x-table.td>
                        </x-table.tr>
                    @elseif ($tipeEvaluasi == 'Suplemen')
                        <x-table.tr>
                            <x-table.td>Total Skor Suplemen</x-table.td>
                            <x-table.td><strong id="totalSkorSuplemen"></strong><strong>%</strong></x-table.td>
                        </x-table.tr>
                    @endif
                </x-table.tbody>
            </x-table>
        </div>
        {{-- Daftar Area Evaluasi --}}
        <footer class="bg-white px-6 max-md:px-4 py-4 border-t border-gray-200 flex gap-2 overflow-x-auto">
            <x-button color="gray"
                href="{{ route('responden.evaluasi.identitas-responden.edit', $hasilEvaluasi->identitas_responden_id) }}">Identitas</x-button>
            @foreach ($daftarAreaEvaluasiUtama as $areaEvaluasiUtama)
                <x-button
                    href="{{ route('responden.evaluasi.pertanyaan', [$areaEvaluasiUtama->id, $hasilEvaluasi->id]) }}"
                    color="{{ $areaEvaluasiUtama->id === $areaEvaluasi->id ? 'primary' : 'gray' }}">
                    {{ $areaEvaluasiUtama->nama_evaluasi }}
                </x-button>
            @endforeach
            <x-button color="gray"
                href="{{ route('responden.evaluasi.dashboard', $hasilEvaluasi->id) }}">Dashboard</x-button>
        </footer>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let daftarPertanyaanDanJawaban = {!! json_encode($dataScript['daftarPertanyaanDanJawaban']) !!};
        let totalSkor = daftarPertanyaanDanJawaban.reduce((total, item) => total + item['skor_jawaban'], 0);
        @if ($tipeEvaluasi == 'Evaluasi Utama')
            let batasSkorMinUntukSkorTahap3 = 0;
            let totalSkorTahapPenerapan1Dan2 = daftarPertanyaanDanJawaban
                .filter(item => item['pertanyaan_tahap'] === 1 || item['pertanyaan_tahap'] === 2)
                .reduce((total, item) => total + item['skor_jawaban'], 0);
        @elseif ($tipeEvaluasi == 'Suplemen')
            let totalSkorSuplemen = ((totalSkor / 27 * 3) / 9 * 100).toFixed(2);
        @endif

        perbaruiScrollPosisi();

        hitungTotalPertanyaanDijawab();
        hitungTotalSkor();
        @if ($tipeEvaluasi == 'Kategori Sistem Elektronik')
            hitungTingkatKeterangantungan();
        @elseif ($tipeEvaluasi == 'Evaluasi Utama')
            hitungBatasSkorMinUntukSkorTahap3();
            hitungTotalSkorTahap1Dan2();
            hitungStatusPenilaianTahapPenerapan3();
        @elseif ($tipeEvaluasi == 'Suplemen')
            hitungTotalSkorSuplemen();
        @endif

        function pilihOpsiJawaban(pertanyaanIndex, skorBaru) {
            const pertanyaanObject = daftarPertanyaanDanJawaban[pertanyaanIndex];

            perbaruiPertanyaanDijawab(pertanyaanObject);
            perbaruiPertanyaanSkor(pertanyaanObject, pertanyaanIndex, skorBaru);
            @if ($tipeEvaluasi == 'Kategori Sistem Elektronik')
                hitungTingkatKeterangantungan();
            @elseif ($tipeEvaluasi == 'Evaluasi Utama')
                hitungTotalSkorTahap1Dan2();
                hitungStatusPenilaianTahapPenerapan3();
            @elseif ($tipeEvaluasi == 'Suplemen')
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

        @if ($tipeEvaluasi == 'Kategori Sistem Elektronik')
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
        @elseif ($tipeEvaluasi == 'Evaluasi Utama')

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

            function hitungTotalSkorTahap1Dan2() {
                totalSkorTahapPenerapan1Dan2 = daftarPertanyaanDanJawaban
                    .filter(item => item['pertanyaan_tahap'] === 1 || item['pertanyaan_tahap'] === 2)
                    .reduce((total, item) => total + item['skor_jawaban'], 0);

                const totalSkorTahapPenerapan1Dan2Element = document.getElementById('totalSkorTahapPenerapan1Dan2');
                totalSkorTahapPenerapan1Dan2Element.textContent = totalSkorTahapPenerapan1Dan2;
            }

            function hitungStatusPenilaianTahapPenerapan3() {
                const statusPeniliaianTahapPenerapan3Element = document.getElementById('statusPeniliaianTahapPenerapan3');

                if (totalSkorTahapPenerapan1Dan2 >= batasSkorMinUntukSkorTahap3) {
                    statusPenilaianTahapPenerapan3 = 'Valid';

                    statusPeniliaianTahapPenerapan3Element.textContent = statusPenilaianTahapPenerapan3;
                    statusPeniliaianTahapPenerapan3Element.classList.add('text-primary');
                    statusPeniliaianTahapPenerapan3Element.classList.remove('text-red-600');

                    apakahBukaKunciPertanyaanTahap3(true);
                } else {
                    statusPenilaianTahapPenerapan3 = 'Tidak Valid';

                    statusPeniliaianTahapPenerapan3Element.textContent = statusPenilaianTahapPenerapan3;
                    statusPeniliaianTahapPenerapan3Element.classList.add('text-red-600');
                    statusPeniliaianTahapPenerapan3Element.classList.remove('text-primary');

                    apakahBukaKunciPertanyaanTahap3(false);
                }
            }

            function apakahBukaKunciPertanyaanTahap3(apakahBukaKunci) {
                // Ambil semua elemen pertanyaan tahap 3
                const pertanyaanTahap3 = document.querySelectorAll('.pertanyaanTahap3');

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
        @elseif ($tipeEvaluasi == 'Suplemen')

            function hitungTotalSkorSuplemen() {
                const totalSkorSuplemenElement = document.getElementById('totalSkorSuplemen');
                totalSkorSuplemen = ((totalSkor / 27 * 3) / 9 * 100).toFixed(2);
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
            // Simpan data posisi scroll di local storage
            localStorage.setItem('scrollPosition', window.scrollY);
        }
    </script>
@endpush
