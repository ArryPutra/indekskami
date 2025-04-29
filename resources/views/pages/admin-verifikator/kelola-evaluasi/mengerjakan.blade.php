@extends('layouts.layout')

@section('content')
    <div class="flex gap-4 flex-wrap mb-6">
        <x-button color="gray" href="{{ route('admin-verifikator.kelola-evaluasi.verifikasi') }}">Verifikasi</x-button>
        <x-button>Mengerjakan</x-button>
        <x-button color="gray" href="{{ route('admin-verifikator.kelola-evaluasi.selesai') }}">Selesai</x-button>
    </div>

    <x-table>
        <x-table.thead>
            <x-table.th>No.</x-table.th>
            <x-table.th>Nama Instansi</x-table.th>
            <x-table.th>Nama Pengisi Evaluasi</x-table.th>
            <x-table.th>Email</x-table.th>
            <x-table.th>Nomor Telepon</x-table.th>
            <x-table.th>Tanggal Mulai</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            @foreach ($daftarHasilEvaluasi as $index => $hasilEvaluasi)
                <x-table.tr>
                    <x-table.td>{{ ($daftarHasilEvaluasi->currentPage() - 1) * $daftarHasilEvaluasi->perPage() + $index + 1 }}</x-table.td>
                    <x-table.td class="font-bold">
                        <a class="hover:underline hover:text-blue-500"
                            href="{{ route('kelola-responden.show', $hasilEvaluasi->responden->user->id) }}">{{ $hasilEvaluasi->responden->user->nama }}</a>
                    </x-table.td>
                    <x-table.td>{{ $hasilEvaluasi->identitasResponden->pengisi_lembar_evaluasi }}</x-table.td>
                    <x-table.td>{{ $hasilEvaluasi->identitasResponden->email }}</x-table.td>
                    <x-table.td>{{ $hasilEvaluasi->identitasResponden->nomor_telepon }}</x-table.td>
                    <x-table.td>{{ Carbon\Carbon::parse($hasilEvaluasi->created_at)->translatedFormat('l, d F Y, H:i:s') }}</x-table.td>
                    <x-table.td>
                        <x-button>Detail</x-button>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>
@endsection
