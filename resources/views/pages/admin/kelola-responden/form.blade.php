@extends('layouts.layout')

@section('content')
    <x-button.back href="{{ route('kelola-responden.index') }}" class="mb-4" />
    <form method="POST" class="flex flex-col gap-2" action="{{ $page_meta['route'] }}">
        @csrf
        @method($page_meta['method'])
        <x-text-field name="nama" label="Nama Instansi" placeholder="Masukkan nama instansi"
            value="{{ old('nama', $responden->nama) }}" />
        <x-dropdown name="daerah" label="Pilih Daerah Instansi">
            <x-dropdown.option value="Kabupaten/Kota" :selected="old('daerah', $responden->responden?->daerah) == 'Kabupaten/Kota'">Kabupaten/Kota</x-dropdown.option>
            <x-dropdown.option value="Provinsi" :selected="old('daerah', $responden->responden?->daerah) == 'Provinsi'">Provinsi</x-dropdown.option>
        </x-dropdown>
        <x-text-field name="username" label="Username" placeholder="Masukkan username"
            value="{{ old('username', $responden->username) }}" />
        <x-text-field name="email" label="Email" placeholder="Masukkan email"
            value="{{ old('email', $responden->email) }}" />
        <x-text-field name="nomor_telepon" label="Nomor Telepon" placeholder="Masukkan nomor telepon"
            value="{{ old('nomor_telepon', $responden->nomor_telepon) }}" />
        <x-text-field name="password" label="Password {{ $page_meta['method'] == 'PUT' ? 'baru' : false }}"
            placeholder="Masukkan password" type="password" :required=false />
        <x-text-field name="password_confirmation"
            label="Konfirmasi Password {{ $page_meta['method'] == 'PUT' ? 'baru' : false }}"
            placeholder="Masukkan konfirmasi password" type="password" :required=false />
        <x-radio label="Apakah responden dapat melakukan evaluasi?">
            <x-radio.option name="akses_evaluasi" id="ya" value="1" :checked="old('akses_evaluasi', $responden->responden?->akses_evaluasi) == '1'">
                Ya
            </x-radio.option>
            <x-radio.option name="akses_evaluasi" id="tidak" value="0" :checked="old('akses_evaluasi', $responden->responden?->akses_evaluasi) == '0'">
                Tidak
            </x-radio.option>
        </x-radio>
        <x-button type="submit" class="mt-2 w-fit">
            {{ $page_meta['method'] == 'POST' ? 'Tambah' : 'Perbarui' }} Responden
        </x-button>
    </form>
@endsection
