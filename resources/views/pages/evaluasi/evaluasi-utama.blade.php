@extends('layouts.layout')

@section('content')
    <h1 class="font-bold text-2xl">{{ $areaEvaluasi->judul }}</h1>
    <p>{{ $areaEvaluasi->deskripsi }}</p>

    <form method="post" enctype="multipart/form-data"
        action="{{ route('responden.evaluasi.evaluasi-utama.simpan', [$hasilEvaluasi->id, $areaEvaluasi->id]) }}">
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
                @foreach ($daftarPertanyaanDanJawaban as $pertanyaanDanJawaban)
                    @foreach ($daftarJudulTemaPertanyaan as $judulTemaPertanyaan)
                        @if ($judulTemaPertanyaan->letakkan_sebelum_nomor == $pertanyaanDanJawaban['nomor'])
                            <x-table.tr class="!bg-gray-200">
                                <x-table.td class="font-bold uppercase text-xs" colspan="7">
                                    {{ $judulTemaPertanyaan->judul }}
                                </x-table.td>
                            </x-table.tr>
                        @endif
                    @endforeach
                    <x-table.tr
                        class="{{ $pertanyaanDanJawaban['apakah_terkunci'] ? '!bg-red-50 pointer-events-none' : false }}">
                        <input type="hidden" name="{{ $loop->iteration }}[pertanyaan_id]"
                            value="{{ $pertanyaanDanJawaban['pertanyaan_id'] }}">
                        <x-table.td class="md:flex max-md:grid max-md:grid-rows-3 gap-2 mt-0.5">
                            <span>2.{{ $pertanyaanDanJawaban['nomor'] }}</span>
                            <span>{{ $pertanyaanDanJawaban['tingkat_kematangan'] }}</span>
                            <span>{{ $pertanyaanDanJawaban['pertanyaan_tahap'] }}</span>
                        </x-table.td>
                        <x-table.td>
                            <x-radio label="{{ $pertanyaanDanJawaban['pertanyaan'] }}">
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_pertama'"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusPertama"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    onclick="perbaruiPertanyaanSkor({{ $pertanyaanDanJawaban['nomor'] }}, {{ $pertanyaanDanJawaban['skor_status_pertama'] }})"
                                    value="status_pertama">
                                    {{ $pertanyaanDanJawaban['status_pertama'] }}
                                </x-radio.option>
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_kedua'"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKedua"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    onclick="perbaruiPertanyaanSkor({{ $pertanyaanDanJawaban['nomor'] }}, {{ $pertanyaanDanJawaban['skor_status_kedua'] }})"
                                    value="status_kedua">
                                    {{ $pertanyaanDanJawaban['status_kedua'] }}
                                </x-radio.option>
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_ketiga'"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKetiga"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    onclick="perbaruiPertanyaanSkor({{ $pertanyaanDanJawaban['nomor'] }}, {{ $pertanyaanDanJawaban['skor_status_ketiga'] }})"
                                    value="status_ketiga">
                                    {{ $pertanyaanDanJawaban['status_ketiga'] }}
                                </x-radio.option>
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_keempat'"
                                    id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKeempat"
                                    name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                    onclick="perbaruiPertanyaanSkor({{ $pertanyaanDanJawaban['nomor'] }}, {{ $pertanyaanDanJawaban['skor_status_keempat'] }})"
                                    value="status_keempat">
                                    {{ $pertanyaanDanJawaban['status_keempat'] }}
                                </x-radio.option>
                                @if ($pertanyaanDanJawaban['status_kelima'])
                                    <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'skor_status_kelima'"
                                        id="pertanyaan{{ $pertanyaanDanJawaban['nomor'] }}StatusKelima"
                                        name="{{ $pertanyaanDanJawaban['nomor'] }}[status_jawaban]"
                                        onclick="perbaruiPertanyaanSkor({{ $pertanyaanDanJawaban['nomor'] }}, {{ $pertanyaanDanJawaban['skor_status_kelima'] }})"
                                        value="status_kelima">
                                        {{ $pertanyaanDanJawaban['status_kelima'] }}
                                    </x-radio.option>
                                @endif
                            </x-radio>
                        </x-table.td>
                        <x-table.td>
                            <span id="skorPertanyaan{{ $pertanyaanDanJawaban['nomor'] }}">0</span>
                        </x-table.td>
                        <x-table.td>
                            <x-file-upload name="{{ $pertanyaanDanJawaban['nomor'] }}[unggah_dokumen_baru]"
                                oninput="tampilkanSaveButton()" />
                            @if ($pertanyaanDanJawaban['dokumen'])
                                <input type="hidden" name="{{ $pertanyaanDanJawaban['nomor'] }}[path_dokumen_lama]"
                                    value="{{ $pertanyaanDanJawaban['dokumen'] }}">
                                <x-button href="/storage/{{ $pertanyaanDanJawaban['dokumen'] }}" target="_blank"
                                    class="w-fit mt-2">Lihat
                                    Dokumen
                                </x-button>
                            @endif
                        </x-table.td>
                        <x-table.td>
                            <x-text-area name="{{ $pertanyaanDanJawaban['nomor'] }}[keterangan]" placeholder="Keterangan"
                                :required=false oninput="tampilkanSaveButton()" />
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
            <div x-cloak class="bg-white border-t border-gray-200 px-6 max-md:px-4 py-4 overflow-hidden"
                :class="{ 'block': isOpen, 'hidden': !isOpen }">
                <h1 class="font-bold mb-1.5">Hasil Nilai Evaluasi</h1>
                <x-table class="-mx-6">
                    <x-table.tbody>
                        <x-table.tr>
                            <x-table.td>Total Nilai Evaluasi</x-table.td>
                            <x-table.td><strong id="totalNilaiEvaluasi">0</strong></x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.td>Batas Skor Min untuk Skor Tahap Penerapan 3</x-table.td>
                            <x-table.td><strong id="batasSkorMinUntukSkorTahapPenerapan3">0</strong></x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.td>Total Skor Tahap Penerapan 1 & 2</x-table.td>
                            <x-table.td><strong>0</strong></x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.td>Status Peniliaian Tahap Penerapan 3</x-table.td>
                        </x-table.tr>
                    </x-table.tbody>
                </x-table>
            </div>
        </div>
        {{-- Daftar Area Evaluasi --}}
        <footer class="bg-white px-6 max-md:px-4 py-4 border-t border-gray-200 flex gap-2 overflow-x-auto">
            <x-button color="gray"
                href="{{ route('responden.identitas-responden.edit', $hasilEvaluasi->identitas_responden_id) }}">Identitas</x-button>
            <x-button color="gray" href="{{ route('responden.evaluasi.i-kategori-se', $hasilEvaluasi->id) }}">I Kategori
                SE</x-button>
            @foreach ($daftarAreaEvaluasiUtama as $areaEvaluasiUtama)
                <x-button
                    href="{{ route('responden.evaluasi.evaluasi-utama', [$hasilEvaluasi->id, $areaEvaluasiUtama->id]) }}"
                    color="{{ $areaEvaluasiUtama->id === $areaEvaluasi->id ? false : 'gray' }}">
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
    <script>
        let daftarSkorArray = [];

        hitungBatasSkorMinUntukSkorTahapPenerapan3();

        function perbaruiPertanyaanSkor(pertanyaanNomor, skor) {
            let pertanyaanSkorElement = document.getElementById('skorPertanyaan' + pertanyaanNomor);
            const pertanyaanSkor = pertanyaanSkorElement.textContent;

            if (pertanyaanSkor != skor) {
                pertanyaanSkorElement.textContent = skor;

                tampilkanSaveButton();
                daftarSkorArray[pertanyaanNomor] = skor;
                perbaruitotalNilaiEvaluasi();
            }
        }

        function perbaruitotalNilaiEvaluasi() {
            const totalNilaiEvaluasi = daftarSkorArray.reduce((acc, curr) => acc + curr);

            const totalNilaiEvaluasiElement = document.getElementById('totalNilaiEvaluasi');
            totalNilaiEvaluasiElement.textContent = totalNilaiEvaluasi;
        }

        function hitungBatasSkorMinUntukSkorTahapPenerapan3() {
            const batasSkorMinUntukSkorTahapPenerapan3Element = document.getElementById(
                'batasSkorMinUntukSkorTahapPenerapan3');
            const jumlahPertanyaanTahap1 = {{ $jumlahPertanyaanTahap1 }};
            const jumlahPertanyaanTahap2 = {{ $jumlahPertanyaanTahap2 }};

            const batasSkorMinUntukSkorTahapPenerapan3 = (2 * jumlahPertanyaanTahap1) + (4 * jumlahPertanyaanTahap2);
            batasSkorMinUntukSkorTahapPenerapan3Element.textContent = batasSkorMinUntukSkorTahapPenerapan3;
        }

        function tampilkanSaveButton() {
            const saveButtonElement = document.getElementById('saveButton');
            saveButtonElement.classList.remove('opacity-0');
            saveButtonElement.classList.remove('pointer-events-none');
            saveButtonElement.classList.add('scale-100');
        }
    </script>
@endpush
