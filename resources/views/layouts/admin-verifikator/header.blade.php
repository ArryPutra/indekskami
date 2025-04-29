<div x-data="{ showProfileMenu: false }">
    <h1 class="font-bold text-3xl fixed top-[1.5rem] max-md:absolute max-md:top-24 max-md:left-4 z-10 md:z-30 whitespace-nowrap duration-300"
        :class="{ 'md:left-[17rem]': isOpen, 'md:left-[5rem]': !isOpen }" x-cloak>
        {{ $title }}
    </h1>
    <header
        class="bg-white w-full fixed pl-[17rem] pr-8 max-md:pl-2 max-md:pr-4 max-md:left-0 
        h-20 z-20 flex items-center justify-between border-b border-gray-200">
        <div></div>

        <div @click="showProfileMenu = !showProfileMenu" class="flex gap-2 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path>
            </svg>
            <h1>{{ auth()->user()->nama }}</h1>
        </div>
    </header>
    <div x-cloak x-show="showProfileMenu" @click.outside="showProfileMenu = false"
        x-transition:enter="transition ease-out duration-100 transform" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75 transform"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="bg-white p-4 shadow rounded-lg fixed right-8 top-24 text-sm w-32 max-md:z-10">
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
