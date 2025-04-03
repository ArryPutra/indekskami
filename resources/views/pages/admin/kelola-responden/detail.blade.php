@extends('layouts.layout')

@section('content')
    <main class="space-y-3">
        <x-button.back href="{{ route('kelola-responden.index') }}" />
        <section>
            <h1>Nama Instansi</h1>
            <h1 class="font-bold text-lg">{{ $responden->nama }}</h1>
        </section>
        <section>
            <h1>Username</h1>
            <h1 class="font-bold text-lg">{{ $responden->username }}</h1>
        </section>
        <section>
            <h1>Email</h1>
            <h1 class="font-bold text-lg">{{ $responden->email }}</h1>
        </section>
        <section>
            <h1>Nomor Telepon</h1>
            <h1 class="font-bold text-lg">{{ $responden->nomor_telepon }}</h1>
        </section>
        <section>
            <h1>Status Evaluasi</h1>
            <h1 class="font-bold text-lg {{ $responden->responden->status_evaluasi ? 'text-green-500' : 'text-red-500' }}">
                {{ $responden->responden->status_evaluasi ? 'Aktif' : 'Nonaktif' }}
            </h1>
        </section>
        <section>
            <h1>Status Akun</h1>
            <h1 class="font-bold text-lg {{ $responden->apakah_akun_nonaktif ? 'text-red-500' : 'text-green-500' }}">
                {{ $responden->apakah_akun_nonaktif ? 'Nonaktif' : 'Aktif' }}
            </h1>
        </section>
    </main>
@endsection
