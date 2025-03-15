@extends('layouts.layout')

@section('content')
    <main class="space-y-3">
        <x-button.back href="{{ route('kelola-responden.index') }}" />
        <section>
            <h1>Nama Instansi</h1>
            <h1 class="font-bold text-xl">{{ $responden->nama }}</h1>
        </section>
        <section>
            <h1>Username</h1>
            <h1 class="font-bold text-xl">{{ $responden->username }}</h1>
        </section>
        <section>
            <h1>Email</h1>
            <h1 class="font-bold text-xl">{{ $responden->email }}</h1>
        </section>
        <section>
            <h1>Nomor Telepon</h1>
            <h1 class="font-bold text-xl">{{ $responden->nomor_telepon }}</h1>
        </section>
        <section>
            <h1>Status Evaluasi</h1>
            <h1 class="font-bold text-xl {{ $responden->responden->status_evaluasi ? 'text-green-500' : 'text-red-500' }}">
                {{ $responden->responden->status_evaluasi ? 'Aktif' : 'Nonaktif' }}
            </h1>
        </section>
        <section>
            <h1>Status Akun</h1>
            <h1 class="font-bold text-xl {{ $responden->status_akun ? 'text-green-500' : 'text-red-500' }}">
                {{ $responden->status_akun ? 'Aktif' : 'Nonaktif' }}
            </h1>
        </section>
    </main>
@endsection
