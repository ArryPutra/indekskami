<?php

namespace App\Http\Middleware\Responden;

use App\Models\Peran;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RespondenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->peran_id !== Peran::PERAN_RESPONDEN_ID) {
            return abort(403);
        }

        return $next($request);
    }
}