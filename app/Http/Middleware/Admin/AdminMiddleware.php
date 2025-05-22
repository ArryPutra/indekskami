<?php

namespace App\Http\Middleware\Admin;

use App\Models\Peran;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->peran_id !== Peran::PERAN_ADMIN_ID) {
            return abort(403);
        }

        return $next($request);
    }
}