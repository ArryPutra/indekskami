@if (Auth::user()->peran_id == 1 || Auth::user()->peran_id == 2)
    <main class="bg-slate-100 w-full min-h-screen pl-[17rem] pr-6 pt-28 max-md:pt-24 max-md:pl-0 max-md:pr-0 pb-6">
        <div class="bg-white p-4 md:rounded-md max-md:mt-12">
            {{ $slot }}
        </div>
    </main>
@endif
@if (Auth::user()->peran_id == 3)
    <main class="bg-slate-100 w-full min-h-screen px-6 max-md:px-0 pt-44 max-md:pt-28 pb-6">
        <div class="bg-white p-4 md:rounded-md max-md:mt-12">
            {{ $slot }}
        </div>
    </main>
@endif
