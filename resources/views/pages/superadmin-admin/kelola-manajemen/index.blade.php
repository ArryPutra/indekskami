@extends('layouts.layout')

@section('content')
    <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-4 mb-8">
        {{-- Total Manajemen --}}
        <x-card>
            <x-slot:icon>
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 2a5 5 0 1 0 0 10 5 5 0 1 0 0-10M4 22h16c.55 0 1-.45 1-1v-1c0-3.86-3.14-7-7-7h-4c-3.86 0-7 3.14-7 7v1c0 .55.45 1 1 1" />
                </svg>
            </x-slot:icon>
            <x-slot:label>Total Manajemen</x-slot:label>
            <x-slot:value>{{ $daftarDataCard['totalManajemen'] }}</x-slot:value>
        </x-card>
    </div>

    <form method="GET" action="{{ route('kelola-manajemen.index') }}">
        <section class="flex justify-between flex-wrap gap-4 mb-4">
            <div class="flex gap-3 w-full">
                <x-text-field value="{{ request('cari') }}" type="text" name="cari" placeholder="Cari manajemen" />
                <x-button type="submit">
                    <span>Cari</span>
                </x-button>
                @if (request('cari') !== null)
                    <x-button type="submit" name="cari" value="" color="red">Hapus</x-button>
                @endif
            </div>
            <x-button href="{{ route('kelola-manajemen.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Manajemen
            </x-button>
        </section>

        @if (session('success'))
            <x-alert class="mb-4" type="success" isClosed="true">
                {!! session('success') !!}
            </x-alert>
        @endif

        <div class="flex gap-4 mb-4 flex-wrap">
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
            <x-table.th>Nama Manajemen</x-table.th>
            <x-table.th>Username</x-table.th>
            <x-table.th>Email</x-table.th>
            <x-table.th>Nomor Telepon</x-table.th>
            <x-table.th>Jabatan</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-table.thead>
        <x-table.tbody>
            @if (count($daftarManajemen) > 0)
                @foreach ($daftarManajemen as $index => $manajemen)
                    <x-table.tr>
                        <x-table.td>{{ ($daftarManajemen->currentPage() - 1) * $daftarManajemen->perPage() + $index + 1 }}</x-table.td>
                        <x-table.td class="font-semibold">{{ $manajemen->user->nama }}</x-table.td>
                        <x-table.td>{{ $manajemen->user->username }}</x-table.td>
                        <x-table.td>{{ $manajemen->user->email }}</x-table.td>
                        <x-table.td>{{ $manajemen->user->nomor_telepon }}</x-table.td>
                        <x-table.td>{{ $manajemen->jabatan }}</x-table.td>
                        <x-table.td>
                            <div class="flex gap-2 flex-wrap">
                                <x-button href="{{ route('kelola-manajemen.show', $manajemen->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                    </svg>
                                    Detail
                                </x-button>
                                <x-button href="{{ route('kelola-manajemen.edit', $manajemen->id) }}" color="blue">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    Edit
                                </x-button>
                                @if ($manajemen->user->apakah_akun_nonaktif == false)
                                    <form id="formNonaktifkanManajemen-{{ $manajemen->user->id }}"
                                        action="{{ route('kelola-manajemen.destroy', $manajemen->user->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="apakah_akun_nonaktif" value="true">
                                        <x-button type="submit" color="red"
                                            onclick="nonaktifManajemen('{{ $manajemen->user->nama }}', {{ $manajemen->user->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            Nonaktif
                                        </x-button>
                                    </form>
                                @else
                                    <form id="formAktifkanManajemen-{{ $manajemen->user->id }}"
                                        action="{{ route('kelola-manajemen.destroy', $manajemen->user->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="apakah_akun_nonaktif" value="false">
                                        <x-button type="submit" color="green"
                                            onclick="aktifManajemen('{{ $manajemen->user->nama }}', {{ $manajemen->user->id }})">
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
        {{ $daftarManajemen->links() }}
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function nonaktifManajemen(nama, userId) {
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
                    const form = document.getElementById('formNonaktifkanManajemen-' + userId);
                    form.submit();
                }
            });
        }

        function aktifManajemen(nama, userId) {
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
                    const form = document.getElementById('formAktifkanManajemen-' + userId);
                    form.submit();
                }
            });
        }
    </script>
@endpush
