@extends('layouts.layout')

@section('content')
    <h1 class="font-bold text-2xl">{{ $areaEvaluasi->judul }}</h1>
    <p>{{ $areaEvaluasi->deskripsi }}</p>

    {{-- Alert: Informasi pertanyaan kesalahan --}}
    @if (session('daftarInformasiPertanyaanKesalahan'))
        @foreach (session('daftarInformasiPertanyaanKesalahan') as $daftarPertanyaanKesalahan)
            <x-alert class="mt-2" :isClosed=true>
                <b>{{ $daftarPertanyaanKesalahan['pesan'] }}</b>
                <p>Berikut nomor pertanyaan yang harus diperbaiki: {{ $daftarPertanyaanKesalahan['daftarNomor'] }}</p>
            </x-alert>
        @endforeach
    @endif

    <form onsubmit="formSimpanJawaban(event)"
        action="{{ route('responden.evaluasi.i-kategori-se.simpan', $hasilEvaluasi->id) }}" method="post"
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
                    <x-table.tr>
                        <input type="hidden" name="{{ $pertanyaanDanJawaban['nomor'] }}[pertanyaan_id]"
                            value="{{ $pertanyaanDanJawaban['pertanyaan_id'] }}">
                        {{-- Kolom: Nomor --}}
                        <x-table.td>
                            <span>1.{{ $pertanyaanDanJawaban['nomor'] }}</span>
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
                                    onclick="perbaruiPertanyaanSkor({{ $index }}, {{ $pertanyaanDanJawaban['skor_status_pertama'] }})"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusA" value="skor_status_pertama">
                                    {{ $pertanyaanDanJawaban['status_pertama'] }}
                                </x-radio.option>
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_kedua'"
                                    onclick="perbaruiPertanyaanSkor({{ $index }}, {{ $pertanyaanDanJawaban['skor_status_kedua'] }})"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusB" value="skor_status_kedua">
                                    {{ $pertanyaanDanJawaban['status_kedua'] }}
                                </x-radio.option>
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_ketiga'"
                                    onclick="perbaruiPertanyaanSkor({{ $index }}, {{ $pertanyaanDanJawaban['skor_status_ketiga'] }})"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusC" value="skor_status_ketiga">
                                    {{ $pertanyaanDanJawaban['status_ketiga'] }}
                                </x-radio.option>
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
        <div>
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
                            <x-table.td>Skor</x-table.td>
                            <x-table.td><strong id="totalSkor">0</strong></x-table.td>
                        </x-table.tr>
                        <x-table.tr class="!border-b-0">
                            <x-table.td>Tingkat Ketergantungan</x-table.td>
                            <x-table.td><strong id="tingkatKetergantungan">Rendah</strong></x-table.td>
                        </x-table.tr>
                    </x-table.tbody>
                </x-table>
            </div>
        </div>
        {{-- Daftar Area Evaluasi --}}
        <footer class="bg-white px-6 max-md:px-4 py-4 border-t border-gray-200 flex gap-2 overflow-x-auto">
            <x-button color="gray"
                href="{{ route('responden.identitas-responden.edit', $hasilEvaluasi->identitas_responden_id) }}">Identitas</x-button>
            <x-button>{{ $areaEvaluasi->nama_evaluasi }}</x-button>
            @foreach ($daftarAreaEvaluasiUtama as $areaEvaluasiUtama)
                <x-button
                    href="{{ route('responden.evaluasi.evaluasi-utama', [$hasilEvaluasi->id, $areaEvaluasiUtama->id]) }}"
                    color="gray">
                    {{ $areaEvaluasiUtama->nama_evaluasi }}
                </x-button>
            @endforeach
            <x-button color="gray">VIII Suplemen</x-button>
            <x-button color="gray"
                href="{{ route('responden.evaluasi.dashboard', $hasilEvaluasi->id) }}">Dashboard</x-button>
        </footer>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let daftarSkorArray = {{ json_encode($totalSkorJawabanArray) }};
        let totalSkor = 0;

        // Ketika halaman di-load
        perbaruiScrollPosisi();
        perbaruiTotalSkor();

        function perbaruiScrollPosisi() {
            const scrollPosition = localStorage.getItem('scrollPosition');

            const apakahTidakAdaPesanGagal = {{ session('daftarInformasiPertanyaanKesalahan') ? 'false' : 'true' }};

            if (apakahTidakAdaPesanGagal && scrollPosition) {
                window.scrollTo(0, scrollPosition);
                Swal.fire({
                    title: "Data Telah Disimpan",
                    text: "Data evaluasi Anda telah tercatat di sistem database.",
                    icon: "success",
                    confirmButtonColor: "#d33",
                    confirmButtonColor: "{{ config('app.primary_color') }}",
                });
            }

            localStorage.removeItem('scrollPosition');
        }

        function perbaruiPertanyaanSkor(pertanyaanIndex, skor) {
            // Mengambil elemen skor skor pertanyaan
            let pertanyaanSkorElement = document.getElementById('skorPertanyaan' + pertanyaanIndex);
            // Ubah isi nilai skor elemen tersebut
            const pertanyaanSkor = pertanyaanSkorElement.textContent;

            // Jika pertanyaan skor berubah
            if (pertanyaanSkor != skor) {
                // Perbarui isi skor elemen tersebut
                pertanyaanSkorElement.textContent = skor;

                // Tampilkan tombol simpan
                tampilkanSaveButton();
                // Perbarui skor bagian index array
                daftarSkorArray[pertanyaanIndex] = skor;
                // Perbarui total skor
                perbaruiTotalSkor();
            }
        }

        function perbaruiTotalSkor() {
            totalSkor = daftarSkorArray.reduce((acc, curr) => acc + curr);

            const totalSkorElement = document.getElementById('totalSkor');
            totalSkorElement.textContent = totalSkor;

            perbaruiTingkatKeterangantungan();
        }

        function perbaruiTingkatKeterangantungan() {
            let tingkatKeterangantunganElement = document.getElementById('tingkatKetergantungan');

            if (totalSkor <= 15) {
                tingkatKeterangantunganElement.textContent = 'Rendah';
            } else if (totalSkor <= 34) {
                tingkatKeterangantunganElement.textContent = 'Tinggi';
            } else {
                tingkatKeterangantunganElement.textContent = 'Strategis';
            }
        }

        function tampilkanSaveButton() {
            const saveButtonElement = document.getElementById('saveButton');
            saveButtonElement.classList.remove('opacity-0');
            saveButtonElement.classList.remove('pointer-events-none');
            saveButtonElement.classList.add('scale-100');
        }

        function formSimpanJawaban(event) {
            localStorage.setItem('scrollPosition', window.scrollY);
        }
    </script>
@endpush
