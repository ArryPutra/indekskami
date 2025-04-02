@php
    $activeMenuClass = 'text-primary max-md:bg-primary/10 md:border-b-2 max-md:border-l-2';
@endphp

<aside x-cloak x-data="{ isOpen: false }" class="bg-white top-20 fixed w-full px-6 max-md:px-0 z-20 shadow">
    <svg x-show="!isOpen" @click="isOpen = true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        viewBox="0 0 24 24" class="fixed top-4 size-12 md:hidden left-2">
        <path d="M4 11h12v2H4zm0-5h16v2H4zm0 12h7.235v-2H4z"></path>
    </svg>
    <svg x-show="isOpen" @click="isOpen = false" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        viewBox="0 0 24 24" class="fixed top-4 size-12 md:hidden left-2">
        <path
            d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z">
        </path>
    </svg>

    <div :class="{ 'max-md:-flex': isOpen, 'max-md:hidden': !isOpen }"
        class="flex font-semibold md:gap-4 max-md:flex-col white max-md:px-0 max-md:shadow">
        <a href="{{ route('responden.dashboard') }}"
            class="{{ request()->routeIs('responden.dashboard') ? $activeMenuClass : false }} py-4 md:px-2 max-md:pl-4">Dashboard</a>
        <a href="{{ route('responden.redirect-evaluasi') }}"
            class="{{ request()->is('responden/evaluasi*') ? $activeMenuClass : false }} py-4 md:px-2 max-md:pl-4">Evaluasi</a>
        <a href="{{ route('responden.riwayat') }}"
            class="{{ request()->routeIs('responden.riwayat') ? $activeMenuClass : false }} py-4 md:px-2 max-md:pl-4">Riwayat</a>
        <a href="{{ route('responden.profil') }}"
            class="{{ request()->routeIs('responden.profil') ? $activeMenuClass : false }} py-4 md:px-2 max-md:pl-4">Profil</a>
    </div>
</aside>
