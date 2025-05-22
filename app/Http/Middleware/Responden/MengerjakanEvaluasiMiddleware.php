<?php

namespace App\Http\Middleware\Responden;

use App\Models\Responden\Responden;
use App\Models\Responden\StatusProgresEvaluasiResponden;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MengerjakanEvaluasiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $responden = Auth::user()->responden;

        if (!$responden) {
            return abort(403);
        } else if (
            $responden->statusProgresEvaluasiResponden->id
            !== StatusProgresEvaluasiResponden::SEDANG_MENGERJAKAN_ID
        ) {
            return redirect()->route('responden.redirect-evaluasi');
        }

        return $next($request);
    }
}
