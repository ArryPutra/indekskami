@extends('layouts.layout')

@section('content')
    <main class="space-y-3 break-words">
        <x-button.back href="{{ route('kelola-manajemen.index') }}" />
        <section>
            <h1>Nama:</h1>
            <h1 class="font-bold text-lg">{{ $manajemen->user->nama }}</h1>
        </section>
        <section>
            <h1>Username:</h1>
            <h1 class="font-bold text-lg">{{ $manajemen->user->username }}</h1>
        </section>
        <section>
            <h1>Email:</h1>
            <h1 class="font-bold text-lg">{{ $manajemen->user->email }}</h1>
        </section>
        <section>
            <h1>Nomor Telepon:</h1>
            <h1 class="font-bold text-lg">{{ $manajemen->user->nomor_telepon }}</h1>
        </section>
        <section>
            <h1>Jabatan:</h1>
            <h1 class="font-bold text-lg">{{ $manajemen->jabatan }}</h1>
        </section>
        <section>
            <h1>Status Akun:</h1>
            <h1 class="font-bold text-lg {{ $manajemen->user->apakah_akun_nonaktif ? 'text-red-500' : 'text-green-500' }}">
                {{ $manajemen->user->apakah_akun_nonaktif ? 'Nonaktif' : 'Aktif' }}
            </h1>
        </section>
        <section>
            <h1>Tanggal Dibuat:</h1>
            <h1 class="font-bold text-lg">
                {{ Carbon\Carbon::parse($manajemen->created_at)->translatedFormat('l, d F Y, H:i:s') }}
            </h1>
        </section>
        <section>
            <h1>Tanggal Diperbarui:</h1>
            <h1 class="font-bold text-lg">
                {{ Carbon\Carbon::parse($manajemen->updated_at)->translatedFormat('l, d F Y, H:i:s') }}
            </h1>
        </section>
    </main>
@endsection
