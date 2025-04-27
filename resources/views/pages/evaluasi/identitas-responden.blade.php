@extends('layouts.layout')

@section('content')
    <form id="formIdentitasResponden" action="{{ $pageMeta['route'] }}" method="POST" class="space-y-2">
        @csrf
        @method($pageMeta['method'])
        @if (session('success'))
            <x-alert class="mb-4" type="success" isClosed="true">
                {!! session('success') !!}
            </x-alert>
        @endif
        <x-dropdown name="identitas_instansi" label="Pilih Identitas Instansi">
            <x-dropdown.option value="Satuan Kerja" :selected="old('identitas-instansi', $identitasResponden->identitas_instansi) == 'Satuan Kerja'">Satuan kerja</x-dropdown.option>
            <x-dropdown.option value="Direktorat" :selected="old('identitas-instansi', $identitasResponden->identitas_instansi) == 'Direktorat'">Direktorat</x-dropdown.option>
            <x-dropdown.option value="Departemen" :selected="old('identitas-instansi', $identitasResponden->identitas_instansi) == 'Departemen'">Departemen</x-dropdown.option>
        </x-dropdown>
        <x-text-area name="alamat" label="Alamat" placeholder="Alamat 1, Alamat 2, Kota, Kode Pos"
            value="{{ old('alamat', $identitasResponden->alamat) }}" />
        <x-text-field name="nomor_telepon" label="Nomor Telepon" placeholder="(Kode Area) Nomor Telpon"
            value="{{ old('nomor_telepon', $identitasResponden->nomor_telepon) }}" />
        <x-text-field name="email" label="Email" placeholder="user@departemen_responden.go.id"
            value="{{ old('email', $identitasResponden->email) }}" />
        <x-text-field name="pengisi_lembar_evaluasi" label="Pengisi Lembar Evaluasi" placeholder="Nama Staf atau Pejabat"
            value="{{ old('pengisi_lembar_evaluasi', $identitasResponden->pengisi_lembar_evaluasi) }}" />
        <x-text-field name="jabatan" label="Jabatan" placeholder="Jabatan Struktural/Fungsional"
            value="{{ old('jabatan', $identitasResponden->jabatan) }}" />
        <x-text-area name="deskripsi_ruang_lingkup" label="Deskripsi ruang lingkup"
            placeholder="Isi dengan deskripsi ruang lingkup struktur organisasi (Departemen, Bagian atau Satuan Kerja) dan infrastruktur TIK"
            value="{{ old('deskripsi_ruang_lingkup', $identitasResponden->deskripsi_ruang_lingkup) }}" />
        @if ($pageMeta['method'] == 'POST')
            <x-button onclick="pesanKirimIdentitas()" type="submit" class="w-fit mt-4">
                {{ $pageMeta['method'] == 'POST' ? 'Kirim & Lanjut Evaluasi' : 'Perbarui Identitas' }}
            </x-button>
        @else
            <x-button type="submit" class="w-fit mt-4">
                {{ $pageMeta['method'] == 'POST' ? 'Kirim & Lanjut Evaluasi' : 'Perbarui Identitas' }}
            </x-button>
        @endif

    </form>
    {{-- Daftar Area Evaluasi --}}
    @if (request()->is('responden/evaluasi/identitas-responden/*/edit'))
        <footer
            class="
fixed bottom-0 left-0 w-full
bg-white px-6 max-md:px-4 py-4 border-t border-gray-200 flex gap-2 overflow-x-auto">
            <x-button>Identitas</x-button>
            @foreach ($daftarAreaEvaluasiUtama as $areaEvaluasiUtama)
                <x-button href="{{ route('responden.evaluasi.pertanyaan', [$areaEvaluasiUtama->id, $hasilEvaluasi->id]) }}"
                    color="gray">
                    {{ $areaEvaluasiUtama->nama_evaluasi }}
                </x-button>
            @endforeach
            <x-button color="gray"
                href="{{ route('responden.evaluasi.dashboard', $hasilEvaluasi->id) }}">Dashboard</x-button>
        </footer>
    @endif
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function pesanKirimIdentitas() {
            window.event.preventDefault();
            Swal.fire({
                title: "Apakah Data Sudah Benar?",
                text: "Setelah mengirim, Anda akan diarahkan untuk melakukan evaluasi",
                icon: "question",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "{{ config('app.primary_color') }}",
                confirmButtonText: "Kirim",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('formIdentitasResponden');
                    form.submit();
                }
            });
        }
    </script>
@endpush
