@extends('layouts.layout')

@section('content')
    <x-button.back href="{{ route('kelola-responden.index') }}" />
    <form method="POST" class="mt-4 flex flex-col gap-2" action="{{ $page_meta['route'] }}">
        @csrf
        @method($page_meta['method'])
        <x-textfield name="nama" label="Nama Instansi" placeholder="Masukkan nama instansi"
            value="{{ old('nama', $responden->nama) }}" />
        <x-dropdown name="daerah" label="Pilih Daerah Instansi">
            <x-dropdown.option value="Kabupaten/Kota" :selected="old('daerah', $responden->responden?->daerah) == 'Kabupaten/Kota'">Kabupaten/Kota</x-dropdown.option>
            <x-dropdown.option value="Provinsi" :selected="old('daerah', $responden->responden?->daerah) == 'Provinsi'">Provinsi</x-dropdown.option>
        </x-dropdown>
        <x-textfield name="username" label="Username" placeholder="Masukkan username"
            value="{{ old('username', $responden->username) }}" />
        <x-textfield name="email" label="Email" placeholder="Masukkan email"
            value="{{ old('email', $responden->email) }}" />
        <x-textfield name="nomor_telepon" label="Nomor Telepon" placeholder="Masukkan nomor telepon"
            value="{{ old('nomor_telepon', $responden->nomor_telepon) }}" />
        <x-textfield name="password" label="Password {{ $page_meta['method'] == 'PUT' ? 'baru' : false }}"
            placeholder="Masukkan password" type="password" />
        <x-textfield name="password_confirmation"
            label="Konfirmasi Password {{ $page_meta['method'] == 'PUT' ? 'baru' : false }}"
            placeholder="Masukkan konfirmasi password" type="password" />
        <x-radio>
            <x-radio.option name="status_evaluasi" value="1" :checked="old('status_evaluasi', $responden->responden?->status_evaluasi) === 1">
                Ya
            </x-radio.option>
            <x-radio.option name="status_evaluasi" value="0" :checked="old('status_evaluasi', $responden->responden?->status_evaluasi) === 0">
                Tidak
            </x-radio.option>
        </x-radio>
        <x-button type="submit" class="mt-2 w-fit">
            {{ $page_meta['method'] == 'POST' ? 'Tambah' : 'Perbarui' }} Responden
        </x-button>
    </form>
@endsection
