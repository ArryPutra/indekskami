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
    </div>

    @if (session('success'))
        <x-alert class="mb-4" type="success" isClosed="true">
            {!! session('success') !!}
        </x-alert>
    @endif
    <form action="{{ route('admin.profil.perbarui-password') }}" method="post">
        @csrf
        <div class="space-y-2">
            <x-text-field name="password" label="Password Baru" placeholder="Masukkan password baru" type="password" />
            <x-text-field name="password_confirmation" label="Konfirmasi Password Baru"
                placeholder="Konfirmasi password baru" type="password" />
        </div>
        <x-button class="mt-4">Perbarui Password</x-button>
    </form>
@endsection
