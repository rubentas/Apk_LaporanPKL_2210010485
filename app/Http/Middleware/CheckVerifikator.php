<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckVerifikator
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    // Cek user sudah login
    if (!Auth::check()) {
      return redirect()->route('login')
        ->with('error', 'Silakan login terlebih dahulu.');
    }

    // Cek user adalah verifikator
    if (Auth::user()->role !== 'verifikator') {
      abort(403, 'Akses ditolak. Hanya verifikator yang dapat mengakses halaman ini.');
    }

    return $next($request);
  }
}