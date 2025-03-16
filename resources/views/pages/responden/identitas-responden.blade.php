@extends('layouts.layout')

@section('content')
    <form id="formIdentitasResponden" action="{{ route('responden.identitas-responden.store') }}" method="POST"
        class="space-y-2">
        @csrf
        <x-dropdown name="identitas_instansi" label="Pilih Identitas Instansi">
            <x-dropdown.option value="Satuan Kerja" :selected="old('identitas-instansi') == 'Satuan Kerja'">Satuan kerja</x-dropdown.option>
            <x-dropdown.option value="Direktorat" :selected="old('identitas-instansi') == 'Direktorat'">Direktorat</x-dropdown.option>
            <x-dropdown.option value="Departemen" :selected="old('identitas-instansi') == 'Departemen'">Departemen</x-dropdown.option>
        </x-dropdown>
        <x-textarea name="alamat" label="Alamat" placeholder="Alamat 1, Alamat 2, Kota, Kode Pos" />
        <x-textfield name="pengisi_lembar_evaluasi" label="Pengisi Lembar Evaluasi" placeholder="Nama Staf atau Pejabat" />
        <x-textfield name="jabatan" label="Jabatan" placeholder="Jabatan Struktural/Fungsional" />
        <x-textarea name="deskripsi_ruang_lingkup" label="Deskripsi ruang lingkup"
            placeholder="Isi dengan deskripsi ruang lingkup struktur organisasi (Departemen, Bagian atau Satuan Kerja) dan infrastruktur TIK" />
        <x-button onclick="kirimIdentitasEvaluasi()" type="submit" class="w-fit mt-4">Kirim & Lanjut Evaluasi</x-button>
    </form>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function kirimIdentitasEvaluasi() {
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
