@extends('layouts.layout')

@section('content')
    <main class="space-y-3 break-words">
        <x-button.back href="{{ route('kelola-admin.index') }}" />
        <section>
            <h1>Nama:</h1>
            <h1 class="font-bold text-lg">{{ $admin->user->nama }}</h1>
        </section>
        <section>
            <h1>Username:</h1>
            <h1 class="font-bold text-lg">{{ $admin->user->username }}</h1>
        </section>
        <section>
            <h1>Email:</h1>
            <h1 class="font-bold text-lg">{{ $admin->user->email }}</h1>
        </section>
        <section>
            <h1>Nomor Telepon:</h1>
            <h1 class="font-bold text-lg">{{ $admin->user->nomor_telepon }}</h1>
        </section>
        <section>
            <h1>Status Akun:</h1>
            <h1 class="font-bold text-lg {{ $admin->user->apakah_akun_nonaktif ? 'text-red-500' : 'text-green-500' }}">
                {{ $admin->user->apakah_akun_nonaktif ? 'Nonaktif' : 'Aktif' }}
            </h1>
        </section>
        <section>
            <h1>Tanggal Dibuat:</h1>
            <h1 class="font-bold text-lg">
                {{ Carbon\Carbon::parse($admin->created_at)->translatedFormat('l, d F Y, H:i:s') }}
            </h1>
        </section>
        <section>
            <h1>Tanggal Diperbarui:</h1>
            <h1 class="font-bold text-lg">
                {{ Carbon\Carbon::parse($admin->updated_at)->translatedFormat('l, d F Y, H:i:s') }}
            </h1>
        </section>
    </main>
@endsection
