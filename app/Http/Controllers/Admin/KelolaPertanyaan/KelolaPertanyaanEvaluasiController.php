<?php

namespace App\Http\Controllers\Admin\KelolaPertanyaan;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
use App\Models\Evaluasi\PertanyaanIKategoriSE;
use App\Models\Evaluasi\PertanyaanSuplemen;
use App\Models\Evaluasi\TipeEvaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KelolaPertanyaanEvaluasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areaEvaluasiId = (int) session('areaEvaluasiId');

        // Ambil query pertanyaan berdasarkan area evaluasi id
        $queryPertanyaan = match ($this->getAreaEvaluasi()->tipeEvaluasi->tipe_evaluasi) {
            TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK => PertanyaanIKategoriSE::where('area_evaluasi_id', $areaEvaluasiId),
            TipeEvaluasi::EVALUASI_UTAMA => PertanyaanEvaluasiUtama::where('area_evaluasi_id', $areaEvaluasiId),
            TipeEvaluasi::SUPLEMEN => PertanyaanSuplemen::where('area_evaluasi_id', $areaEvaluasiId),
            default => collect()
        };
        $daftarPertanyaan = collect();

        // Request cari
        if ($requestCari = request('cari')) {
            $queryPertanyaan->where(function ($query) use ($requestCari) {
                $query->where('pertanyaan', 'like', '%' . $requestCari . '%');
            });
        }

        // Request apakah tampil
        if ($requestStatusTampil = request('apakah-tampil')) {
            $apakahTampil = filter_var($requestStatusTampil, FILTER_VALIDATE_BOOLEAN);

            $daftarPertanyaan = $queryPertanyaan->where('apakah_tampil', $apakahTampil);
        } else {
            $daftarPertanyaan = $queryPertanyaan->where('apakah_tampil', true);
        }

        $daftarPertanyaan = $queryPertanyaan->orderBy('nomor')->get();

        return view('pages.admin.kelola-pertanyaan.kelola-pertanyaan-evaluasi.index', [
            'title' => 'Kelola Pertanyaan',
            'areaEvaluasiId' => $areaEvaluasiId,
            'namaAreaEvaluasi' => AreaEvaluasi::find($areaEvaluasiId)->nama_evaluasi,
            'daftarPertanyaan' => $daftarPertanyaan,
            'tipeEvaluasi' => $this->getAreaEvaluasi()->tipeEvaluasi->tipe_evaluasi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.kelola-pertanyaan.kelola-pertanyaan-evaluasi.form', [
            'title' => 'Kelola Pertanyaan',
            'tipeEvaluasi' => $this->getAreaEvaluasi()->tipeEvaluasi->tipe_evaluasi,
            'pertanyaan' => $this->getPertanyaan(),
            'pageMeta' => [
                'route' => route('kelola-pertanyaan-evaluasi.store'),
                'method' => 'POST'
            ],
            'dropdownOptions' => [
                'tingkatKematangan' => PertanyaanEvaluasiUtama::getTingkatKematanganOptions(),
                'pertanyaanTahap' => PertanyaanEvaluasiUtama::getPertanyaanTahapOptions(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tipeEvaluasiTable = match ($this->getAreaEvaluasi()->tipeEvaluasi->tipe_evaluasi) {
            TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK => 'pertanyaan_i_kategori_se',
            TipeEvaluasi::EVALUASI_UTAMA => 'pertanyaan_evaluasi_utama',
            TipeEvaluasi::SUPLEMEN => 'pertanyaan_suplemen',
            default => null
        };

        $pertanyaanBaruRequest = [
            'nomor' => [
                'required',
                'integer',
                Rule::unique($tipeEvaluasiTable, 'nomor')
                    ->where(function ($query) {
                        return $query->where('area_evaluasi_id', $this->getAreaEvaluasiId())
                            ->where('apakah_tampil', true);
                    }),
            ],
            'catatan' => ['nullable', 'string'],
            'pertanyaan' => ['required'],
            'status_pertama' => ['required', 'max:255'],
            'status_kedua' => ['required', 'max:255'],
            'status_ketiga' => ['required', 'max:255'],
            'skor_status_pertama' => ['required', 'integer'],
            'skor_status_kedua' => ['required', 'integer'],
            'skor_status_ketiga' => ['required', 'integer'],
        ];

        // Tambahkan aturan khusus jika tipe evaluasi adalah 'pertanyaan_evaluasi_utama'
        if ($tipeEvaluasiTable === 'pertanyaan_evaluasi_utama') {
            $pertanyaanBaruRequest += [
                'tingkat_kematangan' => [
                    'required',
                    'max:255',
                    Rule::in(PertanyaanEvaluasiUtama::getTingkatKematanganOptions()),
                ],
                'pertanyaan_tahap' => [
                    'required',
                    'max:255',
                    Rule::in(PertanyaanEvaluasiUtama::getPertanyaanTahapOptions()),
                ],
                'status_keempat' => ['required', 'max:255'],
                'status_kelima' => ['nullable', 'max:255'],
                'skor_status_keempat' => ['required', 'integer'],
                'skor_status_kelima' => ['nullable', 'integer'],
            ];
        }

        $request->validate($pertanyaanBaruRequest);

        $this->getPertanyaan()->create([
            'area_evaluasi_id' => $this->getAreaEvaluasiId(),
            'tingkat_kematangan' => $request->tingkat_kematangan,
            'pertanyaan_tahap' => $request->pertanyaan_tahap,
            'nomor' => $request->nomor,
            'catatan' => $request->catatan,
            'pertanyaan' => $request->pertanyaan,
            'status_pertama' => $request->status_pertama,
            'status_kedua' => $request->status_kedua,
            'status_ketiga' => $request->status_ketiga,
            'status_keempat' => $request->status_keempat,
            'status_kelima' => $request->status_kelima,
            'skor_status_pertama' => $request->skor_status_pertama,
            'skor_status_kedua' => $request->skor_status_kedua,
            'skor_status_ketiga' => $request->skor_status_ketiga,
            'skor_status_keempat' => $request->skor_status_keempat,
            'skor_status_kelima' => $request->skor_status_kelima
        ]);

        return redirect()->route('kelola-pertanyaan-evaluasi.index')->with('success', 'Pertanyaan berhasil ditambahkan');
    }

    public function edit(string $pertanyaanId)
    {
        return view('pages.admin.kelola-pertanyaan.kelola-pertanyaan-evaluasi.form', [
            'title' => 'Kelola Pertanyaan',
            'tipeEvaluasi' => $this->getAreaEvaluasi()->tipeEvaluasi->tipe_evaluasi,
            'pertanyaan' => $this->getPertanyaan($pertanyaanId),
            'pageMeta' => [
                'route' => route('kelola-pertanyaan-evaluasi.update', $pertanyaanId),
                'method' => 'PUT'
            ],
            'dropdownOptions' => [
                'tingkatKematangan' => PertanyaanEvaluasiUtama::getTingkatKematanganOptions(),
                'pertanyaanTahap' => PertanyaanEvaluasiUtama::getPertanyaanTahapOptions()
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $pertanyaanId)
    {
        $tipeEvaluasiTable = match ($this->getAreaEvaluasi()->tipeEvaluasi->tipe_evaluasi) {
            TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK => 'pertanyaan_i_kategori_se',
            TipeEvaluasi::EVALUASI_UTAMA => 'pertanyaan_evaluasi_utama',
            TipeEvaluasi::SUPLEMEN => 'pertanyaan_suplemen',
            default => null
        };

        $pertanyaanBaruRequest = [
            'nomor' => [
                'required',
                'integer',
                Rule::unique($tipeEvaluasiTable, 'nomor')
                    ->where(function ($query) {
                        return $query->where('area_evaluasi_id', $this->getAreaEvaluasiId())
                            ->where('apakah_tampil', true);
                    })
                    ->ignore($pertanyaanId),
            ],
            'catatan' => ['nullable', 'string'],
            'pertanyaan' => ['required'],
            'status_pertama' => ['required', 'max:255'],
            'status_kedua' => ['required', 'max:255'],
            'status_ketiga' => ['required', 'max:255'],
            'skor_status_pertama' => ['required', 'integer'],
            'skor_status_kedua' => ['required', 'integer'],
            'skor_status_ketiga' => ['required', 'integer'],
        ];

        // Tambahkan aturan khusus jika tipe evaluasi adalah 'pertanyaan_evaluasi_utama'
        if ($tipeEvaluasiTable === 'pertanyaan_evaluasi_utama') {
            $pertanyaanBaruRequest += [
                'tingkat_kematangan' => [
                    'required',
                    'max:255',
                    Rule::in(PertanyaanEvaluasiUtama::getTingkatKematanganOptions()),
                ],
                'pertanyaan_tahap' => [
                    'required',
                    'max:255',
                    Rule::in(PertanyaanEvaluasiUtama::getPertanyaanTahapOptions()),
                ],
                'status_keempat' => ['required', 'max:255'],
                'status_kelima' => ['nullable', 'max:255'],
                'skor_status_keempat' => ['required', 'integer'],
                'skor_status_kelima' => ['nullable', 'integer'],
            ];
        }

        $request->validate($pertanyaanBaruRequest);

        $this->getPertanyaan($pertanyaanId)->update([
            'nomor' => $request->nomor,
            'catatan' => $request->catatan ?? null,
            'tingkat_kematangan' => $request->tingkat_kematangan ?? null,
            'pertanyaan_tahap' => $request->pertanyaan_tahap ?? null,
            'pertanyaan' => $request->pertanyaan,
            'status_pertama' => $request->status_pertama,
            'status_kedua' => $request->status_kedua,
            'status_ketiga' => $request->status_ketiga,
            'status_keempat' => $request->status_keempat,
            'status_kelima' => $request->status_kelima,
            'skor_status_pertama' => $request->skor_status_pertama,
            'skor_status_kedua' => $request->skor_status_kedua,
            'skor_status_ketiga' => $request->skor_status_ketiga,
            'skor_status_keempat' => $request->skor_status_keempat,
            'skor_status_kelima' => $request->skor_status_kelima
        ]);

        return redirect()->route('kelola-pertanyaan-evaluasi.index')->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $pertanyaanId)
    {
        $apakahTampil = filter_var($request->apakah_tampil, FILTER_VALIDATE_BOOLEAN);

        $this->getPertanyaan($pertanyaanId)->update(
            [
                'apakah_tampil' => $apakahTampil
            ]
        );

        $apakahTampilMessage = $apakahTampil ? 'aktifkan' : 'nonaktifkan';

        return redirect()->route('kelola-pertanyaan-evaluasi.index')->with('success', "Pertanyaan berhasil di$apakahTampilMessage");
    }

    private function getAreaEvaluasiId()
    {
        return (int) session('areaEvaluasiId');
    }

    private function getAreaEvaluasi()
    {
        return AreaEvaluasi::find($this->getAreaEvaluasiId());
    }

    private function getPertanyaan($pertanyaanId = null)
    {
        $pertanyaan = match ($this->getAreaEvaluasi()->tipeEvaluasi->tipe_evaluasi) {
            TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK => PertanyaanIKategoriSE::find($pertanyaanId) ?? new PertanyaanIKategoriSE(),
            TipeEvaluasi::EVALUASI_UTAMA => PertanyaanEvaluasiUtama::find($pertanyaanId) ?? new PertanyaanEvaluasiUtama(),
            TipeEvaluasi::SUPLEMEN => PertanyaanSuplemen::find($pertanyaanId) ?? new PertanyaanSuplemen(),
            default => null
        };

        return $pertanyaan;
    }
}
