@php
    use App\Models\Peran;
    $peranId = Auth::user()->peran_id;
@endphp

@if (
    $peranId === Peran::PERAN_SUPERADMIN_ID ||
        $peranId === Peran::PERAN_ADMIN_ID ||
        $peranId === Peran::PERAN_VERIFIKATOR_ID ||
        $peranId === Peran::PERAN_MANAJEMEN_ID)
    <main
        class="bg-slate-100 w-full min-h-dvh pr-6 pt-28 max-md:pt-24 max-md:pl-0 max-md:pr-0 pb-6 duration-300 {{ $class }}"
        :class="{ 'md:pl-[17rem]': isOpenSidebar, 'md:pl-[5rem]': !isOpenSidebar }" x-cloak>
        <div class="bg-white p-4 md:rounded-md max-md:mt-12">
            {{ $slot }}
        </div>
    </main>
@elseif($peranId === Peran::PERAN_RESPONDEN_ID)
    <main class="bg-slate-100 w-full min-h-dvh px-6 max-md:px-0 pt-44 max-md:pt-24 pb-6 {{ $class }}">
        <div class="bg-white p-4 md:rounded-md max-md:mt-12">
            {{ $slot }}
        </div>
    </main>
@endif
