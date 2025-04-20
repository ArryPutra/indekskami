@extends('layouts.layout')

@section('content')
    <div class="flex gap-4 flex-wrap mb-6">
        <x-button color="gray" href="{{ route('admin-verifikator.kelola-evaluasi.verifikasi') }}">Verifikasi</x-button>
        <x-button color="gray" href="{{ route('admin-verifikator.kelola-evaluasi.mengerjakan') }}">Mengerjakan</x-button>
        <x-button>Selesai</x-button>
    </div>

    <x-table>
        <x-table.thead>
            <x-table.th>No.</x-table.th>
        </x-table.thead>
    </x-table>
@endsection
