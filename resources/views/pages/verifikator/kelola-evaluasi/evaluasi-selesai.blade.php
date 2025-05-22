@extends('layouts.layout')

@section('content')
    <div class="flex gap-4 flex-wrap mb-6">
        <x-button color="gray" href="{{ route('verifikator.kelola-evaluasi.perlu-ditinjau') }}">Perlu Ditinjau</x-button>
        <x-button color="gray" href="{{ route('verifikator.kelola-evaluasi.sedang-mengerjakan') }}">
            Sedang Mengerjakan
        </x-button>
        <x-button>Evaluasi Selesai</x-button>
    </div>

    <x-table>
        <x-table.thead>
            <x-table.th>No.</x-table.th>
            <x-table.th>Nama Instansi</x-table.th>
            <x-table.th>Verifikator</x-table.th>
            <x-table.th>Evaluasi Ke</x-table.th>
            <x-table.th>Tanggal Mulai</x-table.th>
            <x-table.th>Tanggal Diserahkan</x-table.th>
            <x-table.th>Tanggal Diverifikasi</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            <x-table.tr>
                <x-table.td colspan="8" class="text-center">Data kosong!</x-table.td>
            </x-table.tr>
        </x-table.tbody>
    </x-table>
@endsection
