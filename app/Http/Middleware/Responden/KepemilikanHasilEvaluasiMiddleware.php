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
        $hasilEvaluasi = $request->route('hasilEvaluasi');

        abort_if($hasilEvaluasi->responden_id !== Auth::user()->responden->id, 403);

        return $next($request);
    }
}
