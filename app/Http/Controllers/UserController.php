<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index()
  {
    // Ambil semua user
    $users = User::orderBy('name')->get();

    // Tampilkan halaman list user
    return view('users.list', [
      'users' => $users
    ]);
  }

  public function create()
  {
    return "Create user - not implemented";
  }

  public function store(Request $request)
  {
    return redirect()->route('users.index');
  }

  public function show($id)
  {
    return redirect()->route('users.index');
  }

  public function edit($id)
  {
    return redirect()->route('users.index');
  }

  public function update(Request $request, $id)
  {
    return redirect()->route('users.index');
  }

  public function destroy($id)
  {
    return redirect()->route('users.index');
  }
}