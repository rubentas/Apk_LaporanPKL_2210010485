<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function showLogin()
  {
    return view('auth.login');
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();

      ActivityLog::log(
        'login',
        "User " . Auth::user()->name . " login"
      );

      return redirect()->intended('/dashboard');
    }

    ActivityLog::log(
      'login_failed',
      "Failed login attempt: {$request->email}"
    );

    return back()->withErrors([
      'email' => 'Email atau password salah.',
    ])->onlyInput('email');
  }

  public function logout(Request $request)
  {
    if (Auth::check()) {
      ActivityLog::log('logout', "User " . Auth::user()->name . " logout", Auth::id());
    }

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
  }
}