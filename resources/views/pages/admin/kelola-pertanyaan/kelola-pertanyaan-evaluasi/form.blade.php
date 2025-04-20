@extends('layouts.layout')

@section('content')
    <x-button.back class="mb-4" href="{{ route('kelola-pertanyaan-evaluasi.index') }}" />

    <form action="{{ $pageMeta['route'] }}" method="POST">
        @csrf
        @method($pageMeta['method'])
        <div class="space-y-2">
            <x-text-field name="nomor" label="Nomor" placeholder="Masukkan nomor"
                value="{{ old('nomor', $pertanyaan->nomor) }}" />
            @if ($tipeEvaluasi === 'Evaluasi Utama')
                <x-text-field name="tingkat_kematangan" label="Tingkat Kematangan" placeholder="Masukkan tingkat kematangan"
                    value="{{ old('tingkat_kematangan', $pertanyaan->tingkat_kematangan) }}" />
                <x-text-field name="pertanyaan_tahap" label="Pertanyaan Tahap" placeholder="Masukkan pertanyaan tahap"
                    value="{{ old('pertanyaan_tahap', $pertanyaan->pertanyaan_tahap) }}" />
            @endif
            <x-text-area name="pertanyaan" label="Pertanyaan" placeholder="Masukkan pertanyaan"
                value="{{ old('pertanyaan', $pertanyaan->pertanyaan) }}" />
            <x-text-field name="status_pertama" label="Status Pertama" placeholder="Masukkan status pertama"
                value="{{ old('status_pertama', $pertanyaan->status_pertama) }}" />
            <x-text-field name="status_kedua" label="Status Kedua" placeholder="Masukkan status kedua"
                value="{{ old('status_kedua', $pertanyaan->status_kedua) }}" />
            <x-text-field name="status_ketiga" label="Status Ketiga" placeholder="Masukkan status ketiga"
                value="{{ old('status_ketiga', $pertanyaan->status_ketiga) }}" />
            @if ($tipeEvaluasi !== 'Kategori Sistem Elektronik')
                <x-text-field name="status_keempat" label="Status Keempat" placeholder="Masukkan status keempat"
                    value="{{ old('status_keempat', $pertanyaan->status_keempat) }}" />
                <x-text-field name="status_kelima" label="Status Kelima" placeholder="Masukkan status kelima"
                    value="{{ old('status_kelima', $pertanyaan->status_kelima) }}" />
            @endif
            <x-text-field name="skor_status_pertama" label="Skor Status Pertama" placeholder="Masukkan skor status pertama"
                value="{{ old('skor_status_pertama', $pertanyaan->skor_status_pertama) }}" />
            <x-text-field name="skor_status_kedua" label="Skor Status Kedua" placeholder="Masukkan skor status kedua"
                value="{{ old('skor_status_kedua', $pertanyaan->skor_status_kedua) }}" />
            <x-text-field name="skor_status_ketiga" label="Skor Status Ketiga" placeholder="Masukkan skor status ketiga"
                value="{{ old('skor_status_ketiga', $pertanyaan->skor_status_ketiga) }}" />
            @if ($tipeEvaluasi !== 'Kategori Sistem Elektronik')
                <x-text-field name="skor_status_keempat" label="Skor Status Keempat"
                    placeholder="Masukkan skor status keempat"
                    value="{{ old('skor_status_keempat', $pertanyaan->skor_status_keempat) }}" />
                <x-text-field name="skor_status_kelima" label="Skor Status Kelima" placeholder="Masukkan skor status kelima"
                    value="{{ old('skor_status_kelima', $pertanyaan->skor_status_kelima) }}" />
            @endif
        </div>
        <x-button type="submit" class="mt-4">Simpan</x-button>
    </form>
@endsection
