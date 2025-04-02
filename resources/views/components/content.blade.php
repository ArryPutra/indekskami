@can('adminOrVerifikator')
    <main class="bg-slate-100 w-full min-h-dvh pl-[17rem] pr-6 pt-28 max-md:pt-24 max-md:pl-0 max-md:pr-0 pb-6">
        <div class="bg-white p-4 md:rounded-md max-md:mt-12">
            {{ $slot }}
        </div>
    </main>
@endcan
@can('responden')
    <main
        class="bg-slate-100 w-full min-h-dvh px-6 max-md:px-0 pt-44 max-md:pt-24 pb-6
{{ request()->is('responden/evaluasi*') && !request()->is('responden/evaluasi/identitas-responden*') ? 'pb-24' : false }}">
        <div {{ $attributes->merge(['class' => 'bg-white p-4 md:rounded-md max-md:mt-12']) }}>
            {{ $slot }}
        </div>
    </main>
@endcan
