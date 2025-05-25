@extends('layouts.layout')

@section('content')
    <h1 class="font-bold mb-3 text-2xl">Data Pengguna</h1>
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
            <x-slot:value>10</x-slot:value>
            <x-slot:label>Total Admin</x-slot:label>
        </x-card>
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
            <x-slot:value>10</x-slot:value>
            <x-slot:label>Total Responden</x-slot:label>
        </x-card>
        <x-card>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M8 4a4 4 0 1 0 0 8 4 4 0 1 0 0-8M15.54 11.54c2.02-2.02 2.02-5.06 0-7.07l-1.41 1.41c1.23 1.23 1.23 3.01 0 4.24l1.41 1.41Z">
                    </path>
                    <path
                        d="m18.36 1.64-1.41 1.41c2.87 2.87 2.87 7.03 0 9.9l1.41 1.41c3.63-3.63 3.63-9.1 0-12.73ZM3 20h10c.55 0 1-.45 1-1v-1c0-2.76-2.24-5-5-5H7c-2.76 0-5 2.24-5 5v1c0 .55.45 1 1 1">
                    </path>
                </svg>
            </x-slot:icon>
            <x-slot:value>10</x-slot:value>
            <x-slot:label>Total Verifikator</x-slot:label>
        </x-card>
        <x-card>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M8 4a4 4 0 1 0 0 8 4 4 0 1 0 0-8M15.54 11.54c2.02-2.02 2.02-5.06 0-7.07l-1.41 1.41c1.23 1.23 1.23 3.01 0 4.24l1.41 1.41Z">
                    </path>
                    <path
                        d="m18.36 1.64-1.41 1.41c2.87 2.87 2.87 7.03 0 9.9l1.41 1.41c3.63-3.63 3.63-9.1 0-12.73ZM3 20h10c.55 0 1-.45 1-1v-1c0-2.76-2.24-5-5-5H7c-2.76 0-5 2.24-5 5v1c0 .55.45 1 1 1">
                    </path>
                </svg>
            </x-slot:icon>
            <x-slot:value>10</x-slot:value>
            <x-slot:label>Total Manajemen</x-slot:label>
        </x-card>
    </div>

    <h1 class="font-bold mb-3 text-2xl">Data Pertanyaan</h1>
    <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-4 mb-6">
        <x-card>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M8 4a4 4 0 1 0 0 8 4 4 0 1 0 0-8M15.54 11.54c2.02-2.02 2.02-5.06 0-7.07l-1.41 1.41c1.23 1.23 1.23 3.01 0 4.24l1.41 1.41Z">
                    </path>
                    <path
                        d="m18.36 1.64-1.41 1.41c2.87 2.87 2.87 7.03 0 9.9l1.41 1.41c3.63-3.63 3.63-9.1 0-12.73ZM3 20h10c.55 0 1-.45 1-1v-1c0-2.76-2.24-5-5-5H7c-2.76 0-5 2.24-5 5v1c0 .55.45 1 1 1">
                    </path>
                </svg>
            </x-slot:icon>
            <x-slot:value>10</x-slot:value>
            <x-slot:label>Total Pertanyaan</x-slot:label>
        </x-card>
    </div>
@endsection
