<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
  public function handle(Request $request, Closure $next): Response
  {
    // Cek udah login belum
    if (!Auth::check()) {
      return redirect()->route('login');
    }

    // Cek role admin (pastikan field di database namanya 'role')
    if (Auth::user()->role !== 'admin') {
      abort(403, 'Akses ditolak. Hanya untuk admin.');
    }

    return $next($request);
  }
}