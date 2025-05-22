@extends('layouts.layout')

@section('content')
    <x-button.back href="{{ route('kelola-judul-tema-pertanyaan.index') }}" class="mb-4" />

    <form class="flex flex-col gap-2" action="{{ $pageMeta['route'] }}" method="POST">
        @csrf
        @method($pageMeta['method'])

        <x-text-field name="judul" label="Judul" placeholder="Masukkan judul"
            value="{{ old('judul', $judulTemaPertanyaan->judul) }}" />
        <x-text-field name="letakkan_sebelum_nomor" label="Letakkan Sebelum Nomor"
            placeholder="Masukkan letakkan sebelum nomor"
            value="{{ old('letakkan_sebelum_nomor', $judulTemaPertanyaan->letakkan_sebelum_nomor) }}" />
        <x-button class="mt-2 w-fit">
            {{ $pageMeta['method'] == 'POST' ? 'Tambah' : 'Perbarui' }}
        </x-button>
    </form>
@endsection
