@extends('layouts.layout')

@section('content')
    <x-button.back class="mb-4" href="{{ route('admin.kelola-pertanyaan.index') }}" />

    <div class="flex gap-3 mb-6">
        <x-button>Evaluasi</x-button>
        <x-button color="gray">Tema Judul Pertanyaan</x-button>
        <x-button color="gray">Daftar Pertanyaan</x-button>
    </div>

    @if (session('successUpdateAreaEvaluasi'))
        <x-alert type="success" :isClosed=true class="mb-3">
            {{ session('successUpdateAreaEvaluasi') }}
        </x-alert>
    @endif

    <form class="space-y-2 mb-6" method="POST" action="{{ $routes['routeUpdateAreaEvaluasi'] }}">
        @csrf
        <x-text-field label="Nama Evaluasi" name="nama_evaluasi" placeholder="Masukkan nama evaluasi"
            value="{{ old('nama_evaluasi', $areaEvaluasi->nama_evaluasi) }}" />
        <x-text-area label="Deskripsi" name="deskripsi" placeholder="Masukkan deskripsi"
            value="{{ old('deskripsi', $areaEvaluasi->deskripsi) }}" />
        <x-button class="mt-4" type="submit">Perbarui Area Evaluasi</x-button>
    </form>

    @if (session('successUpdateJudulTemaPertanyaan'))
        <x-alert type="success" :isClosed=true class="mb-3">
            {{ session('successUpdateJudulTemaPertanyaan') }}
        </x-alert>
    @endif

    <section class="mb-6 space-y-3">
        <form class="space-y-3" action="{{ $routes['routeUpdateJudulTemaPertanyaan'] }}" method="POST">
            @csrf
            <x-table>
                <x-table.thead>
                    <x-table.th>Nomor</x-table.th>
                    <x-table.th>Judul Tema</x-table.th>
                    <x-table.th>Sebelum Nomor</x-table.th>
                </x-table.thead>
                <x-table.tbody id="tbodyJudulTemaPertanyaan">
                    @foreach ($daftarJudulTemaPertanyaan as $judulTemaPertanyaan)
                        <x-table.tr>
                            <x-table.td>
                                {{ $loop->iteration }}
                            </x-table.td>
                            <x-table.td>
                                <x-text-field name="{{ $judulTemaPertanyaan->id }}[judul]"
                                    placeholder="Masukkan judul tema pertanyaan"
                                    value="{{ $judulTemaPertanyaan->judul }}" />
                            </x-table.td>
                            <x-table.td>
                                <x-text-field name="{{ $judulTemaPertanyaan->id }}[sebelum_nomor]"
                                    placeholder="Masukkan sebelum nomor"
                                    value="{{ $judulTemaPertanyaan->sebelum_nomor }}" />
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.tbody>
            </x-table>
            <x-button type="submit">Perbarui Judul Tema</x-button>
        </form>
        <div class="flex gap-3 flex-wrap">
            <form action="">
                <x-button color="blue" onclick="tambahJudulTemaPertanyaan()">Tambah Judul Tema</x-button>
            </form>
            <form class="flex gap-2 w-fit" action="{{ $routes['routeDestroyJudulTemaPertanyaan'] }}" method="POST">
                <x-text-field name="hapus_judul_tema_pertanyaan" placeholder="Hapus ID judul tema pertanyaan" />
                <x-button type="submit" color="red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="currentcolor">
                        <path
                            d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z">
                        </path>
                        <path d="M9 10h2v8H9zm4 0h2v8h-2z"></path>
                    </svg>
                </x-button>
            </form>
        </div>
    </section>

    @if (session('successUpdatePertanyaan'))
        <x-alert type="success" :isClosed=true class="mb-3">
            {{ session('successUpdatePertanyaan') }}
        </x-alert>
    @endif

    <x-table>
        <x-table.thead>
            <x-table.th>Nomor</x-table.th>
            <x-table.th>Pertanyaan</x-table.th>
            <x-table.th>Status A</x-table.th>
            <x-table.th>Status B</x-table.th>
            <x-table.th>Status C</x-table.th>
            <x-table.th>Skor Status A</x-table.th>
            <x-table.th>Skor Status B</x-table.th>
            <x-table.th>Skor Status C</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            @foreach ($daftarPertanyaan as $pertanyaan)
                <form method="POST" action="{{ $routes['routeUpdatePertanyaan'] }}">
                    @csrf
                    <input type="hidden" name="pertanyaan_id" value="{{ $pertanyaan->id }}">
                    <x-table.tr>
                        <x-table.td>
                            <x-text-field name="nomor" value="{{ $pertanyaan->nomor }}" />
                        </x-table.td>
                        <x-table.td>
                            <x-text-area name="pertanyaan" placeholder="Masukkan pertanyaan"
                                value="{{ $pertanyaan->pertanyaan }}" />
                        </x-table.td>
                        <x-table.td>
                            <x-text-area name="status_a" placeholder="Masukkan status a"
                                value="{{ $pertanyaan->status_a }}" />
                        </x-table.td>
                        <x-table.td>
                            <x-text-area name="status_b" placeholder="Masukkan status b"
                                value="{{ $pertanyaan->status_b }}" />
                        </x-table.td>
                        <x-table.td>
                            <x-text-area name="status_c" placeholder="Masukkan status c"
                                value="{{ $pertanyaan->status_c }}" />
                        </x-table.td>
                        <x-table.td>
                            <x-text-field name="skor_status_a" placeholder="Masukkan status c"
                                value="{{ $pertanyaan->skor_status_a }}" />
                        </x-table.td>
                        <x-table.td>
                            <x-text-field name="skor_status_b" placeholder="Masukkan status c"
                                value="{{ $pertanyaan->skor_status_b }}" />
                        </x-table.td>
                        <x-table.td>
                            <x-text-field name="skor_status_c" placeholder="Masukkan status c"
                                value="{{ $pertanyaan->skor_status_c }}" />
                        </x-table.td>
                        <x-table.td>
                            <div class="flex gap-2 flex-wrap">
                                <x-button color="blue" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                    Perbarui
                                </x-button>
                                <x-button color="red">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                    Nonaktif
                                </x-button>
                            </div>
                        </x-table.td>
                    </x-table.tr>
                </form>
            @endforeach
        </x-table.tbody>
    </x-table>
@endsection
