{{-- MENU: DASHBOARD --}}
<a href="{{ route('verifikator.dashboard') }}"
    class="
            {{ request()->is('verifikator/dashboard') ? $activeMenuClass : false }} {{ $defaultMenuClass }}">
    <svg class="size-6 min-w-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
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
{{-- MENU: KELOLA EVALUASI --}}
<a href="{{ route('verifikator.kelola-evaluasi.perlu-ditinjau') }}"
    class="
                {{ request()->is('verifikator/kelola-evaluasi*') ? $activeMenuClass : false }} {{ $defaultMenuClass }}">
    <svg class="size-6 min-w-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
        class="size-6">
        <path fill-rule="evenodd"
            d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
            clip-rule="evenodd" />
        <path fill-rule="evenodd"
            d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z"
            clip-rule="evenodd" />
    </svg>
    <h1 class="text-xl text-white whitespace-nowrap"
        :class="{
            'md:relative md:text-sm md:bg-slate-800 md:p-2 md:rounded-md md:left-4 md:shadow md:pointer-events-none md:top-4 md:opacity-0 group-hover:md:opacity-100 group-hover:md:top-0 group-hover:duration-300':
                !isOpenSidebar
        }">
        Kelola
        Evaluasi</h1>
</a>
{{-- MENU: PROFIL --}}
<a href="{{ route('verifikator.profil') }}"
    class="
            {{ request()->is('verifikator/profil') ? $activeMenuClass : false }} {{ $defaultMenuClass }}">
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
