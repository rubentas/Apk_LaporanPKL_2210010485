<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingController extends Controller
{
  // Profile Page
  public function profile()
  {
    $user = Auth::user();
    return view('settings.profile', compact('user'));
  }

  // Update Profile
  public function updateProfile(Request $request)
  {
    $rules = [
      'name' => 'required|string|max:100',
    ];

    // Hanya validasi password jika ada input new_password
    if ($request->filled('new_password')) {
      $rules['current_password'] = 'required';
      $rules['new_password'] = 'required|min:6|confirmed';
    }

    $request->validate($rules);

    try {
      $user = User::find(Auth::id());

      if (!$user) {
        return back()->withErrors(['error' => 'User tidak ditemukan']);
      }

      // Update name
      $user->name = $request->name;

      // Update password if provided
      if ($request->filled('new_password')) {
        if (!Hash::check($request->current_password, $user->password)) {
          return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }
        $user->password = Hash::make($request->new_password);
      }

      $user->save();

      return redirect()->route('settings.profile')
        ->with('success', 'Profile berhasil diperbarui');
    } catch (\Exception $e) {
      return back()->withErrors(['error' => 'Gagal update profile: ' . $e->getMessage()]);
    }
  }

  // About System Page
  public function about()
  {
    $systemInfo = [
      'name' => 'Sistem Manajemen Arsip Digital BRI',
      'version' => '1.0.0',
      'developer' => 'Tim PKL BRI',
      'framework' => 'Laravel ' . app()->version(),
      'php_version' => PHP_VERSION,
      'database' => config('database.default'),
      'environment' => app()->environment(),
      'last_update' => 'December 2025',
    ];

    return view('settings.about', compact('systemInfo'));
  }
}