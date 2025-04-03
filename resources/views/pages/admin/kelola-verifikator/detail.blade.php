@extends('layouts.layout')

@section('content')
    <main class="space-y-3">
        <x-button.back href="{{ route('kelola-verifikator.index') }}" />
        <section>
            <h1>Nama Instansi</h1>
            <h1 class="font-bold text-lg">{{ $verifikator->nama }}</h1>
        </section>
        <section>
            <h1>Username</h1>
            <h1 class="font-bold text-lg">{{ $verifikator->username }}</h1>
        </section>
        <section>
            <h1>Email</h1>
            <h1 class="font-bold text-lg">{{ $verifikator->email }}</h1>
        </section>
        <section>
            <h1>Nomor Telepon</h1>
            <h1 class="font-bold text-lg">{{ $verifikator->nomor_telepon }}</h1>
        </section>
        <section>
            <h1>Nomor SK</h1>
            <h1 class="font-bold text-lg">{{ $verifikator->verifikator->nomor_sk }}</h1>
        </section>
        <section>
            <h1>Akses Verifikasi</h1>
            <h1
                class="font-bold text-lg {{ $verifikator->verifikator->akses_verifikasi ? 'text-green-500' : 'text-red-500' }}">
                {{ $verifikator->verifikator->akses_verifikasi ? 'Aktif' : 'Nonaktif' }}
            </h1>
        </section>
        <section>
            <h1>Status Akun</h1>
            <h1 class="font-bold text-lg {{ $verifikator->apakah_akun_nonaktif ? 'text-red-500' : 'text-green-500' }}">
                {{ $verifikator->apakah_akun_nonaktif ? 'Nonaktif' : 'Aktif' }}
            </h1>
        </section>
    </main>
@endsection
