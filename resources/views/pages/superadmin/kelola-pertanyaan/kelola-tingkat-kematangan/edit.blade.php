@extends('layouts.layout')

@section('content')
    <x-button.back class="mb-4" href="{{ route('kelola-area-evaluasi.index') }}" />

    <div class="flex gap-3 mb-5 flex-wrap">
        <x-button href="{{ route('kelola-area-evaluasi.edit', $areaEvaluasiId) }}" color="gray">Area Evaluasi</x-button>
        <x-button href="{{ route('kelola-pertanyaan-evaluasi.index') }}" color="gray">Pertanyaan Evaluasi</x-button>
        <x-button href="{{ route('kelola-judul-tema-pertanyaan.index') }}" color="gray">Judul Tema Pertanyaan</x-button>
        <x-button color="blue">Tingkat Kematangan</x-button>
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

    <x-alert class="mb-4" type="error" isClosed="true">
        <b>PERINGATAN:</b> Perubahan pada data pertanyaan dapat menyebabkan ketidakkonsistenan data evaluasi pada responden.
    </x-alert>

    <form class="space-y-2" action="{{ route('kelola-tingkat-kematangan.update', $skorEvaluasiUtamaTingkatKematanganId) }}"
        method="post" x-data="{ isDisabled: true }">
        @csrf
        @method('PUT')
        @foreach ($daftarSkorTingkatKematangan as $skorTingkatKematangan)
            @php
                $tingkatKematangan = $skorTingkatKematangan['tingkat_kematangan'];
                $minimumName = 'skor_minimum_tingkat_kematangan_' . strtolower($tingkatKematangan);
                $pencapaianName = 'skor_pencapaian_tingkat_kematangan_' . strtolower($tingkatKematangan);
            @endphp
            <x-text-field label="Skor Minimum Tingkat Kematangan {{ $tingkatKematangan }}" name="{{ $minimumName }}"
                placeholder="Masukkan skor minimum" value="{{ old($minimumName, $skorTingkatKematangan[$minimumName]) }}"
                x-bind:disabled="isDisabled" />
            <x-text-field label="Skor Pencapaian Tingkat Kematangan {{ $tingkatKematangan }}" name="{{ $pencapaianName }}"
                placeholder="Masukkan skor pencapaian"
                value="{{ old($pencapaianName, $skorTingkatKematangan[$pencapaianName]) }}" x-bind:disabled="isDisabled" />
        @endforeach
        <div class="flex gap-2 mt-4">
            <x-button color="blue" @click.prevent="isDisabled = !isDisabled"
                x-text="isDisabled ? 'Edit' : 'Batal'"></x-button>
            <x-button type="submit" x-show="!isDisabled">Perbarui Skor Tingkat Kematangan</x-button>
        </div>
    </form>
@endsection
