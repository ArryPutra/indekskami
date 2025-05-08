@extends('layouts.layout')

@section('content')
    <div class="space-y-2">
        <section>
            <h1>Nama</h1>
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
            <h1>Daerah Instansi:</h1>
            <h1 class="font-bold text-lg">{{ $responden->daerah }}</h1>
        </section>
        <section>
            <h1>Alamat:</h1>
            <h1 class="font-bold text-lg">{{ $responden->alamat }}</h1>
        </section>
        <section>
            <h1>Status Evaluasi:</h1>
            <h1 class="font-bold text-lg">{{ $responden->statusProgresEvaluasi->status_progres_evaluasi }}</h1>
        </section>
    </div>
@endsection
