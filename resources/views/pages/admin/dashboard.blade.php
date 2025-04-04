@extends('layouts.layout')

@section('content')
    <div class="md:grid lg:grid-cols-3 md:grid-cols-2 gap-4 flex flex-col">
        <x-card>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path
                        d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z">
                    </path>
                </svg>
            </x-slot:icon>
            <x-slot:label>Total Responden</x-slot:label>
            <x-slot:value>{{ $totalResponden }}</x-slot:value>
        </x-card>
    </div>
@endsection
