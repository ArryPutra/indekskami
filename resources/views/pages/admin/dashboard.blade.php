@extends('layouts.layout')

@section('content')
    <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-4 mb-6">
        <x-card>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M8 4a4 4 0 1 0 0 8 4 4 0 1 0 0-8M15.54 11.54c2.02-2.02 2.02-5.06 0-7.07l-1.41 1.41c1.23 1.23 1.23 3.01 0 4.24l1.41 1.41Z">
                    </path>
                    <path
                        d="m18.36 1.64-1.41 1.41c2.87 2.87 2.87 7.03 0 9.9l1.41 1.41c3.63-3.63 3.63-9.1 0-12.73ZM3 20h10c.55 0 1-.45 1-1v-1c0-2.76-2.24-5-5-5H7c-2.76 0-5 2.24-5 5v1c0 .55.45 1 1 1">
                    </path>
                </svg>
            </x-slot:icon>
            <x-slot:label>Total Admin</x-slot:label>
            <x-slot:value>{{ $dataCard['totalAdmin'] }}</x-slot:value>
        </x-card>
        <x-card>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 2a5 5 0 1 0 0 10 5 5 0 1 0 0-10M4 22h16c.55 0 1-.45 1-1v-1c0-3.86-3.14-7-7-7h-4c-3.86 0-7 3.14-7 7v1c0 .55.45 1 1 1">
                    </path>
                </svg>
            </x-slot:icon>
            <x-slot:label>Total Responden</x-slot:label>
            <x-slot:value>{{ $dataCard['totalResponden'] }}</x-slot:value>
        </x-card>
        <x-card>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M8 4a4 4 0 1 0 0 8 4 4 0 1 0 0-8M9 13H7c-2.76 0-5 2.24-5 5v1c0 .55.45 1 1 1h10c.55 0 1-.45 1-1v-1c0-2.76-2.24-5-5-5M16 12.59l-2.29-2.29-1.41 1.41 3 3c.2.2.45.29.71.29s.51-.1.71-.29l5-5-1.41-1.41-4.29 4.29Z">
                    </path>
                </svg>
            </x-slot:icon>
            <x-slot:label>Total Verifikator</x-slot:label>
            <x-slot:value>{{ $dataCard['totalVerifikator'] }}</x-slot:value>
        </x-card>
        <x-card>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M8 4a4 4 0 1 0 0 8 4 4 0 1 0 0-8M3 20h10c.55 0 1-.45 1-1v-1c0-2.76-2.24-5-5-5H7c-2.76 0-5 2.24-5 5v1c0 .55.45 1 1 1M21 11.5c0-2-1.5-3.5-3.5-3.5S14 9.5 14 11.5s1.5 3.5 3.5 3.5c.62 0 1.18-.16 1.67-.42l2.12 2.12 1.41-1.41-2.12-2.12c.26-.49.42-1.05.42-1.67M17.5 13c-.88 0-1.5-.62-1.5-1.5s.62-1.5 1.5-1.5 1.5.62 1.5 1.5-.62 1.5-1.5 1.5">
                    </path>
                </svg>
            </x-slot:icon>
            <x-slot:label>Total Manajemen</x-slot:label>
            <x-slot:value>{{ $dataCard['totalManajemen'] }}</x-slot:value>
        </x-card>
    </div>
@endsection
