{{-- MENU: DASHBOARD --}}
<a href="{{ route('manajemen.dashboard') }}"
    class="
        {{ request()->is('manajemen/dashboard') ? $activeMenuClass : false }} {{ $defaultMenuClass }}">
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

{{-- MENU: PROFIL --}}
<a href="{{ route('manajemen.profil') }}"
    class="
        {{ request()->is('manajemen/profil*') ? $activeMenuClass : false }} {{ $defaultMenuClass }}">
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
        Profil</h1>
</a>
