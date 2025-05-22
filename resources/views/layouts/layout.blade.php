<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/icon/logo-prov-kalsel.png') }}" type="image/png">
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
        <div x-data="{ isOpenSidebar: localStorage.getItem('isOpenSidebar') === 'true' ? true : false }">
            @switch($peranId)
                {{-- Super Admin --}}
                @case(App\Models\Peran::PERAN_SUPERADMIN_ID)
                    @include('layouts.internal.header')
                    @include('layouts.internal.sidebar.index')
                    <x-content class="{{ $class ?? null }}">
                        @yield('content')
                    </x-content>
                @break

                {{-- Admin --}}
                @case(App\Models\Peran::PERAN_ADMIN_ID)
                    @include('layouts.internal.header')
                    @include('layouts.internal.sidebar.index')
                    <x-content class="{{ $class ?? null }}">
                        @yield('content')
                    </x-content>
                @break

                {{-- Responden --}}
                @case(App\Models\Peran::PERAN_RESPONDEN_ID)
                    @include('layouts.responden.header')
                    @include('layouts.responden.sidebar')
                    <x-content class="{{ $class ?? null }}">
                        @yield('content')
                    </x-content>
                @break

                {{-- Verifikator --}}
                @case(App\Models\Peran::PERAN_VERIFIKATOR_ID)
                    @include('layouts.internal.header')
                    @include('layouts.internal.sidebar.index')
                    <x-content class="{{ $class ?? null }}">
                        @yield('content')
                    </x-content>
                @break

                {{-- Verifikator --}}
                @case(App\Models\Peran::PERAN_MANAJEMEN_ID)
                    @include('layouts.internal.header')
                    @include('layouts.internal.sidebar.index')
                    <x-content class="{{ $class ?? null }}">
                        @yield('content')
                    </x-content>
                @break
            @endswitch
        </div>
    @else
        {{-- Untuk user yang belum autentikasi --}}
        @yield('content')
    @endif
    @stack('script')
</body>

</html>
