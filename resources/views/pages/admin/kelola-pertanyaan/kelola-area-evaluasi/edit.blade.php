@extends('layouts.layout')

@section('content')
    <x-button.back class="mb-4" href="{{ route('admin.kelola-pertanyaan') }}" />


    <div class="flex gap-3 mb-5 flex-wrap">
        <x-button color="blue">Area Evaluasi</x-button>
        <x-button href="{{ route('kelola-judul-tema-pertanyaan.index') }}" color="gray">Judul Tema
            Pertanyaan</x-button>
        <x-button href="{{ route('kelola-pertanyaan-evaluasi.index') }}" color="gray">Daftar Pertanyaan</x-button>
    </div>

    @if (session('success'))
        <x-alert type="success" :isClosed=true class="mb-3">
            {{ session('success') }}
        </x-alert>
    @endif

    <h1 class="font-bold text-xl mb-3">{{ $namaAreaEvaluasi }}</h1>

    <form class="space-y-2 mb-6" method="POST" action="{{ $route }}">
        @csrf
        @method('PUT')
        <x-text-field label="Nama Evaluasi" name="nama_evaluasi" placeholder="Masukkan nama evaluasi"
            value="{{ old('nama_evaluasi', $areaEvaluasi->nama_evaluasi) }}" />
        <x-text-field label="Judul" name="judul" placeholder="Masukkan judul"
            value="{{ old('judul', $areaEvaluasi->judul) }}" />
        <x-text-area label="Deskripsi" name="deskripsi" placeholder="Masukkan deskripsi"
            value="{{ old('deskripsi', $areaEvaluasi->deskripsi) }}" />
        <x-button class="mt-4" type="submit">Perbarui Area Evaluasi</x-button>
    </form>
@endsection
