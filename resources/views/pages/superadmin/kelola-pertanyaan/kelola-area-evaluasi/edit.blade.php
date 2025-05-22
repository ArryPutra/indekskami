@extends('layouts.layout')

@section('content')
    <x-button.back class="mb-4" href="{{ route('kelola-area-evaluasi.index') }}" />

    <div class="flex gap-3 mb-5 flex-wrap">
        <x-button color="blue">Area Evaluasi</x-button>
        <x-button href="{{ route('kelola-pertanyaan-evaluasi.index') }}" color="gray">Pertanyaan Evaluasi</x-button>
        <x-button href="{{ route('kelola-judul-tema-pertanyaan.index') }}" color="gray">Judul Tema Pertanyaan</x-button>
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
        <x-alert type="success" :isClosed=true class="mb-4">
            {{ session('success') }}
        </x-alert>
    @endif

    <form class="space-y-2" method="POST" action="{{ route('kelola-area-evaluasi.update', $areaEvaluasi->id) }}">
        @csrf
        @method('PUT')
        <x-text-field label="Nama Evaluasi" name="nama_area_evaluasi" placeholder="Masukkan nama evaluasi"
            value="{{ old('nama_area_evaluasi', $areaEvaluasi->nama_area_evaluasi) }}" />
        <x-text-field label="Judul" name="judul" placeholder="Masukkan judul"
            value="{{ old('judul', $areaEvaluasi->judul) }}" />
        <x-text-area label="Deskripsi" name="deskripsi" placeholder="Masukkan deskripsi"
            value="{{ old('deskripsi', $areaEvaluasi->deskripsi) }}" />
        <x-button class="mt-4" type="submit">Perbarui Area Evaluasi</x-button>
    </form>
@endsection
