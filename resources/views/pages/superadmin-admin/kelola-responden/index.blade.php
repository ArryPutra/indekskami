@extends('layouts.layout')

@section('content')
    <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-4 mb-8">
        {{-- Total Responden --}}
        <x-card>
            <x-slot:icon>
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                </svg>
            </x-slot:icon>
            <x-slot:label>Total Responden</x-slot:label>
            <x-slot:value>{{ $daftarDataCard['totalResponden'] }}</x-slot:value>
        </x-card>
        {{-- Total Kabupaten/Kota --}}
        <x-card>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M4.5 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5h-.75V3.75a.75.75 0 0 0 0-1.5h-15ZM9 6a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm-.75 3.75A.75.75 0 0 1 9 9h1.5a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM9 12a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm3.75-5.25A.75.75 0 0 1 13.5 6H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM13.5 9a.75.75 0 0 0 0 1.5H15A.75.75 0 0 0 15 9h-1.5Zm-.75 3.75a.75.75 0 0 1 .75-.75H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM9 19.5v-2.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-4.5A.75.75 0 0 1 9 19.5Z"
                        clip-rule="evenodd" />
                </svg>
            </x-slot:icon>
            <x-slot:label>Total Responden dari Kabupaten/Kota</x-slot:label>
            <x-slot:value>{{ $daftarDataCard['totalKabupatenKota'] }}</x-slot:value>
        </x-card>
        {{-- Total Provinsi --}}
        <x-card>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path
                        d="M11.584 2.376a.75.75 0 0 1 .832 0l9 6a.75.75 0 1 1-.832 1.248L12 3.901 3.416 9.624a.75.75 0 0 1-.832-1.248l9-6Z" />
                    <path fill-rule="evenodd"
                        d="M20.25 10.332v9.918H21a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1 0-1.5h.75v-9.918a.75.75 0 0 1 .634-.74A49.109 49.109 0 0 1 12 9c2.59 0 5.134.202 7.616.592a.75.75 0 0 1 .634.74Zm-7.5 2.418a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Zm3-.75a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0v-6.75a.75.75 0 0 1 .75-.75ZM9 12.75a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Z"
                        clip-rule="evenodd" />
                    <path d="M12 7.875a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" />
                </svg>
            </x-slot:icon>
            <x-slot:label>Total Responden dari Provinsi</x-slot:label>
            <x-slot:value>{{ $daftarDataCard['totalProvinsi'] }}</x-slot:value>
        </x-card>
    </div>

    <form method="GET" action="{{ route('kelola-responden.index') }}">
        <section class="flex justify-between flex-wrap gap-4 mb-4">
            <div class="flex gap-3 w-full">
                <x-text-field value="{{ request('cari') }}" type="text" name="cari" placeholder="Cari responden"
                    :required=false />
                <x-button type="submit">
                    <span>Cari</span>
                </x-button>
                @if (request('cari') !== null)
                    <x-button type="submit" name="cari" value="" color="red">Hapus</x-button>
                @endif
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
            <section>
                <x-dropdown name="daerah" onchange="this.form.submit()" label="Daerah">
                    <x-dropdown.option value="semua">Semua</x-dropdown.option>
                    <x-dropdown.option :selected="request('daerah') == 'kabupaten-atau-kota'" value="kabupaten-atau-kota">Kabupaten/Kota</x-dropdown.option>
                    <x-dropdown.option :selected="request('daerah') == 'provinsi'" value="provinsi">Provinsi</x-dropdown.option>
                </x-dropdown>
            </section>
            <section>
                <x-dropdown name="akses-evaluasi" onchange="this.form.submit()" label="Akses Evaluasi">
                    <x-dropdown.option value="semua">Semua</x-dropdown.option>
                    <x-dropdown.option value="true" :selected="request('akses-evaluasi') == 'true'">Aktif</x-dropdown.option>
                    <x-dropdown.option value="false" :selected="request('akses-evaluasi') == 'false'">Nonaktif</x-dropdown.option>
                </x-dropdown>
            </section>
            <section>
                <x-dropdown name="status-akun" onchange="this.form.submit()" label="Status Akun">
                    <x-dropdown.option value="semua">Semua</x-dropdown.option>
                    <x-dropdown.option value="true" :selected="request('status-akun') == 'true'">Aktif</x-dropdown.option>
                    <x-dropdown.option value="false" :selected="request('status-akun') == 'false'">Nonaktif</x-dropdown.option>
                </x-dropdown>
            </section>
        </div>
    </form>

    {{-- TABLE --}}
    <x-table>
        <x-table.thead>
            <x-table.th>No.</x-table.th>
            <x-table.th>Nama Instansi</x-table.th>
            <x-table.th>Username</x-table.th>
            <x-table.th>Email</x-table.th>
            <x-table.th>Nomor Telepon</x-table.th>
            <x-table.th>Daerah</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            @if (count($daftarResponden) > 0)
                @foreach ($daftarResponden as $index => $responden)
                    <x-table.tr>
                        <x-table.td>{{ ($daftarResponden->currentPage() - 1) * $daftarResponden->perPage() + $index + 1 }}</x-table.td>
                        <x-table.td class="font-semibold">{{ $responden->user->nama }}</x-table.td>
                        <x-table.td>{{ $responden->user->username }}</x-table.td>
                        <x-table.td>{{ $responden->user->email }}</x-table.td>
                        <x-table.td>{{ $responden->user->nomor_telepon }}</x-table.td>
                        <x-table.td>{{ $responden->user->responden->daerah }}</x-table.td>
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
                                @if ($responden->user->apakah_akun_nonaktif == false)
                                    <form id="formNonaktifkanResponden-{{ $responden->user->id }}"
                                        action="{{ route('kelola-responden.destroy', $responden->user->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="apakah_akun_nonaktif" value="true">
                                        <x-button type="submit" color="red"
                                            onclick="nonaktifResponden('{{ $responden->user->nama }}', {{ $responden->user->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            Nonaktif
                                        </x-button>
                                    </form>
                                @else
                                    <form id="formAktifkanResponden-{{ $responden->user->id }}"
                                        action="{{ route('kelola-responden.destroy', $responden->user->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="apakah_akun_nonaktif" value="false">
                                        <x-button type="submit" color="green"
                                            onclick="aktifResponden('{{ $responden->user->nama }}', {{ $responden->user->id }})">
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
