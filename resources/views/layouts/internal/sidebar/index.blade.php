@php
    $activeMenuClass = "bg-slate-800 before:content-[''] before:w-1 before:h-full 
    before:bg-primary before:absolute before:right-0 opacity-100";
    $defaultMenuClass = 'font-semibold relative cursor-pointer flex gap-4 items-center 
        px-4 h-12 opacity-75 hover:opacity-100 group';

    $peranIdList = [
        'superadmin' => App\Models\Peran::PERAN_SUPERADMIN_ID,
        'admin' => App\Models\Peran::PERAN_ADMIN_ID,
        'verifikator' => App\Models\Peran::PERAN_VERIFIKATOR_ID,
        'manajemen' => App\Models\Peran::PERAN_MANAJEMEN_ID,
    ];
@endphp

<aside class="max-md:-left-[16rem] bg-slate-900 h-screen fixed max-md:w-[16rem]
    z-20 duration-300"
    :class="{ 'max-md:-left-0 shadow-2xl md:w-[16rem]': isOpenSidebar, 'max-md:-left-[16rem] md:w-[4rem]': !isOpenSidebar }"
    x-cloak>
    <div class="flex items-end h-20 max-h-20 mb-8 justify-between px-5">
        <img class="h-16 min-w-12" :class="{
            'md:hidden': !isOpenSidebar,
        }"
            src="{{ asset('images/logo/prov-kalsel.png') }}" alt="Logo Prov Kalsel">
        <svg @click="
            isOpenSidebar = false; 
            localStorage.setItem('isOpenSidebar', false);
        "
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            class="size-12 fill-white mb-2 cursor-pointer"
            :class="{
                'md:hidden':
                    !isOpenSidebar
            }">
            <path
                d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z">
            </path>
        </svg>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
        class="fixed top-4 max-md:left-3 md:left-1.5 size-12 cursor-pointer max-md:-z-10 md:z-0 md:fill-white"
        :class="{ 'md:hidden': isOpenSidebar }"
        @click="        
        isOpenSidebar = true; 
        if (window.innerWidth >= 768) {
            localStorage.setItem('isOpenSidebar', true);
        }">
        <path d="M4 11h12v2H4zm0-5h16v2H4zm0 12h7.235v-2H4z"></path>
    </svg>

    <div class="space-y-1.5 h-2/3">
        @if (Auth::user()->peran_id === $peranIdList['superadmin'])
            @include('layouts.internal.sidebar.menus.superadmin')
        @elseif (Auth::user()->peran_id === $peranIdList['admin'])
            @include('layouts.internal.sidebar.menus.admin')
        @elseif (Auth::user()->peran_id === $peranIdList['verifikator'])
            @include('layouts.internal.sidebar.menus.verifikator')
        @elseif (Auth::user()->peran_id === $peranIdList['manajemen'])
            @include('layouts.internal.sidebar.menus.manajemen')
        @endif
    </div>

    <h1 class="text-white/75 absolute bottom-0 border-t-2 border-slate-800 bg-slate-900 w-full text-center py-4 text-sm whitespace-nowrap"
        :class="{
            'md:relative md:text-sm md:bg-slate-800 md:p-2 md:rounded-md md:left-4 md:shadow md:pointer-events-none md:top-4 md:opacity-0 group-hover:md:opacity-100 group-hover:md:top-0 group-hover:duration-300':
                !isOpenSidebar
        }">
        Indeks KAMI versi 5.0
    </h1>
</aside>
