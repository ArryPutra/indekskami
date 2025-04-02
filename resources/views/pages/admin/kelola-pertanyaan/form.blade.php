@extends('layouts.layout')

@section('content')
    <x-button.back class="mb-4" href="{{ route('kelola-pertanyaan.index') }}" />

    @if (session('success'))
        <x-alert type="success" :isClosed=true class="mb-3">
            {{ session('success') }}
        </x-alert>
    @endif

    <form class="space-y-2 mb-6" method="POST" action="{{ $page_meta['route'] }}">
        @csrf
        @method($page_meta['method'])
        <x-text-field label="Nama Evaluasi" name="nama_evaluasi" placeholder="Masukkan nama evaluasi"
            value="{{ old('nama_evaluasi', $areaEvaluasi->nama_evaluasi) }}" />
        <x-text-field label="Judul" name="judul" placeholder="Masukkan judul"
            value="{{ old('judul', $areaEvaluasi->judul) }}" />
        <x-text-area label="Deskripsi" name="deskripsi" placeholder="Masukkan deskripsi"
            value="{{ old('deskripsi', $areaEvaluasi->deskripsi) }}" />
        <x-button class="mt-4" type="submit">Perbarui Area Evaluasi</x-button>
    </form>

    <x-table>
        <x-table.thead>
            <x-table.th>Nomor</x-table.th>
            <x-table.th>Pertanyaan</x-table.th>
            <x-table.th>Status A</x-table.th>
            <x-table.th>Status B</x-table.th>
            <x-table.th>Status C</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            @foreach ($daftarPertanyaan as $pertanyaan)
                <form method="POST" action="{{ route('kelola-pertanyaan.update-pertanyaan', $areaEvaluasi->id) }}">
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
@push('script')
    <script></script>
@endpush
