@php
    $activeMenuClass = "bg-slate-800 before:content-[''] before:w-1 before:h-full 
    before:bg-primary before:absolute before:right-0 opacity-100";
@endphp

<aside x-data="{ isOpen: false }" class="max-md:-left-[16rem] bg-slate-900 h-screen fixed w-[16rem] z-20 duration-300"
    :class="{ 'max-md:-left-0 shadow-2xl': isOpen, 'max-md:-left-[16rem]': !isOpen }">
    <div class="flex justify-center items-end h-20 mb-8 max-md:justify-between max-md:px-5">
        <img class="h-16" src="{{ asset('images/logo/prov-kalsel.png') }}" alt="Logo Prov Kalsel">
        <svg @click="isOpen = false" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            class="md:hidden size-12 fill-white mb-2">
            <path
                d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z">
            </path>
        </svg>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
        class="md:hidden fixed top-4 left-3 size-12 -z-10" @click="isOpen = true">
        <path d="M4 11h12v2H4zm0-5h16v2H4zm0 12h7.235v-2H4z"></path>
    </svg>

    <div class="space-y-1.5">
        @if (Auth::user()->peran_id === 1)
            {{-- MENU: DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}"
                class="
        {{ request()->is('admin/dashboard') ? $activeMenuClass : false }}
        font-semibold relative cursor-pointer flex gap-4 items-center px-4 py-3 opacity-75 hover:opacity-100">
                <svg class="size-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z" />
                </svg>
                <h1 class="text-xl text-white">Dashboard</h1>
            </a>
            {{-- MENU: KELOLA RESPONDEN --}}
            <a href="{{ route('kelola-responden.index') }}"
                class="
        {{ request()->is('admin/kelola-responden*') ? $activeMenuClass : false }}
        font-semibold relative cursor-pointer flex gap-4 items-center px-4 py-3 opacity-75 hover:opacity-100">
                <svg class="size-6 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path
                        d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z">
                    </path>
                </svg>
                <h1 class="text-xl text-white">Kelola Responden</h1>
            </a>
            {{-- MENU: KELOLA VERIFIKATOR --}}
            <a href="{{ route('kelola-verifikator.index') }}"
                class="
        {{ request()->is('admin/kelola-verifikator*') ? $activeMenuClass : false }}
        font-semibold relative cursor-pointer flex gap-4 items-center px-4 py-3 opacity-75 hover:opacity-100">
                <svg class="size-6 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path
                        d="M8 12.052c1.995 0 3.5-1.505 3.5-3.5s-1.505-3.5-3.5-3.5-3.5 1.505-3.5 3.5 1.505 3.5 3.5 3.5zM9 13H7c-2.757 0-5 2.243-5 5v1h12v-1c0-2.757-2.243-5-5-5zm11.294-4.708-4.3 4.292-1.292-1.292-1.414 1.414 2.706 2.704 5.712-5.702z">
                    </path>
                </svg>
                <h1 class="text-xl text-white">Kelola Verifikator</h1>
            </a>
            {{-- MENU: KELOLA PERTANYAAN --}}
            <a href="{{ route('kelola-pertanyaan.index') }}"
                class="
        {{ request()->is('admin/kelola-pertanyaan*') ? $activeMenuClass : false }}
        font-semibold relative cursor-pointer flex gap-4 items-center px-4 py-3 opacity-75 hover:opacity-100">
                <svg class="size-6 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path
                        d="M4 18h2v4.081L11.101 18H16c1.103 0 2-.897 2-2V8c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2z">
                    </path>
                    <path
                        d="M20 2H8c-1.103 0-2 .897-2 2h12c1.103 0 2 .897 2 2v8c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2z">
                    </path>
                </svg>
                <h1 class="text-xl text-white">Kelola Pertanyaan</h1>
            </a>
            {{-- MENU: PROFIL --}}
            <a href="{{ route('admin.profil') }}"
                class="
        {{ request()->is('admin/profil*') ? $activeMenuClass : false }}
        font-semibold relative cursor-pointer flex gap-4 items-center px-4 py-3 opacity-75 hover:opacity-100">
                <svg class="size-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                        clip-rule="evenodd" />
                </svg>
                <h1 class="text-xl text-white">Profil</h1>
            </a>
        @endif
    </div>

    <h1 class="text-white/75 absolute bottom-0 border-t-2 border-slate-800 w-full text-center py-4 text-sm">
        Indeks KAMI versi 5.0
    </h1>
</aside>
