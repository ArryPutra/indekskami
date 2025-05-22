@extends('layouts.layout')

@section('content')
    <main class="space-y-3 break-words">
        <x-button.back href="{{ route('kelola-verifikator.index') }}" />
        <section>
            <h1>Nama Instansi:</h1>
            <h1 class="font-bold text-lg">{{ $verifikator->user->nama }}</h1>
        </section>
        <section>
            <h1>Username:</h1>
            <h1 class="font-bold text-lg">{{ $verifikator->user->username }}</h1>
        </section>
        <section>
            <h1>Email:</h1>
            <h1 class="font-bold text-lg">{{ $verifikator->user->email }}</h1>
        </section>
        <section>
            <h1>Nomor Telepon:</h1>
            <h1 class="font-bold text-lg">{{ $verifikator->user->nomor_telepon }}</h1>
        </section>
        <section>
            <h1>Nomor SK:</h1>
            <h1 class="font-bold text-lg">{{ $verifikator->nomor_sk }}</h1>
        </section>
        <section>
            <h1>Status Akun:</h1>
            <h1 class="font-bold text-lg {{ $verifikator->user->apakah_akun_nonaktif ? 'text-red-500' : 'text-green-500' }}">
                {{ $verifikator->user->apakah_akun_nonaktif ? 'Nonaktif' : 'Aktif' }}
            </h1>
        </section>
        <section>
            <h1>Tanggal Dibuat:</h1>
            <h1 class="font-bold text-lg">
                {{ Carbon\Carbon::parse($verifikator->created_at)->translatedFormat('l, d F Y, H:i:s') }}
            </h1>
        </section>
        <section>
            <h1>Tanggal Diperbarui:</h1>
            <h1 class="font-bold text-lg">
                {{ Carbon\Carbon::parse($verifikator->updated_at)->translatedFormat('l, d F Y, H:i:s') }}
            </h1>
        </section>
    </main>
@endsection
