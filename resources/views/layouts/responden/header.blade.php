<div x-data="{ showProfileMenu: false }">
    <h1
        class="font-bold text-3xl max-md:text-2xl fixed left-[5.5rem] top-6 max-md:absolute max-md:top-24 max-md:left-4 z-20 md:z-30 whitespace-nowrap">
        {{ $title }}
    </h1>
    <header
        class="bg-white w-full fixed px-6 max-md:px-4
        h-20 z-20 flex items-center justify-between border-b border-gray-200">
        <img class="h-14 max-md:hidden" src="{{ asset('images/logo/prov-kalsel.png') }}" alt="Logo Prov Kalsel">
        <div class="md:hidden"></div>

        <div @click="showProfileMenu = !showProfileMenu"
            class="flex gap-2 cursor-pointer w-4/5 items-center justify-end h-full">
            <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path>
            </svg>
            <h1 class="truncate max-w-full overflow-hidden whitespace-nowrap">
                {{ auth()->user()->nama }}
            </h1>
        </div>
    </header>
    <div x-cloak x-show="showProfileMenu" @click.outside="showProfileMenu = false"
        x-transition:enter="transition ease-out duration-100 transform" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75 transform"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="bg-white p-4 shadow rounded-lg fixed right-8 top-24 text-sm w-32 z-30">
        <h1 class="font-bold break-words">{{ auth()->user()->nama }}</h1>
        <h1>{{ auth()->user()->peran->nama_peran }}</h1>
        <div class="w-full h-0.5 bg-slate-200 my-2"></div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <x-button type="submit" color="red">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    class="fill-white">
                    <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
                    <path
                        d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z">
                    </path>
                </svg>
                <span>Logout</span>
            </x-button>
        </form>
    </div>
</div>
