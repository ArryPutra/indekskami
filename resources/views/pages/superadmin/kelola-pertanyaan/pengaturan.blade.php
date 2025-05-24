@extends('layouts.layout')

@section('content')
    <div class="flex gap-3 mb-5 flex-wrap">
        <x-button href="{{ route('kelola-area-evaluasi.index') }}" color="gray">Kelola Pertanyaan</x-button>
        <x-button>Pengaturan</x-button>
    </div>

    @if (session('success'))
        <x-alert class="mb-4" type="success" isClosed="true">
            {!! session('success') !!}
        </x-alert>
    @endif

    <form action="{{ route('pengaturan-evaluasi.store') }}" method="post">
        @csrf
        <div class="space-y-2 mb-4">
            <x-text-field name="maksimal_ukuran_dokumen" label="Maksimal Ukuran Dokumen (dalam MB, contoh: 5, 10, 15)"
                placeholder="Masukkan pertanyaan" value="{{ $maksimalUkuranDokumen }}" />
            <x-text-field name="daftar_ekstensi_dokumen_valid"
                label='Daftar Ekstensi Dokumen Valid (pisahkan dengan koma tanpa spasi, contoh: ["pdf","doc","xls"])'
                placeholder="Masukkan daftar ekstensi dokumen valid" value="{{ $daftarEkstensiDokumenValid }}" />
        </div>

        <x-button type="submit">Perbarui</x-button>
    </form>
@endsection
