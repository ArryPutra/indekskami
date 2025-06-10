@extends('layouts.layout')

@section('content')
    <main class="space-y-3 break-words">
        <x-button.back />
        <section>
            <h1>Nama Instansi:</h1>
            <h1 class="font-bold text-lg">{{ $responden->user->nama }}</h1>
        </section>
        <section>
            <h1>Username:</h1>
            <h1 class="font-bold text-lg">{{ $responden->user->username }}</h1>
        </section>
        <section>
            <h1>Email:</h1>
            <h1 class="font-bold text-lg">{{ $responden->user->email }}</h1>
        </section>
        <section>
            <h1>Nomor Telepon:</h1>
            <h1 class="font-bold text-lg">{{ $responden->user->nomor_telepon }}</h1>
        </section>
        <section>
            <h1>Tanggal Dibuat:</h1>
            <h1 class="font-bold text-lg">{{ $responden->created_at }}</h1>
        </section>
        <section>
            <h1>Status Evaluasi:</h1>
            <h1 class="font-bold text-lg {{ $responden->akses_evaluasi ? 'text-green-500' : 'text-red-500' }}">
                {{ $responden->akses_evaluasi ? 'Aktif' : 'Nonaktif' }}
            </h1>
        </section>
        <section>
            <h1>Status Akun:</h1>
            <h1 class="font-bold text-lg {{ $responden->user->apakah_akun_nonaktif ? 'text-red-500' : 'text-green-500' }}">
                {{ $responden->user->apakah_akun_nonaktif ? 'Nonaktif' : 'Aktif' }}
            </h1>
        </section>
        <section>
            <h1>Tanggal Dibuat:</h1>
            <h1 class="font-bold text-lg">
                {{ Carbon\Carbon::parse($responden->created_at)->translatedFormat('l, d F Y, H:i:s') }}
            </h1>
        </section>
        <section>
            <h1>Tanggal Diperbarui:</h1>
            <h1 class="font-bold text-lg">
                {{ Carbon\Carbon::parse($responden->updated_at)->translatedFormat('l, d F Y, H:i:s') }}
            </h1>
        </section>
        <section>
            <h1 class="font-bold text-lg mb-3">Daftar Riwayat Evaluasi</h1>
            <x-table>
                <x-table.thead>
                    <x-table.th>No.</x-table.th>
                    <x-table.th>Verifikator</x-table.th>
                    <x-table.th>Kategori Sistem Elektronik</x-table.th>
                    <x-table.th>Hasil Evaluasi Akhir</x-table.th>
                    <x-table.th>Tingkat Kelengkapan ISO</x-table.th>
                    <x-table.th>Tanggal Mulai</x-table.th>
                    <x-table.th>Tanggal Tanggal Diserahkan</x-table.th>
                    <x-table.th>Tanggal Tanggal Diverifikasi</x-table.th>
                    <x-table.th>Aksi</x-table.th>
                </x-table.thead>
                <x-table.tbody colspan="7">
                    @if ($daftarRiwayatEvaluasi->count() > 0)
                        @foreach ($daftarRiwayatEvaluasi as $riwayatEvaluasi)
                            <x-table.tr>
                                <x-table.td>
                                    {{ $loop->iteration }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $riwayatEvaluasi->verifikator->user->nama }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $riwayatEvaluasi->nilaiEvaluasi->kategori_se }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $riwayatEvaluasi->nilaiEvaluasi->hasil_evaluasi_akhir }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $riwayatEvaluasi->nilaiEvaluasi->tingkat_kelengkapan_iso }}
                                </x-table.td>
                                <x-table.td>
                                    {{ Carbon\Carbon::parse($riwayatEvaluasi->tanggal_mulai)->translatedFormat('l, d F Y, H:i:s') }}
                                </x-table.td>
                                <x-table.td>
                                    {{ Carbon\Carbon::parse($riwayatEvaluasi->tanggal_diserahkan)->translatedFormat('l, d F Y, H:i:s') }}
                                </x-table.td>
                                <x-table.td>
                                    {{ Carbon\Carbon::parse($riwayatEvaluasi->tanggal_diverifikasi)->translatedFormat('l, d F Y, H:i:s') }}
                                </x-table.td>
                                <x-table.td>
                                    <x-button color="blue"
                                        href="{{ route('superadminadmin.evaluasi.dashboard.cetak-laporan', $riwayatEvaluasi->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="m19,7h-1V2H6v5h-1c-1.65,0-3,1.35-3,3v7c0,1.1.9,2,2,2h2v3h12v-3h2c1.1,0,2-.9,2-2v-7c0-1.65-1.35-3-3-3Zm-11-3h8v3h-8v-3Zm8,16h-8v-4h8v4Zm3-8h-4v-2h4v2Z">
                                            </path>
                                        </svg>
                                        Cetak
                                    </x-button>
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    @else
                        <x-table.tr>
                            <x-table.td colspan="9" class="text-center">
                                Tidak Ada Riwayat Evaluasi
                            </x-table.td>
                        </x-table.tr>
                    @endif
                </x-table.tbody>
            </x-table>
        </section>
    </main>
@endsection
