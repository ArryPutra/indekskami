@extends('layouts.layout')

@section('content')
    <x-button.back href="{{ route('kelola-manajemen.index') }}" class="mb-4" />
    <form method="POST" class="flex flex-col gap-2" action="{{ $page_meta['route'] }}">
        @csrf
        @method($page_meta['method'])
        <x-text-field name="nama" label="Nama Manajemen" placeholder="Masukkan nama manajemen"
            value="{{ old('nama', $manajemen?->user?->nama) }}" />
        <x-text-field name="username" label="Username" placeholder="Masukkan username"
            value="{{ old('username', $manajemen?->user?->username) }}" />
        <x-text-field name="email" label="Email" placeholder="Masukkan email"
            value="{{ old('email', $manajemen?->user?->email) }}" />
        <x-text-field name="nomor_telepon" label="Nomor Telepon" placeholder="Masukkan nomor telepon"
            value="{{ old('nomor_telepon', $manajemen?->user?->nomor_telepon) }}" />
        <x-text-field name="jabatan" label="Jabatan" placeholder="Masukkan jabatan"
            value="{{ old('jabatan', $manajemen?->jabatan) }}" />
        <x-text-field name="password" label="Password {{ $page_meta['method'] == 'PUT' ? 'baru' : false }}"
            placeholder="Masukkan password" type="password" :required=false />
        <x-text-field name="password_confirmation"
            label="Konfirmasi Password {{ $page_meta['method'] == 'PUT' ? 'baru' : false }}"
            placeholder="Masukkan konfirmasi password" type="password" :required=false />
        <x-button type="submit" class="mt-2 w-fit">
            {{ $page_meta['method'] == 'POST' ? 'Tambah' : 'Perbarui' }} Admin
        </x-button>
    </form>
@endsection
