@extends('layouts.layout')

@section('content')
    <div class="space-y-2 mb-4">
        <section>
            <h1>Nama:</h1>
            <h1 class="font-bold text-lg">{{ $user->nama }}</h1>
        </section>
        <section>
            <h1>Email:</h1>
            <h1 class="font-bold text-lg">{{ $user->email }}</h1>
        </section>
        <section>
            <h1>Nomor Telepon:</h1>
            <h1 class="font-bold text-lg">{{ $user->nomor_telepon }}</h1>
        </section>
        <section>
            <h1>Nomor SK:</h1>
            <h1 class="font-bold text-lg">{{ $user->verifikator->nomor_sk }}</h1>
        </section>
        <section>
            <h1>Akses Verifikasi:</h1>
            <h1 class="font-bold text-lg {{ $user->verifikator->akses_verifikasi ? 'text-green-500' : 'text-red-500' }}">
                {{ $user->verifikator->akses_verifikasi ? 'Aktif' : 'Nonaktif' }}
            </h1>
        </section>
    </div>
@endsection
