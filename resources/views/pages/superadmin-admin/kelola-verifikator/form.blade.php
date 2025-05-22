@extends('layouts.layout')

@section('content')
    <x-button.back href="{{ route('kelola-verifikator.index') }}" class="mb-4" />
    <form method="POST" class="flex flex-col gap-2" action="{{ $page_meta['route'] }}">
        @csrf
        @method($page_meta['method'])
        <x-text-field name="nama" label="Nama Verifkator" placeholder="Masukkan nama verifikator"
            value="{{ old('nama', $verifikator?->user?->nama) }}" />
        <x-text-field name="username" label="Username" placeholder="Masukkan username"
            value="{{ old('username', $verifikator?->user?->username) }}" />
        <x-text-field name="email" label="Email" placeholder="Masukkan email"
            value="{{ old('email', $verifikator?->user?->email) }}" />
        <x-text-field name="nomor_telepon" label="Nomor Telepon" placeholder="Masukkan nomor telepon"
            value="{{ old('nomor_telepon', $verifikator?->user?->nomor_telepon) }}" />
        <x-text-field name="nomor_sk" label="Nomor SK" placeholder="Masukkan nomor sk"
            value="{{ old('nomor_sk', $verifikator?->nomor_sk) }}" />
        <x-text-field name="password" label="Password {{ $page_meta['method'] == 'PUT' ? 'baru' : false }}"
            placeholder="Masukkan password" type="password" :required=false />
        <x-text-field name="password_confirmation"
            label="Konfirmasi Password {{ $page_meta['method'] == 'PUT' ? 'baru' : false }}"
            placeholder="Masukkan konfirmasi password" type="password" :required=false />
        <x-button type="submit" class="mt-2 w-fit">
            {{ $page_meta['method'] == 'POST' ? 'Tambah' : 'Perbarui' }} Verifikator
        </x-button>
    </form>
@endsection
