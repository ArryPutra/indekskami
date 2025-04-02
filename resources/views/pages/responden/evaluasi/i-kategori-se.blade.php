@extends('layouts.layout')

@section('content')
    <h1 class="font-bold text-2xl">{{ $areaEvaluasi->judul }}</h1>
    <p>{{ $areaEvaluasi->deskripsi }}</p>

    @php
        $daftarPesan = [
            'daftarJawabanTanpaDokumen' => 'Mohon isi pertanyaan dengan dokumen.',
            'daftarJawabanTanpaStatus' => 'Mohon isi pertanyaan dengan status.',
            'daftarJawabanDokumenUkuranKebesaran' => 'Mohon isi pertanyaan dengan maksimal ukuran dokumen 10 MB.',
            'daftarJawabanDokumenTidakValid' => 'Mohon isi pertanyaan dengan dokumen yang valid.',
        ];
    @endphp
    @foreach ($daftarPesan as $key => $pesan)
        @if (session($key))
            <x-alert class="mt-2" :isClosed=true>
                <b>{{ $pesan }}</b>
                <p>Berikut nomor pertanyaan yang harus diperbaiki: {{ session($key) }}</p>
            </x-alert>
        @endif
    @endforeach

    <form onsubmit="formSimpanJawaban(event)" action="{{ route('responden.evaluasi.i-kategori-se.simpan') }}" method="post"
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
            <x-table.tbody colspan="7">
                @foreach ($daftarPertanyaanDanJawaban as $index => $pertanyaanDanJawaban)
                    <input type="hidden" name="{{ $loop->iteration }}[pertanyaan_id]"
                        value="{{ $pertanyaanDanJawaban['pertanyaan_id'] }}">
                    <x-table.tr>
                        <x-table.td>1.{{ $pertanyaanDanJawaban['nomor'] }}</x-table.td>
                        <x-table.td class="min-w-56">
                            <x-radio label="{{ $pertanyaanDanJawaban['pertanyaan'] }}">
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'status_a'" onclick="perbaruiPertanyaanSkor({{ $index }}, 5)"
                                    name="{{ $loop->iteration }}[status_jawaban]"
                                    id="pertanyaan{{ $loop->iteration }}StatusA" value="status_a">
                                    {{ $pertanyaanDanJawaban['status_a'] }}
                                </x-radio.option>
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'status_b'" onclick="perbaruiPertanyaanSkor({{ $index }}, 2)"
                                    name="{{ $loop->iteration }}[status_jawaban]"
                                    id="pertanyaan{{ $loop->iteration }}StatusB" value="status_b">
                                    {{ $pertanyaanDanJawaban['status_b'] }}
                                </x-radio.option>
                                <x-radio.option :checked="$pertanyaanDanJawaban['status_jawaban'] === 'status_c'" onclick="perbaruiPertanyaanSkor({{ $index }}, 1)"
                                    name="{{ $loop->iteration }}[status_jawaban]"
                                    id="pertanyaan{{ $loop->iteration }}StatusC" value="status_c">
                                    {{ $pertanyaanDanJawaban['status_c'] }}
                                </x-radio.option>
                            </x-radio>
                        </x-table.td>
                        <x-table.td>
                            <span
                                id="skorPertanyaan{{ $index }}">{{ $pertanyaanDanJawaban['skor_jawaban'] }}</span>
                        </x-table.td>
                        <x-table.td>
                            <x-file-upload name="{{ $loop->iteration }}[unggah_dokumen_baru]"
                                oninput="tampilkanSaveButton()" />
                            @if ($pertanyaanDanJawaban['dokumen'])
                                <input type="hidden" name="{{ $loop->iteration }}[path_dokumen_lama]"
                                    value="{{ $pertanyaanDanJawaban['dokumen'] }}">
                                <x-button href="/storage/{{ $pertanyaanDanJawaban['dokumen'] }}" target="_blank"
                                    class="w-fit mt-2">Lihat
                                    Dokumen
                                </x-button>
                            @endif
                        </x-table.td>
                        <x-table.td>
                            <x-text-area name="{{ $loop->iteration }}[keterangan]"
                                value="{{ $pertanyaanDanJawaban['keterangan'] }}" placeholder="Keterangan" :required=false
                                oninput="tampilkanSaveButton()" value="{{ $pertanyaanDanJawaban['keterangan'] }}" />
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
            <div class="bg-white border-t border-gray-200 px-6 max-md:px-4 py-4 overflow-hidden"
                :class="{ 'block': isOpen, 'hidden': !isOpen }">
                <h1 class="font-bold mb-1.5">Hasil Nilai Evaluasi</h1>
                <div class="flex gap-2 text-sm">
                    <div>
                        <h1>Skor</h1>
                        <h1>Tingkat Keterangantungan</h1>
                    </div>
                    <div class="whitespace-nowrap">
                        <h1>: <strong id="totalSkor">0</strong></h1>
                        <h1>: <strong id="tingkatKetergantungan">Rendah</strong></h1>
                    </div>
                </div>
            </div>
        </div>
        {{-- Daftar Area Evaluasi --}}
        <footer class="bg-white px-6 max-md:px-4 py-4 border-t border-gray-200 flex gap-2 overflow-x-auto">
            <x-button color="gray"
                href="{{ route('responden.identitas-responden', $hasilEvaluasiId) }}">Identitas</x-button>
            <x-button>I Kategori SE</x-button>
            <x-button color="gray">II Tata Kelola</x-button>
            <x-button color="gray">III Risiko</x-button>
            <x-button color="gray">IV Kerangka Kerja</x-button>
            <x-button color="gray">V Pengelolaan Aset</x-button>
            <x-button color="gray">VI Teknologi</x-button>
            <x-button color="gray">VII PDP</x-button>
            <x-button color="gray">VIII Suplemen</x-button>
            <x-button color="gray">Dashboard</x-button>
        </footer>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let daftarSkorArray = {{ json_encode($totalSkorJawabanArray) }};
        let totalSkor = 0;

        // Ketika halaman di-load
        window.addEventListener('load', () => {
            perbaruiScrollPosisi();
            perbaruiTotalSkor();
        })

        function perbaruiScrollPosisi() {
            const scrollPosition = localStorage.getItem('scrollPosition');

            const daftarPesan = [
                "{{ session('daftarJawabanTanpaDokumen') }}",
                "{{ session('daftarJawabanTanpaStatus') }}",
                "{{ session('daftarJawabanDokumenUkuranKebesaran') }}",
                "{{ session('daftarJawabanDokumenTidakValid') }}",
            ];

            const apakahTidakAdaPesanGagal = daftarPesan.every(pesan => pesan === '');

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
            let pertanyaanSkorElement = document.getElementById('skorPertanyaan' + pertanyaanIndex);
            const pertanyaanSkor = pertanyaanSkorElement.textContent;

            if (pertanyaanSkor != skor) {
                pertanyaanSkorElement.textContent = skor;

                tampilkanSaveButton();
                daftarSkorArray[pertanyaanIndex] = skor;
                perbaruiTotalSkor();
            }
        }

        function perbaruiTotalSkor() {
            totalSkor = daftarSkorArray.reduce((acc, curr) => acc + curr);

            totalSkorElement = document.getElementById('totalSkor');
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
