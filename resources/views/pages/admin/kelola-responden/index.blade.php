@extends('layouts.layout')

@section('content')
    <form method="GET" action="{{ route('kelola-responden.index') }}">
        <section class="flex justify-between flex-wrap gap-4 mb-4">
            <div class="flex gap-3 w-full">
                <x-textfield value="{{ request('cari') }}" type="text" name="cari" placeholder="Cari responden" />
                <x-button type="submit">
                    <span>Cari</span>
                </x-button>
            </div>
            <x-button href="{{ route('kelola-responden.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Responden
            </x-button>
        </section>
        @if (session('success'))
            <x-alert class="mb-4" type="success" isClosed="true">
                {!! session('success') !!}
            </x-alert>
        @endif
        <div class="flex gap-4 mb-4 flex-wrap">
            <div>
                <x-dropdown name="daerah" onchange="this.form.submit()" label="Daerah">
                    <x-dropdown.option value="semua">Semua</x-dropdown.option>
                    <x-dropdown.option :selected="request('daerah') == 'kabupaten-atau-kota'" value="kabupaten-atau-kota">Kabupaten/Kota</x-dropdown.option>
                    <x-dropdown.option :selected="request('daerah') == 'provinsi'" value="provinsi">Provinsi</x-dropdown.option>
                </x-dropdown>
            </div>
            <div>
                <x-dropdown name="akses-evaluasi" onchange="this.form.submit()" label="Akses Evaluasi">
                    <x-dropdown.option value="semua">Semua</x-dropdown.option>
                    <x-dropdown.option value="true" :selected="request('akses-evaluasi') == 'true'">Aktif</x-dropdown.option>
                    <x-dropdown.option value="false" :selected="request('akses-evaluasi') == 'false'">Nonaktif</x-dropdown.option>
                </x-dropdown>
            </div>
            <div>
                <x-dropdown name="akses-akun" onchange="this.form.submit()" label="Akses Akun">
                    <x-dropdown.option value="semua">Semua</x-dropdown.option>
                    <x-dropdown.option value="true" :selected="request('akses-akun') == 'true'">Aktif</x-dropdown.option>
                    <x-dropdown.option value="false" :selected="request('akses-akun') == 'false'">Nonaktif</x-dropdown.option>
                </x-dropdown>
            </div>
        </div>
    </form>

    {{-- TABLE --}}
    <x-table>
        <x-table.thead>
            <x-table.th>No</x-table.th>
            <x-table.th>Nama Instansi</x-table.th>
            <x-table.th>Username</x-table.th>
            <x-table.th>Email</x-table.th>
            <x-table.th>Nomor Telepon</x-table.th>
            <x-table.th>Daerah</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody colspan="7">
            @if (count($daftarResponden) > 0)
                @foreach ($daftarResponden as $index => $responden)
                    <x-table.tr>
                        <x-table.td>{{ ($daftarResponden->currentPage() - 1) * $daftarResponden->perPage() + $index + 1 }}</x-table.td>
                        <x-table.td class="font-semibold">{{ $responden->nama }}</x-table.td>
                        <x-table.td>{{ $responden->username }}</x-table.td>
                        <x-table.td>{{ $responden->email }}</x-table.td>
                        <x-table.td>{{ $responden->nomor_telepon }}</x-table.td>
                        <x-table.td>{{ $responden->responden->daerah }}</x-table.td>
                        <x-table.td>
                            <div class="flex gap-2 flex-wrap">
                                <x-button href="{{ route('kelola-responden.show', $responden->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                    </svg>
                                    Detail
                                </x-button>
                                <x-button href="{{ route('kelola-responden.edit', $responden->id) }}" color="blue">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    Edit
                                </x-button>
                                @if ($responden->akses_akun == true)
                                    <form id="formNonaktifkanResponden-{{ $responden->id }}"
                                        action="{{ route('kelola-responden.destroy', $responden->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="akses_akun" value="false">
                                        <x-button type="submit" color="red"
                                            onclick="nonaktifResponden('{{ $responden->nama }}', {{ $responden->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            Nonaktif
                                        </x-button>
                                    </form>
                                @else
                                    <form id="formAktifkanResponden-{{ $responden->id }}"
                                        action="{{ route('kelola-responden.destroy', $responden->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="akses_akun" value="true">
                                        <x-button type="submit" color="green"
                                            onclick="aktifResponden('{{ $responden->nama }}', {{ $responden->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                            Aktifkan
                                        </x-button>
                                    </form>
                                @endif
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            @else
                <x-table.tr>
                    <x-table.td colspan="7" class="text-center">Data kosong!</x-table.td>
                </x-table.tr>
            @endif
        </x-table.tbody>
    </x-table>

    <div class="mt-4">
        {{ $daftarResponden->links() }}
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function nonaktifResponden(nama, userId) {
            window.event.preventDefault();
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Nonaktifkan akun " + nama + '?',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "{{ config('app.primary_color') }}",
                confirmButtonText: "Nonaktifkan",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('formNonaktifkanResponden-' + userId);
                    form.submit();
                }
            });
        }

        function aktifResponden(nama, userId) {
            window.event.preventDefault();
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Aktifkan akun " + nama + '?',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "{{ config('app.primary_color') }}",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aktifkan",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('formAktifkanResponden-' + userId);
                    form.submit();
                }
            });
        }
    </script>
@endpush
