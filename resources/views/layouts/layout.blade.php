<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/icon/logo-prov-kalsel.png') }}" type="png">
    {{-- IMPORT GOOGLE FONT: INTER --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    {{-- IMPORT TAILWINDCSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Indeks KAMI | {{ $title }}</title>
    @stack('head')
</head>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<body class="font-inter">
    @if (Auth::check())
        {{-- Untuk user yang sudah autentikasi --}}
        @php
            $peranId = Auth::user()->peran_id;
        @endphp
        @switch($peranId)
            @case(1)
                @include('layouts.admin-verifikator.header')
                @include('layouts.admin-verifikator.sidebar')
                <x-content>
                    @yield('content')
                </x-content>
            @break

            @case(2)
                @include('layouts.admin-verifikator.header')
                @include('layouts.admin-verifikator.sidebar')
                <x-content>
                    @yield('content')
                </x-content>
            @break

            @case(3)
                @include('layouts.responden.header')
                @include('layouts.responden.sidebar')
                <x-content>
                    @yield('content')
                </x-content>
            @break
        @endswitch
    @else
        {{-- Untuk user yang belum autentikasi --}}
        @yield('content')
    @endif
    @stack('script')
</body>

</html>
