@extends('layouts.layout')

@section('content')
    <main class="space-y-3">
        <x-button.back href="{{ route('kelola-responden.index') }}" />
        <section>
            <h1>Nama Instansi</h1>
            <h1 class="font-bold text-lg">{{ $user->nama }}</h1>
        </section>
        <section>
            <h1>Username</h1>
            <h1 class="font-bold text-lg">{{ $user->username }}</h1>
        </section>
        <section>
            <h1>Email</h1>
            <h1 class="font-bold text-lg">{{ $user->email }}</h1>
        </section>
        <section>
            <h1>Nomor Telepon</h1>
            <h1 class="font-bold text-lg">{{ $user->nomor_telepon }}</h1>
        </section>
        <section>
            <h1>Status Evaluasi</h1>
            <h1 class="font-bold text-lg {{ $user->responden->status_evaluasi ? 'text-green-500' : 'text-red-500' }}">
                {{ $user->responden->status_evaluasi ? 'Aktif' : 'Nonaktif' }}
            </h1>
        </section>
        <section>
            <h1>Status Akun</h1>
            <h1 class="font-bold text-lg {{ $user->apakah_akun_nonaktif ? 'text-red-500' : 'text-green-500' }}">
                {{ $user->apakah_akun_nonaktif ? 'Nonaktif' : 'Aktif' }}
            </h1>
        </section>
    </main>
@endsection
