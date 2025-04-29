<?php

namespace App\Http\Controllers\Evaluasi;

use App\Http\Controllers\Controller;
use App\Models\KepemilikanDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukaDokumenController extends Controller
{
    public function index($path)
    {
        $user = Auth::user();
        $responden = $user->responden;
        $fileDatabase = KepemilikanDokumen::where('path', $path)->first() ?? abort(404);
        $fileDatabaseRespondenId = $fileDatabase->responden_id;

        // Jika file tersebut milik responden yang sah atau
        // Jika user bukan peran responden
        if (($responden && $fileDatabaseRespondenId === $responden->id) || $user->peran_id !== 3) {
            // Menampilkan file
            return response()->file(storage_path("app/private/$path"));
        } else {
            abort(403);
        }
    }
}
