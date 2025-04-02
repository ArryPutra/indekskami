<?php

namespace App\Http\Middleware\Responden;

use App\Models\Evaluasi\HasilEvaluasi;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KepemilikanHasilEvaluasiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $respondenId = Auth::user()->responden->id;
        $hasilEvaluasiId = $request->route('hasilEvaluasi');

        $hasilEvaluasi = HasilEvaluasi::find($hasilEvaluasiId)->first();

        if (($hasilEvaluasi->responden_id !== $respondenId) && $hasilEvaluasi !== null) {
            return abort(403, 'Anda tidak memiliki akses ke hasil evaluasi ini');
        }

        return $next($request);
    }
}
