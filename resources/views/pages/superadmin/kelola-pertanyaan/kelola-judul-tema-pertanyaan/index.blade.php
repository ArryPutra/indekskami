@extends('layouts.layout')

@section('content')
    <x-button.back class="mb-4" href="{{ route('kelola-area-evaluasi.index') }}" />

    <div class="flex gap-3 mb-5 flex-wrap">
        <x-button href="{{ route('kelola-area-evaluasi.edit', $areaEvaluasiId) }}" color="gray">Area Evaluasi</x-button>
        <x-button href="{{ route('kelola-pertanyaan-evaluasi.index') }}" color="gray">Pertanyaan Evaluasi</x-button>
        <x-button color="blue">Judul Tema Pertanyaan</x-button>
        @if ($isEvaluasiUtama)
            <x-button href="{{ route('kelola-tingkat-kematangan.edit', $areaEvaluasiId) }}" color="gray">
                Tingkat Kematangan
            </x-button>
        @endif
    </div>

    <h1 class="font-bold text-xl mb-4">
        <span>{{ $namaTipeEvaluasi }}</span>
        <span>|</span>
        <span>{{ $namaAreaEvaluasi }}</span>
    </h1>

    @if (session('success'))
        <x-alert class="mb-4" type="success" isClosed="true">
            {!! session('success') !!}
        </x-alert>
    @endif


    <x-button href="{{ route('kelola-judul-tema-pertanyaan.create') }}" class="mb-3 w-fit">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Judul Tema Pertanyaan
    </x-button>

    <x-table>
        <x-table.thead>
            <x-table.th>No</x-table.th>
            <x-table.th>Judul</x-table.th>
            <x-table.th>Letakkan Sebelum Nomor</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            @foreach ($daftarJudulTemaPertanyaan as $judulTemaPertanyaan)
                <x-table.tr>
                    <x-table.td>
                        {{ $loop->iteration }}
                    </x-table.td>
                    <x-table.td>
                        {{ $judulTemaPertanyaan->judul }}
                    </x-table.td>
                    <x-table.td>
                        {{ $judulTemaPertanyaan->letakkan_sebelum_nomor }}
                    </x-table.td>
                    <x-table.td>
                        <div class="flex gap-2 flex-wrap">
                            <x-button href="{{ route('kelola-judul-tema-pertanyaan.edit', $judulTemaPertanyaan->id) }}"
                                color="blue">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Edit
                            </x-button>
                            <form action="{{ route('kelola-judul-tema-pertanyaan.destroy', $judulTemaPertanyaan->id) }}"
                                method="POST" id="formHapusJudulTemaPertanyaan{{ $judulTemaPertanyaan->id }}">
                                @csrf
                                @method('DELETE')
                                <x-button
                                    onclick="hapusJudulTemaPertanyaan('{{ $judulTemaPertanyaan->judul }}', {{ $judulTemaPertanyaan->id }})"
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
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function hapusJudulTemaPertanyaan(judul, judulTemaPertanyaanId) {
            window.event.preventDefault();
            Swal.fire({
                title: "Apakah Anda yakin?",
                html: "Hapus judul tema pertanyaan " + `<b>${judul}</b>` + '?',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "{{ config('app.primary_color') }}",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('formHapusJudulTemaPertanyaan' + judulTemaPertanyaanId);
                    form.submit();
                }
            });
        }
    </script>
@endpush
