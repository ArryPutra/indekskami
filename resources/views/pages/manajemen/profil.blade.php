@extends('layouts.layout')

@section('content')
    <div class="space-y-2">
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
            <h1>Peran:</h1>
            <h1 class="font-bold text-lg">{{ $user->peran->nama_peran }}</h1>
        </section>
        <section>
            <h1>Jabatan:</h1>
            <h1 class="font-bold text-lg">{{ $user->manajemen->jabatan }}</h1>
        </section>
        <section>
            <h1>Tanggal Akun Dibuat:</h1>
            <h1 class="font-bold text-lg">
                {{ Carbon\Carbon::parse($user->created_at)->translatedFormat('l, d F Y, H:i:s') }}
            </h1>
        </section>
        <section>
            <h1>Tanggal Akun Diperbarui:</h1>
            <h1 class="font-bold text-lg">
                {{ Carbon\Carbon::parse($user->updated_at)->translatedFormat('l, d F Y, H:i:s') }}
            </h1>
        </section>
    </div>
@endsection
