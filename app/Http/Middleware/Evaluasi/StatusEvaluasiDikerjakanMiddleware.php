<?php

namespace App\Http\Middleware\Evaluasi;

use App\Models\Responden\StatusHasilEvaluasi;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusEvaluasiDikerjakanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hasilEvaluasi = $request->route('hasilEvaluasi');

        $statusHasilEvaluasiId = $hasilEvaluasi->statusHasilEvaluasi->id ?? 1;
        abort_if($statusHasilEvaluasiId !== StatusHasilEvaluasi::STATUS_DIKERJAKAN_ID, 403);

        return $next($request);
    }
}
