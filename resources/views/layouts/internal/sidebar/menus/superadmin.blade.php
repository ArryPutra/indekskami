{{-- MENU: DASHBOARD --}}
<a href="{{ route('superadmin.dashboard') }}"
    class="
    {{ request()->is('superadmin/dashboard') ? $activeMenuClass : false }} {{ $defaultMenuClass }}">
    <svg class="size-6 min-w-6 fill-white relative" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="currentColor">
        <path
            d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z" />
    </svg>
    <h1 class="text-xl text-white whitespace-nowrap"
        :class="{
            'md:relative md:text-sm md:bg-slate-800 md:p-2 md:rounded-md md:left-4 md:shadow md:pointer-events-none md:top-4 md:opacity-0 group-hover:md:opacity-100 group-hover:md:top-0 group-hover:duration-300':
                !isOpenSidebar
        }">
        Dashboard
    </h1>
</a>

<a href="{{ route('kelola-area-evaluasi.index') }}"
    class="
            {{ request()->is([
                'superadmin/kelola-area-evaluasi*',
                'superadmin/kelola-pertanyaan-evaluasi*',
                'superadmin/kelola-judul-tema-pertanyaan*',
                'superadmin/kelola-tingkat-kematangan*',
            ])
                ? $activeMenuClass
                : false }} {{ $defaultMenuClass }}">
    <svg class="size-6 min-w-6 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        viewBox="0 0 24 24">
        <path
            d="M4 18h2v4.081L11.101 18H16c1.103 0 2-.897 2-2V8c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2z">
        </path>
        <path d="M20 2H8c-1.103 0-2 .897-2 2h12c1.103 0 2 .897 2 2v8c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2z">
        </path>
    </svg>
    <h1 class="text-xl text-white whitespace-nowrap"
        :class="{
            'md:relative md:text-sm md:bg-slate-800 md:p-2 md:rounded-md md:left-4 md:shadow md:pointer-events-none md:top-4 md:opacity-0 group-hover:md:opacity-100 group-hover:md:top-0 group-hover:duration-300':
                !isOpenSidebar
        }">
        Kelola
        Pertanyaan
    </h1>
</a>


{{-- MENU: KELOLA RESPONDEN --}}
<a href="{{ route('kelola-responden.index') }}"
    class="
        {{ request()->is('superadmin-admin/kelola-responden*') ? $activeMenuClass : false }} {{ $defaultMenuClass }}">
    <svg class="size-6 min-w-6 fill-white" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
        <path
            d="M12 2a5 5 0 1 0 0 10 5 5 0 1 0 0-10M4 22h16c.55 0 1-.45 1-1v-1c0-3.86-3.14-7-7-7h-4c-3.86 0-7 3.14-7 7v1c0 .55.45 1 1 1" />
    </svg>
    <h1 class="text-xl text-white whitespace-nowrap"
        :class="{
            'md:relative md:text-sm md:bg-slate-800 md:p-2 md:rounded-md md:left-4 md:shadow md:pointer-events-none md:top-4 md:opacity-0 group-hover:md:opacity-100 group-hover:md:top-0 group-hover:duration-300':
                !isOpenSidebar
        }">
        Kelola
        Responden</h1>
</a>

{{-- MENU: KELOLA VERIFIKATOR --}}
<a href="{{ route('kelola-verifikator.index') }}"
    class="
        {{ request()->is('superadmin-admin/kelola-verifikator*') ? $activeMenuClass : false }} {{ $defaultMenuClass }}">
    <svg class="size-6 min-w-6 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        viewBox="0 0 24 24">
        <path
            d="M8 12.052c1.995 0 3.5-1.505 3.5-3.5s-1.505-3.5-3.5-3.5-3.5 1.505-3.5 3.5 1.505 3.5 3.5 3.5zM9 13H7c-2.757 0-5 2.243-5 5v1h12v-1c0-2.757-2.243-5-5-5zm11.294-4.708-4.3 4.292-1.292-1.292-1.414 1.414 2.706 2.704 5.712-5.702z">
        </path>
    </svg>
    <h1 class="text-xl text-white whitespace-nowrap"
        :class="{
            'md:relative md:text-sm md:bg-slate-800 md:p-2 md:rounded-md md:left-4 md:shadow md:pointer-events-none md:top-4 md:opacity-0 group-hover:md:opacity-100 group-hover:md:top-0 group-hover:duration-300':
                !isOpenSidebar
        }">
        Kelola
        Verifikator
    </h1>
