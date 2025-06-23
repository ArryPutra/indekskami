@extends('layouts.layout')

@section('content')
    <h1 class="mb-4 text-xl">Halo, <b>{{ auth()->user()->nama }}</b></h1>

    <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-4 mb-6">
        <x-card href="{{ route('responden.riwayat') }}">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                        clip-rule="evenodd" />
                    <path fill-rule="evenodd"
                        d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z"
                        clip-rule="evenodd" />
                </svg>
            </x-slot:icon>
            <x-slot:label>Total Evaluasi Dikerjakan</x-slot:label>
            <x-slot:value>{{ $dataCard['totalEvaluasiDikerjakan'] }}</x-slot:value>
        </x-card>
    </div>

    @switch($statusProgresEvaluasiResponden)
        @case(App\Models\Responden\StatusProgresEvaluasiResponden::TIDAK_MENGERJAKAN)
            <div class="p-3 pr-8 border border-gray-200 rounded-lg flex max-md:flex-col gap-3">
                <img class="h-44 w-fit" src="{{ asset('images/ilustrasi/mulai-evaluasi.png') }}"
                    alt="Gambar Mulai Evaluasi Ilustrasi">
                <div class="flex flex-col justify-between w-full gap-3">
                    <div class="w-full flex flex-col justify-between">
                        <h1 class="text-xl font-semibold mb-1">Mulai Mengerjakan Evaluasi</h1>
                        <h1>Mulai mengerjakan evaluasi dengan mengisi identitas responden terlebih dahulu.</h1>
                    </div>
                    <x-button href="{{ route('responden.redirect-evaluasi') }}" class="w-fit">
                        Mulai Evaluasi
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </x-button>
                </div>
            </div>
        @break

        @case(App\Models\Responden\StatusProgresEvaluasiResponden::SEDANG_MENGERJAKAN)
            <div class="p-3 pr-8 border border-gray-200 rounded-lg flex max-md:flex-col gap-3">
                <img class="h-44 w-fit" src="{{ asset('images/ilustrasi/evaluasi.png') }}" alt="Gambar Evaluasi Ilustrasi">
                <div class="flex flex-col w-full justify-between gap-3">
                    <div class="w-full flex flex-col justify-between">
                        <h1 class="text-xl font-semibold mb-2">Progres Evaluasi Terjawab</h1>
                        <div class="w-full h-9 bg-gray-100 border border-gray-300 rounded-md overflow-hidden mb-2">
                            <div x-cloak x-data="{ width: 0 }" x-init="setTimeout(() => {
                                width = {{ $progresEvaluasiTerjawab['persen'] }};
                            }, 150)"
                                class="bg-primary h-full duration-[2s] ease-in-out" :style="`width: ${width}%;`">
                            </div>
                        </div>
                        <h1 class="mb-3 bg-white">{!! $progresEvaluasiTerjawab['label'] !!}</h1>
                    </div>
                    <x-button href="{{ route('responden.redirect-evaluasi') }}" class="w-fit">
                        Lanjut Evaluasi
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </x-button>
                </div>
            </div>
        @break

        @case(App\Models\Responden\StatusProgresEvaluasiResponden::SELESAI_MENGERJAKAN)
            <div class="p-3 pr-8 border border-gray-200 rounded-lg flex max-md:flex-col gap-3">
                <img class="h-44 w-fit" src="{{ asset('images/ilustrasi/tinjau-evaluasi.png') }}" alt="Gambar Evaluasi Ilustrasi">
                <div class="w-full flex flex-col justify-between gap-3">
                    <div>
                        <h1 class="text-xl font-semibold mb-1">Evaluasi Anda Sedang Ditinjau</h1>
                        <p>
                            Saat ini, evaluasi Anda sedang dalam proses peninjauan oleh tim kami. Proses ini bertujuan untuk
                            memastikan bahwa semua informasi telah diverifikasi dan sesuai dengan ketentuan yang berlaku.
                        </p>
                    </div>
                    <x-button href="{{ route('responden.evaluasi.dashboard', $hasilEvaluasiDitinjau->id) }}" class="w-fit">
                        Detail Evaluasi
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </x-button>
                </div>
            @break
        @endswitch
    @endsection
