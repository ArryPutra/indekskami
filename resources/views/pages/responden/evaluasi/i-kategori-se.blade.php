@extends('layouts.layout')

@section('content')
    <h1 class="font-bold text-2xl">Bagian I: Kategori Sistem Elektronik</h1>
    <p>Bagian ini mengevaluasi tingkat atau kategori sistem elektronik yang digunakan</p>

    <x-table class="mt-4">
        <x-table.thead>
            <x-table.th>#</x-table.th>
            <x-table.th>Pertanyaan</x-table.th>
            <x-table.th>Skor</x-table.th>
            <x-table.th>Dokumen</x-table.th>
            <x-table.th>Keterangan</x-table.th>
        </x-table.thead>
        <x-table.tbody colspan="7">
            <x-table.tr>
                <x-table.td>1.1</x-table.td>
                <x-table.td>
                    <x-radio label="Nilai investasi sistem elektronik yang terpasang">
                        <x-radio.option name="pertanyaan-1" value="a">A. Lebih dari Rp.30 Miliar</x-radio.option>
                        <x-radio.option name="pertanyaan-1" value="b">B. Lebih dari Rp.3 Miliar s/d Rp.30 Miliar
                        </x-radio.option>
                        <x-radio.option name="pertanyaan-1" value="c">C. Kurang dari Rp.3 Miliar</x-radio.option>
                    </x-radio>
                </x-table.td>
                <x-table.td>1</x-table.td>
                <x-table.td>1.1</x-table.td>
                <x-table.td>1.1</x-table.td>
            </x-table.tr>
        </x-table.tbody>
    </x-table>
@endsection
