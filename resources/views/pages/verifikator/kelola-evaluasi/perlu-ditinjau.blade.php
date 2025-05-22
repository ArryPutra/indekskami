@extends('layouts.layout')

@section('content')
    <div class="flex gap-4 flex-wrap mb-6">
        <x-button>
            Perlu Ditinjau
        </x-button>
        <x-button href="{{ route('verifikator.kelola-evaluasi.sedang-mengerjakan') }}" color="gray">
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
            <x-table.th>Pengisi Lembar Evaluasi</x-table.th>
            <x-table.th>Kategori Sistem Elektronik</x-table.th>
            <x-table.th>Hasil Evaluasi Akhir</x-table.th>
            <x-table.th>Evaluasi Ke</x-table.th>
            <x-table.th>Tanggal Mulai</x-table.th>
            <x-table.th>Tanggal Diserahkan</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            @if ($daftarHasilEvaluasi->count() > 0)
                @foreach ($daftarHasilEvaluasi as $index => $hasilEvaluasi)
                    <x-table.tr>
                        <x-table.td>{{ ($daftarHasilEvaluasi->currentPage() - 1) * $daftarHasilEvaluasi->perPage() + $index + 1 }}</x-table.td>
                        <x-table.td class="font-bold">{{ $hasilEvaluasi->responden->user->nama }}</x-table.td>
                        <x-table.td>{{ $hasilEvaluasi->identitasResponden->pengisi_lembar_evaluasi }}</x-table.td>
                        <x-table.td>{{ $hasilEvaluasi->nilaiEvaluasi->kategori_se }}</x-table.td>
                        <x-table.td>{{ $hasilEvaluasi->nilaiEvaluasi->hasil_evaluasi_akhir }}</x-table.td>
                        <x-table.td>{{ $hasilEvaluasi->evaluasi_ke }}</x-table.td>
                        <x-table.td>{{ Carbon\Carbon::parse($hasilEvaluasi->created_at)->translatedFormat('l, d F Y, H:i:s') }}</x-table.td>
                        <x-table.td>{{ Carbon\Carbon::parse($hasilEvaluasi->tanggal_mulai)->translatedFormat('l, d F Y, H:i:s') }}</x-table.td>
                        <x-table.td>
                            <div class="flex gap-2">
                                <x-button class="w-fit"
                                    href="{{ route('verifikator.evaluasi.pertanyaan', [1, $hasilEvaluasi->id]) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M14.71 2.29A1 1 0 0 0 14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8c0-.27-.11-.52-.29-.71zM7 7h4v2H7zm10 10H7v-2h10zm0-4H7v-2h10zm-4-4V3.5L18.5 9z">
                                        </path>
                                    </svg>
                                    Detail
                                </x-button>
                                <x-button
                                    href="{{ route('verifikator.evaluasi.dashboard.cetak-laporan', $hasilEvaluasi->id) }}"
                                    color="blue" class="w-fit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-6">
                                        <path fill-rule="evenodd"
                                            d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Cetak
                                </x-button>
                            </div>
                        </x-table.td>
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
