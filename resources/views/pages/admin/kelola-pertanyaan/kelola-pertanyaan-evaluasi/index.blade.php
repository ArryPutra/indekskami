@extends('layouts.layout')

@section('content')
    <x-button.back class="mb-4" href="{{ route('admin.kelola-pertanyaan') }}" />

    <div class="flex gap-3 mb-5 flex-wrap">
        <x-button href="{{ route('kelola-area-evaluasi.edit', $areaEvaluasiId) }}" color="gray">Area Evaluasi</x-button>
        <x-button href="{{ route('kelola-judul-tema-pertanyaan.index') }}" color="gray">Judul Tema Pertanyaan</x-button>
        <x-button color="blue">Daftar Pertanyaan</x-button>
    </div>

    @if (session('success'))
        <x-alert class="mb-4" type="success" isClosed="true">
            {!! session('success') !!}
        </x-alert>
    @endif

    <h1 class="font-bold text-xl mb-3">{{ $namaAreaEvaluasi }}</h1>

    <x-button href="{{ route('kelola-pertanyaan-evaluasi.create') }}" class="mb-3 w-fit">
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
            @if ($tipeEvaluasi === 'Evaluasi Utama')
                <x-table.th>Status Keempat</x-table.th>
                <x-table.th>Status Kelima</x-table.th>
            @endif
            <x-table.th>Skor Status Pertama</x-table.th>
            <x-table.th>Skor Status Kedua</x-table.th>
            <x-table.th>Skor Status Ketiga</x-table.th>
            @if ($tipeEvaluasi !== 'Kategori Sistem Elektronik')
                <x-table.th>Skor Status Keempat</x-table.th>
                <x-table.th>Skor Status Kelima</x-table.th>
            @endif
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
                        <x-table.td>
                            @if ($pertanyaan->status_kelima)
                                {{ $pertanyaan->status_kelima }}
                            @else
                                <span class="text-red-600">Kosong</span>
                            @endif
                        </x-table.td>
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
                        <x-table.td>
                            {{ $pertanyaan->skor_status_kelima }}
                        </x-table.td>
                    @endif
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
                            <form action="{{ null }}" method="POST"
                                id="formHapusPertanyaanEvaluasi{{ null }}">
                                @csrf
                                @method('DELETE')
                                <x-button onclick="hapusPertanyaanEvaluasi('{{ null }}', {{ null }})"
                                    color="red">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="currentcolor">
                                        <path
                                            d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z">
                                        </path>
                                        <path d="M9 10h2v8H9zm4 0h2v8h-2z"></path>
                                    </svg>
                                    Hapus
                                </x-button>
                            </form>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>
@endsection
