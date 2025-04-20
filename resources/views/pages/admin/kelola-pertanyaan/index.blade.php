@extends('layouts.layout')

@section('content')
    @if (session('error'))
        <x-alert class="mb-4" type="error" isClosed="true">
            {{ session('error') }}
        </x-alert>
    @endif
    <x-table>
        <x-table.thead>
            <x-table.th>No.</x-table.th>
            <x-table.th>Area Evaluasi</x-table.th>
            <x-table.th>Judul</x-table.th>
            <x-table.th>Deskripsi</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            @foreach ($daftarAreaEvaluasi as $areaEvaluasi)
                <x-table.tr>
                    <x-table.td>{{ $loop->iteration }}</x-table.td>
                    <x-table.td class="font-semibold">{{ $areaEvaluasi->nama_evaluasi }}</x-table.td>
                    <x-table.td>{{ $areaEvaluasi->judul }}</x-table.td>
                    <x-table.td>{{ $areaEvaluasi->deskripsi }}</x-table.td>
                    <x-table.td>
                        <x-button color="blue" href="{{ route('kelola-area-evaluasi.edit', $areaEvaluasi->id) }}">
                            Edit
                        </x-button>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>
@endsection
