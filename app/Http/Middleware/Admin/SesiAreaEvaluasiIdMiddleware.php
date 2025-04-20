<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SesiAreaEvaluasiIdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((int) session('areaEvaluasiId') === 0) {
            session()->flash('error', 'Sesi telah habis. Silahkan pilih area evaluasi terlebih dahulu.');
            return redirect()->route('admin.kelola-pertanyaan');
        }

        return $next($request);
    }
}
