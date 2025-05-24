<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi\AreaEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasi;
use App\Models\Evaluasi\PertanyaanEvaluasiUtama;
use App\Models\Evaluasi\PertanyaanIKategoriSE;
use App\Models\Evaluasi\PertanyaanKategoriSe;
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

        $areaEvaluasi = $this->getAreaEvaluasi()->load('tipeEvaluasi');

        // Ambil query pertanyaan berdasarkan area evaluasi id
        $queryPertanyaan = PertanyaanEvaluasi::where('area_evaluasi_id', $areaEvaluasiId);

        switch ($areaEvaluasi->tipeEvaluasi->nama_tipe_evaluasi) {
            case TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK:
                $queryPertanyaan = $queryPertanyaan->with('pertanyaanKategoriSe');
                break;
            case TipeEvaluasi::EVALUASI_UTAMA:
                $queryPertanyaan = $queryPertanyaan->with('pertanyaanEvaluasiUtama');
                break;
            case TipeEvaluasi::SUPLEMEN:
                $queryPertanyaan = $queryPertanyaan->with('pertanyaanSuplemen');
                break;
        }
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

        return view('pages.superadmin.kelola-pertanyaan.kelola-pertanyaan-evaluasi.index', [
            'title' => 'Kelola Pertanyaan',
            'areaEvaluasiId' => $areaEvaluasiId,
            'namaTipeEvaluasi' => $areaEvaluasi->tipeEvaluasi->nama_tipe_evaluasi,
            'namaAreaEvaluasi' => $areaEvaluasi->nama_area_evaluasi,
            'daftarPertanyaan' => $daftarPertanyaan,
            'isEvaluasiUtama' => $areaEvaluasi->tipeEvaluasi->nama_tipe_evaluasi === TipeEvaluasi::EVALUASI_UTAMA
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.superadmin.kelola-pertanyaan.kelola-pertanyaan-evaluasi.form', [
            'title' => 'Kelola Pertanyaan',
            'namaTipeEvaluasi' => $this->getAreaEvaluasi()->tipeEvaluasi->nama_tipe_evaluasi,
            'pertanyaanEvaluasi' => new PertanyaanEvaluasi(),
            'pertanyaanRelasi' => $this->getPertanyaanRelasi(),
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
        $pertanyaanBaruRequest = [
            'nomor' => [
                'required',
                'integer',
                Rule::unique('pertanyaan_evaluasi', 'nomor')
                    ->where('area_evaluasi_id', $this->getAreaEvaluasiId())
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
        if ($this->getAreaEvaluasi()->tipeEvaluasi->nama_tipe_evaluasi === TipeEvaluasi::EVALUASI_UTAMA) {
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
                'status_kelima' => ['required_with:skor_status_kelima', 'nullable', 'max:255'],
                'skor_status_keempat' => ['required', 'integer'],
                'skor_status_kelima' => ['required_with:status_kelima', 'nullable', 'integer'],

            ];
        } else if ($this->getAreaEvaluasi()->tipeEvaluasi->nama_tipe_evaluasi === TipeEvaluasi::SUPLEMEN) {
            $pertanyaanBaruRequest += [
                'status_keempat' => ['required', 'max:255'],
                'skor_status_keempat' => ['required', 'integer'],

            ];
        }

        $request->validate($pertanyaanBaruRequest);

        $pertanyaanEvaluasi = PertanyaanEvaluasi::create([
            'area_evaluasi_id' => $this->getAreaEvaluasiId(),
            'tingkat_kematangan' => $request->tingkat_kematangan,
            'nomor' => $request->nomor,
            'catatan' => $request->catatan,
            'pertanyaan' => $request->pertanyaan,
        ]);

        $this->getPertanyaanRelasi()->create([
            'pertanyaan_evaluasi_id' => $pertanyaanEvaluasi->id,
            'tingkat_kematangan' => $request->tingkat_kematangan,
            'pertanyaan_tahap' => $request->pertanyaan_tahap,
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

    public function edit(string $pertanyaanEvaluasiId)
    {
        return view('pages.superadmin.kelola-pertanyaan.kelola-pertanyaan-evaluasi.form', [
            'title' => 'Kelola Pertanyaan',
            'namaTipeEvaluasi' => $this->getAreaEvaluasi()->tipeEvaluasi->nama_tipe_evaluasi,
            'pertanyaanEvaluasi' => PertanyaanEvaluasi::find($pertanyaanEvaluasiId),
            'pertanyaanRelasi' => $this->getPertanyaanRelasi($pertanyaanEvaluasiId),
            'pageMeta' => [
                'route' => route('kelola-pertanyaan-evaluasi.update', $pertanyaanEvaluasiId),
                'method' => 'PUT'
            ],
            'dropdownOptions' => [
                'tingkatKematangan' => PertanyaanEvaluasiUtama::getTingkatKematanganOptions(),
                'pertanyaanTahap' => PertanyaanEvaluasiUtama::getPertanyaanTahapOptions()
            ]
        ]);
    }

    public function update(Request $request, string $pertanyaanEvaluasiId)
    {
        $pertanyaanBaruRequest = [
            'nomor' => [
                'required',
                'integer',
                Rule::unique('pertanyaan_evaluasi', 'nomor')
                    ->where('area_evaluasi_id', $this->getAreaEvaluasiId())
                    ->where(function ($query) {
                        return $query->where('area_evaluasi_id', $this->getAreaEvaluasiId())
                            ->where('apakah_tampil', true);
                    })
                    ->ignore($pertanyaanEvaluasiId),
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
        if ($this->getAreaEvaluasi()->tipeEvaluasi->nama_tipe_evaluasi === TipeEvaluasi::EVALUASI_UTAMA) {
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
                'status_kelima' => ['required_with:skor_status_kelima', 'nullable', 'max:255'],
                'skor_status_keempat' => ['required', 'integer'],
                'skor_status_kelima' => ['required_with:status_kelima', 'nullable', 'integer'],

            ];
        } else if ($this->getAreaEvaluasi()->tipeEvaluasi->nama_tipe_evaluasi === TipeEvaluasi::SUPLEMEN) {
            $pertanyaanBaruRequest += [
                'status_keempat' => ['required', 'max:255'],
                'skor_status_keempat' => ['required', 'integer'],

            ];
        }

        $request->validate($pertanyaanBaruRequest);

        PertanyaanEvaluasi::find($pertanyaanEvaluasiId)->update([
            'area_evaluasi_id' => $this->getAreaEvaluasiId(),
            'tingkat_kematangan' => $request->tingkat_kematangan,
            'nomor' => $request->nomor,
            'catatan' => $request->catatan,
            'pertanyaan' => $request->pertanyaan,
        ]);

        $this->getPertanyaanRelasi($pertanyaanEvaluasiId)->update([
            'pertanyaan_evaluasi_id' => $pertanyaanEvaluasiId,
            'tingkat_kematangan' => $request->tingkat_kematangan,
            'pertanyaan_tahap' => $request->pertanyaan_tahap,
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
    public function destroy(Request $request, string $pertanyaanEvaluasiId)
    {
        $apakahTampil = filter_var($request->apakah_tampil, FILTER_VALIDATE_BOOLEAN);

        PertanyaanEvaluasi::find($pertanyaanEvaluasiId)->update(
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

    private function getPertanyaanRelasi($pertanyaanEvaluasiId = null)
    {
        switch ($this->getAreaEvaluasi()->tipeEvaluasi->nama_tipe_evaluasi) {
            case TipeEvaluasi::KATEGORI_SISTEM_ELEKTRONIK:
                return PertanyaanKategoriSe::where('pertanyaan_evaluasi_id', $pertanyaanEvaluasiId)->first()
                    ?? new PertanyaanKategoriSe();
            case TipeEvaluasi::EVALUASI_UTAMA:
                return PertanyaanEvaluasiUtama::where('pertanyaan_evaluasi_id', $pertanyaanEvaluasiId)->first()
                    ?? new PertanyaanEvaluasiUtama();
            case TipeEvaluasi::SUPLEMEN:
                return PertanyaanSuplemen::where('pertanyaan_evaluasi_id', $pertanyaanEvaluasiId)->first()
                    ?? new PertanyaanSuplemen();
        }
    }
}
