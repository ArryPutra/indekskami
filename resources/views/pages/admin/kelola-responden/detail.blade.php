@extends('layouts.layout')

@section('content')
    <main class="space-y-3 break-words">
        <x-button.back />
        <section>
            <h1>Nama Instansi:</h1>
            <h1 class="font-bold text-lg">{{ $responden->nama }}</h1>
        </section>
        <section>
            <h1>Username:</h1>
            <h1 class="font-bold text-lg">{{ $responden->username }}</h1>
        </section>
        <section>
            <h1>Email:</h1>
            <h1 class="font-bold text-lg">{{ $responden->email }}</h1>
        </section>
        <section>
            <h1>Nomor Telepon:</h1>
            <h1 class="font-bold text-lg">{{ $responden->nomor_telepon }}</h1>
        </section>
        <section>
            <h1>Tanggal Dibuat:</h1>
            <h1 class="font-bold text-lg">{{ $responden->created_at }}</h1>
        </section>
        <section>
            <h1>Status Evaluasi:</h1>
            <h1 class="font-bold text-lg {{ $responden->responden->akses_evaluasi ? 'text-green-500' : 'text-red-500' }}">
                {{ $responden->responden->akses_evaluasi ? 'Aktif' : 'Nonaktif' }}
            </h1>
        </section>
        <section>
            <h1>Status Akun:</h1>
            <h1 class="font-bold text-lg {{ $responden->apakah_akun_nonaktif ? 'text-red-500' : 'text-green-500' }}">
                {{ $responden->apakah_akun_nonaktif ? 'Nonaktif' : 'Aktif' }}
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
                    <x-table.th>Pertanyaan</x-table.th>
                    <x-table.th>Skor</x-table.th>
                    <x-table.th>Dokumen</x-table.th>
                    <x-table.th>Keterangan</x-table.th>
                </x-table.thead>
                <x-table.tbody colspan="7">
                    <x-table.td>1</x-table.td>
                </x-table.tbody>
            </x-table>
        </section>
    </main>
@endsection
