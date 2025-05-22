<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Responden\JawabanEvaluasi;
use App\Models\KepemilikanDokumen;
use App\Models\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukaDokumenController extends Controller
{
    public function index($path)
    {
        $user = Auth::user();
        $responden = $user->responden;

        $dokumenRespondenId = JawabanEvaluasi::where('bukti_dokumen', $path)->first()->responden_id
            ?? abort(404);

        // Jika file tersebut milik responden yang sah 
        // atau jika user bukan peran responden
        if (
            ($responden && $dokumenRespondenId === $responden->id)
            ||
            $user->peran_id !== Peran::PERAN_RESPONDEN_ID
        ) {
            // Menampilkan file
            return response()->file(storage_path("app/private/$path"));
        } else {
            abort(403);
        }
    }
}
