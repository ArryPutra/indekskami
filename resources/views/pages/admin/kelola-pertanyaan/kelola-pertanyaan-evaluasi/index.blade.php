@extends('layouts.layout')

@section('content')
    <x-button.back class="mb-4" href="{{ route('admin.kelola-pertanyaan') }}" />

    <div class="flex gap-3 mb-5 flex-wrap">
        <x-button href="{{ route('kelola-area-evaluasi.edit', $areaEvaluasiId) }}" color="gray">Area Evaluasi</x-button>
        <x-button href="{{ route('kelola-judul-tema-pertanyaan.index') }}" color="gray">Judul Tema Pertanyaan</x-button>
        <x-button color="blue">Daftar Pertanyaan</x-button>
    </div>

    <div class="mb-3">
        <h1 class="font-bold text-xl">{{ $namaAreaEvaluasi }}</h1>
        <h1>Jumlah Pertanyaan: {{ $daftarPertanyaan->count() }}</h1>
    </div>

    <form action="{{ route('kelola-pertanyaan-evaluasi.index') }}" method="GET">
        <div class="flex gap-3 w-full mb-4">
            <x-text-field value="{{ request('cari') }}" type="text" name="cari" placeholder="Cari responden" />
            <x-button type="submit">
                <span>Cari</span>
            </x-button>
            @if (request('cari') !== null)
                <x-button type="submit" name="cari" value="" color="red">Hapus</x-button>
            @endif
        </div>

        @if (session('success'))
            <x-alert class="mb-4" type="success" isClosed="true">
                {!! session('success') !!}
            </x-alert>
        @endif
        <x-alert class="mb-4" type="error" isClosed="true">
            <b>PERINGATAN:</b> Disarankan untuk menyelesaikan seluruh evaluasi responden
            terlebih dahulu sebelum mengubah pertanyaan untuk menghindari ketidakkonsistenan pertanyaan.
        </x-alert>

        <x-dropdown class="w-fit mb-4" name="apakah-tampil" onchange="this.form.submit()" label="Status Tampil">
            <x-dropdown.option :selected="request('apakah-tampil') == 'true'" value='true'>Aktif</x-dropdown.option>
            <x-dropdown.option :selected="request('apakah-tampil') == 'false'" value='false'>Nonaktif</x-dropdown.option>
        </x-dropdown>
    </form>

    <x-button class="w-fit mb-4" href="{{ route('kelola-pertanyaan-evaluasi.create') }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Pertanyaan
    </x-button>

    <x-table>
        <x-table.thead>
            <x-table.th>Nomor</x-table.th>
            @if ($tipeEvaluasi === 'Evaluasi Utama')
                <x-table.th>Tingkat Kematangan</x-table.th>
                <x-table.th>Pertanyaan Tahap</x-table.th>
            @endif
            <x-table.th>Pertanyaan</x-table.th>
            <x-table.th>Status Pertama</x-table.th>
            <x-table.th>Status Kedua</x-table.th>
            <x-table.th>Status Ketiga</x-table.th>
            @if ($tipeEvaluasi !== 'Kategori Sistem Elektronik')
                <x-table.th>Status Keempat</x-table.th>
                @if ($tipeEvaluasi === 'Evaluasi Utama')
                    <x-table.th>Status Kelima</x-table.th>
                @endif
            @endif
            <x-table.th>Skor Status Pertama</x-table.th>
            <x-table.th>Skor Status Kedua</x-table.th>
            <x-table.th>Skor Status Ketiga</x-table.th>
            @if ($tipeEvaluasi !== 'Kategori Sistem Elektronik')
                <x-table.th>Skor Status Keempat</x-table.th>
                @if ($tipeEvaluasi === 'Evaluasi Utama')
                    <x-table.th>Skor Status Kelima</x-table.th>
                @endif
            @endif
            <x-table.th>Catatan</x-table.th>
            <x-table.th>Apakah Tampil</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            @foreach ($daftarPertanyaan as $pertanyaan)
                <x-table.tr>
                    <x-table.td>
                        {{ $pertanyaan->nomor }}
                    </x-table.td>
                    @if ($tipeEvaluasi === 'Evaluasi Utama')
                        <x-table.td>
                            {{ $pertanyaan->tingkat_kematangan }}
                        </x-table.td>
                        <x-table.td>
                            {{ $pertanyaan->pertanyaan_tahap }}
                        </x-table.td>
                    @endif
                    <x-table.td>
                        {{ $pertanyaan->pertanyaan }}
                    </x-table.td>
                    <x-table.td>
                        {{ $pertanyaan->status_pertama }}
                    </x-table.td>
                    <x-table.td>
                        {{ $pertanyaan->status_kedua }}
                    </x-table.td>
                    <x-table.td>
                        {{ $pertanyaan->status_ketiga }}
                    </x-table.td>
                    @if ($tipeEvaluasi !== 'Kategori Sistem Elektronik')
                        <x-table.td>
                            {{ $pertanyaan->status_keempat }}
                        </x-table.td>
                        @if ($tipeEvaluasi === 'Evaluasi Utama')
                            <x-table.td>
                                @if ($pertanyaan->status_kelima)
                                    {{ $pertanyaan->status_kelima }}
                                @else
                                    <span class="text-red-600 font-semibold">Kosong</span>
                                @endif
                            </x-table.td>
                        @endif
                    @endif
                    <x-table.td>
                        {{ $pertanyaan->skor_status_pertama }}
                    </x-table.td>
                    <x-table.td>
                        {{ $pertanyaan->skor_status_kedua }}
                    </x-table.td>
                    <x-table.td>
                        {{ $pertanyaan->skor_status_ketiga }}
                    </x-table.td>
                    @if ($tipeEvaluasi !== 'Kategori Sistem Elektronik')
                        <x-table.td>
                            {{ $pertanyaan->skor_status_keempat }}
                        </x-table.td>
                        @if ($tipeEvaluasi === 'Evaluasi Utama')
                            <x-table.td>
                                @if ($pertanyaan->skor_status_kelima)
                                    {{ $pertanyaan->skor_status_kelima }}
                                @else
                                    <span class="text-red-600 font-semibold">Kosong</span>
                                @endif
                            </x-table.td>
                        @endif
                    @endif
                    <x-table.td>
                        @if ($pertanyaan->catatan)
                            {{ \Illuminate\Support\Str::limit($pertanyaan->catatan, 100) }}
                        @else
                            <span class="text-red-600 font-semibold">Tidak ada catatan</span>
                        @endif
                    </x-table.td>
                    <x-table.td>
                        @if ($pertanyaan->apakah_tampil)
                            <span class="text-green-600 font-semibold">Ya</span>
                        @else
                            <span class="text-red-600 font-semibold">Tidak</span>
                        @endif
                    </x-table.td>
                    <x-table.td>
                        <div class="flex gap-2 flex-wrap">
                            <x-button href="{{ route('kelola-pertanyaan-evaluasi.edit', $pertanyaan->id) }}"
                                color="blue">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Edit
                            </x-button>
                            @if ($pertanyaan->apakah_tampil)
                                <form id="formNonaktifkanTampilPertanyaan{{ $pertanyaan->id }}"
                                    action="{{ route('kelola-pertanyaan-evaluasi.destroy', $pertanyaan->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="apakah_tampil" value="0">
                                    <x-button color="red"
                                        onclick="nonaktifkanTampilPertanyaan('{{ $pertanyaan->nomor }}', {{ $pertanyaan->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                        Nonaktifkan
                                    </x-button>
                                </form>
                            @else
                                <form action="{{ route('kelola-pertanyaan-evaluasi.destroy', $pertanyaan->id) }}"
                                    method="POST" id="formAktifkanTampilPertanyaan{{ $pertanyaan->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="apakah_tampil" value="1">
                                    <x-button color="green"
                                        onclick="aktifkanTampilPertanyaan({{ $pertanyaan->nomor }}, {{ $pertanyaan->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                        Aktifkan
                                    </x-button>
                                </form>
                            @endif
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function nonaktifkanTampilPertanyaan(nomor, pertanyaanId) {
            window.event.preventDefault();
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Nonaktifkan pertanyaan nomor " + nomor + '?',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "{{ config('app.primary_color') }}",
                confirmButtonText: "Nonaktifkan",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('formNonaktifkanTampilPertanyaan' + pertanyaanId);
                    form.submit();
                }
            });
        }

        function aktifkanTampilPertanyaan(nomor, pertanyaanId) {
            window.event.preventDefault();
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Aktifkan pertanyaan nomor " + nomor + '?',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "{{ config('app.primary_color') }}",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aktifkan",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('formAktifkanTampilPertanyaan' + pertanyaanId);
                    form.submit();
                }
            });
        }
    </script>
@endpush
