@extends('layouts.layout', ['title' => 'Login'])

@push('head')
    <script src="https://www.google.com/recaptcha/api.js"></script>
@endpush

@section('content')
    <main class="bg-gradient-to-t from-primary/10 to-white flex h-dvh max-lg:flex-col-reverse max-lg:items-center">
        <form method="POST" action="{{ route('login') }}"
            class="h-screen flex flex-col lg:justify-center w-full lg:max-w-xl lg:px-32 
            max-lg:max-w-sm max-lg:pt-6 px-4">
            @csrf
            {{-- GAMBAR --}}
            <div class="mb-6 flex gap-2 justify-between max-lg:hidden">
                <img class="h-16 max-lg:h-14" src="{{ asset('images/logo/prov-kalsel.png') }}"
                    alt="Logo Provinsi Kalimantan Selatan">
                <img class="h-16 max-lg:h-14" src="{{ asset('images/logo/indeks-kami.png') }}"
                    alt="Logo Provinsi Kalimantan Selatan">
                <img class="h-16 max-lg:h-14" src="{{ asset('images/logo/bssn.png') }}"
                    alt="Logo Provinsi Kalimantan Selatan">
            </div>
            {{-- JUDUL --}}
            <div class="mb-5">
                <h1 class="font-extrabold text-4xl text-primary">Login</h1>
                <p class="mt-2 text-slate-500">Selamat datang, silahkan login.</p>
            </div>
            {{-- Jika terjadi login gagal menampilkan pesan error --}}
            @error('failedLogin')
                <x-alert class="mb-2" isClosed="true">{{ $message }}</x-alert>
            @enderror
            {{-- USERNAME INPUT --}}
            <x-textfield name="username" label="Username" placeholder="Masukkan username" />
            {{-- PASSWORD INPUT --}}
            <x-textfield name="password" class="mt-4" label="Password" placeholder="Masukkan password" type="password" />
            {{-- RECAPTCHA --}}
            <div class="g-recaptcha mt-4" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            @error('g-recaptcha-response')
                <p class="text-red-500 mt-1">reCaptcha wajib diisi.</p>
            @enderror
            {{-- TOMBOL LOGIN --}}
            <x-button type="submit" class="mt-6">Login</x-button>
            <div class="flex flex-wrap text-center items-center justify-center pt-4 text-slate-500">
                <span>Bantuan & Layanan Hubungi:</span>
                <span>08xx-xxxx-xxxx</span>
            </div>
        </form>
        <div class="w-full lg:h-full pl-6 max-lg:pl-4 max-lg:py-3 lg:pb-12 flex flex-col justify-center lg:justify-end lg:gap-2 text-white"
            style="
            background: linear-gradient(to top, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0)), url('{{ asset('images/login-bg.jpg') }}');
            background-size: cover;
            background-position: left;
            ">
            <h1 class="font-bold lg:text-4xl max-lg:text-3xl">Indeks KAMI versi 5.0</h1>
            <a href="https://diskominfo.kalselprov.go.id" class="hover:underline" target="_blank">
                Dinas Komunikasi dan Informatika Kalimantan Selatan
            </a>
        </div>
    </main>
@endsection