</a>

{{-- MENU: KELOLA MANAJEMEN --}}
<a href="{{ route('kelola-manajemen.index') }}"
    class="
        {{ request()->is('superadmin-admin/kelola-manajemen*') ? $activeMenuClass : false }} {{ $defaultMenuClass }}">
    <svg class="size-6 min-w-6 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        fill="currentColor" viewBox="0 0 24 24">
        <path
            d="M8 4a4 4 0 1 0 0 8 4 4 0 1 0 0-8M3 20h10c.55 0 1-.45 1-1v-1c0-2.76-2.24-5-5-5H7c-2.76 0-5 2.24-5 5v1c0 .55.45 1 1 1M21 11.5c0-2-1.5-3.5-3.5-3.5S14 9.5 14 11.5s1.5 3.5 3.5 3.5c.62 0 1.18-.16 1.67-.42l2.12 2.12 1.41-1.41-2.12-2.12c.26-.49.42-1.05.42-1.67M17.5 13c-.88 0-1.5-.62-1.5-1.5s.62-1.5 1.5-1.5 1.5.62 1.5 1.5-.62 1.5-1.5 1.5">
        </path>
    </svg>
    <h1 class="text-xl text-white whitespace-nowrap"
        :class="{
            'md:relative md:text-sm md:bg-slate-800 md:p-2 md:rounded-md md:left-4 md:shadow md:pointer-events-none md:top-4 md:opacity-0 group-hover:md:opacity-100 group-hover:md:top-0 group-hover:duration-300':
                !isOpenSidebar
        }">
        Kelola
        Manajemen
    </h1>
</a>

{{-- MENU: KELOLA ADMIN --}}
<a href="{{ route('kelola-admin.index') }}"
    class="
    {{ request()->is('superadmin/kelola-admin*') ? $activeMenuClass : false }} {{ $defaultMenuClass }}">
    <svg class="size-6 min-w-6 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        fill="currentColor" viewBox="0 0 24 24">
        <path
            d="M8 4a4 4 0 1 0 0 8 4 4 0 1 0 0-8M15.54 11.54c2.02-2.02 2.02-5.06 0-7.07l-1.41 1.41c1.23 1.23 1.23 3.01 0 4.24l1.41 1.41Z">
        </path>
        <path
            d="m18.36 1.64-1.41 1.41c2.87 2.87 2.87 7.03 0 9.9l1.41 1.41c3.63-3.63 3.63-9.1 0-12.73ZM3 20h10c.55 0 1-.45 1-1v-1c0-2.76-2.24-5-5-5H7c-2.76 0-5 2.24-5 5v1c0 .55.45 1 1 1">
        </path>
    </svg>
    <h1 class="text-xl text-white whitespace-nowrap"
        :class="{
            'md:relative md:text-sm md:bg-slate-800 md:p-2 md:rounded-md md:left-4 md:shadow md:pointer-events-none md:top-4 md:opacity-0 group-hover:md:opacity-100 group-hover:md:top-0 group-hover:duration-300':
                !isOpenSidebar
        }">
        Kelola Admin
    </h1>
</a>


{{-- MENU: PROFIL --}}
<a href="{{ route('superadmin.profil') }}"
    class="
        {{ request()->is('superadmin/profil*') ? $activeMenuClass : false }} {{ $defaultMenuClass }}">
    <svg class="size-6 min-w-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path fill-rule="evenodd"
            d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
            clip-rule="evenodd" />
    </svg>
    <h1 class="text-xl text-white whitespace-nowrap"
        :class="{
            'md:relative md:text-sm md:bg-slate-800 md:p-2 md:rounded-md md:left-4 md:shadow md:pointer-events-none md:top-4 md:opacity-0 group-hover:md:opacity-100 group-hover:md:top-0 group-hover:duration-300':
                !isOpenSidebar
        }">
        Profil
    </h1>
</a>
