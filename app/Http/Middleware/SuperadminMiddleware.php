<?php

namespace App\Http\Middleware;

use App\Models\Peran;
use App\Models\Responden\Responden;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperadminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->peran_id !== Peran::PERAN_SUPERADMIN_ID) {
            return abort(403);
        }

        return $next($request);
    }
}
