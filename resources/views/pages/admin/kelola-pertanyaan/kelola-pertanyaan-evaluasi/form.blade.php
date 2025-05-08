@extends('layouts.layout')

@section('content')
    <x-button.back class="mb-4" href="{{ route('kelola-pertanyaan-evaluasi.index') }}" />

    <form action="{{ $pageMeta['route'] }}" method="POST">
        @csrf
        @method($pageMeta['method'])
        <div class="space-y-2">
            <x-text-field name="nomor" label="Nomor" placeholder="Masukkan nomor"
                value="{{ old('nomor', $pertanyaanEvaluasi->nomor) }}" />
            @if ($tipeEvaluasi === 'Evaluasi Utama')
                <x-dropdown name="tingkat_kematangan" label="Pilih Tingkat Kematangan">
                    @foreach ($dropdownOptions['tingkatKematangan'] as $tingkatKematangan)
                        <x-dropdown.option value="{{ $tingkatKematangan }}"
                            :selected="old('tingkat_kematangan', $pertanyaanRelasi->tingkat_kematangan) ===
                                $tingkatKematangan">{{ $tingkatKematangan }}</x-dropdown.option>
                    @endforeach
                </x-dropdown>
                <x-dropdown name="pertanyaan_tahap" label="Pilih Pertanyaan Tahap">
                    @foreach ($dropdownOptions['pertanyaanTahap'] as $pertanyaanTahap)
                        <x-dropdown.option value="{{ $pertanyaanTahap }}"
                            :selected="old('pertanyaan_tahap', $pertanyaanRelasi->pertanyaan_tahap) == $pertanyaanTahap">{{ $pertanyaanTahap }}</x-dropdown.option>
                    @endforeach
                </x-dropdown>
            @endif
            <x-text-area name="pertanyaan" label="Pertanyaan" placeholder="Masukkan pertanyaan"
                value="{{ old('pertanyaan', $pertanyaanEvaluasi->pertanyaan) }}" />
            <x-text-field name="status_pertama" label="Status Pertama" placeholder="Masukkan status pertama"
                value="{{ old('status_pertama', $pertanyaanRelasi->status_pertama) }}" />
            <x-text-field name="status_kedua" label="Status Kedua" placeholder="Masukkan status kedua"
                value="{{ old('status_kedua', $pertanyaanRelasi->status_kedua) }}" />
            <x-text-field name="status_ketiga" label="Status Ketiga" placeholder="Masukkan status ketiga"
                value="{{ old('status_ketiga', $pertanyaanRelasi->status_ketiga) }}" />
            @if ($tipeEvaluasi !== 'Kategori Sistem Elektronik')
                <x-text-field name="status_keempat" label="Status Keempat" placeholder="Masukkan status keempat"
                    value="{{ old('status_keempat', $pertanyaanRelasi->status_keempat) }}" />
                @if ($tipeEvaluasi === 'Evaluasi Utama')
                    <x-text-field name="status_kelima" label="Status Kelima (Opsional)"
                        placeholder="Masukkan status kelima (opsional)"
                        value="{{ old('status_kelima', $pertanyaanRelasi->status_kelima) }}" />
                @endif
            @endif
            <x-text-field name="skor_status_pertama" label="Skor Status Pertama" placeholder="Masukkan skor status pertama"
                value="{{ old('skor_status_pertama', $pertanyaanRelasi->skor_status_pertama) }}" />
            <x-text-field name="skor_status_kedua" label="Skor Status Kedua" placeholder="Masukkan skor status kedua"
                value="{{ old('skor_status_kedua', $pertanyaanRelasi->skor_status_kedua) }}" />
            <x-text-field name="skor_status_ketiga" label="Skor Status Ketiga" placeholder="Masukkan skor status ketiga"
                value="{{ old('skor_status_ketiga', $pertanyaanRelasi->skor_status_ketiga) }}" />
            @if ($tipeEvaluasi !== 'Kategori Sistem Elektronik')
                <x-text-field name="skor_status_keempat" label="Skor Status Keempat"
                    placeholder="Masukkan skor status keempat"
                    value="{{ old('skor_status_keempat', $pertanyaanRelasi->skor_status_keempat) }}" />
                @if ($tipeEvaluasi === 'Evaluasi Utama')
                    <x-text-field name="skor_status_kelima" label="Skor Status Kelima (Opsional)"
                        placeholder="Masukkan skor status kelima (opsional)"
                        value="{{ old('skor_status_kelima', $pertanyaanRelasi->skor_status_kelima) }}" />
                @endif
            @endif
            <x-text-area name="catatan" label="Catatan" placeholder="Masukkan catatan"
                value="{{ old('catatan', $pertanyaanEvaluasi->catatan) }}" />
        </div>
        <x-button type="submit" class="mt-4">
            {{ $pageMeta['method'] === 'POST' ? 'Tambah' : 'Perbarui' }}
        </x-button>
    </form>
@endsection
