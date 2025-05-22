@extends('layouts.layout')

@section('content')
    <div class="flex gap-4 flex-wrap mb-6">
        <x-button href="{{ route('verifikator.kelola-evaluasi.perlu-ditinjau') }}" color="gray">
            Perlu Ditinjau
        </x-button>
        <x-button>
            Sedang Mengerjakan
        </x-button>
        <x-button href="{{ route('verifikator.kelola-evaluasi.evaluasi-selesai') }}" color="gray">
            Evaluasi Selesai
        </x-button>
    </div>

    <x-table>
        <x-table.thead>
            <x-table.th>No.</x-table.th>
            <x-table.th>Nama Instansi</x-table.th>
            <x-table.th>Nama Pengisi Evaluasi</x-table.th>
            <x-table.th>Email</x-table.th>
            <x-table.th>Nomor Telepon</x-table.th>
            <x-table.th>Evaluasi Ke</x-table.th>
            <x-table.th>Tanggal Mulai</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            @if ($daftarHasilEvaluasi->count() > 0)
                @foreach ($daftarHasilEvaluasi as $index => $hasilEvaluasi)
                    <x-table.tr>
                        <x-table.td>{{ ($daftarHasilEvaluasi->currentPage() - 1) * $daftarHasilEvaluasi->perPage() + $index + 1 }}</x-table.td>
                        <x-table.td class="font-bold">{{ $hasilEvaluasi->responden->user->nama }}</x-table.td>
                        <x-table.td>{{ $hasilEvaluasi->identitasResponden->pengisi_lembar_evaluasi }}</x-table.td>
                        <x-table.td>{{ $hasilEvaluasi->identitasResponden->email }}</x-table.td>
                        <x-table.td>{{ $hasilEvaluasi->identitasResponden->nomor_telepon }}</x-table.td>
                        <x-table.td>{{ $hasilEvaluasi->evaluasi_ke }}</x-table.td>
                        <x-table.td>{{ Carbon\Carbon::parse($hasilEvaluasi->created_at)->translatedFormat('l, d F Y, H:i:s') }}</x-table.td>
                    </x-table.tr>
                @endforeach
            @else
                <x-table.tr>
                    <x-table.td colspan="8" class="text-center">Data kosong!</x-table.td>
                </x-table.tr>
            @endif
        </x-table.tbody>
    </x-table>
@endsection
