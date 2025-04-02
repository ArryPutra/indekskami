<?php

namespace App\Http\Middleware\Responden;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AktifEvaluasiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $aksesEvaluasi = Auth::user()->responden->akses_evaluasi;

        if (!$aksesEvaluasi) {
            return abort(403);
        }

        return $next($request);
    }
}
