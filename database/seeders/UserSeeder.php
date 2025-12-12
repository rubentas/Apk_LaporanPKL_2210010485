<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  public function run()
  {
    // Hapus dulu jika sudah ada
    DB::table('users')->where('email', 'verifikator@bri.co.id')->delete();

    // Insert langsung ke database (tanpa Eloquent event)
    DB::table('users')->insert([
      'name' => 'Verifikator BRI',
      'email' => 'verifikator@bri.co.id',
      'password' => Hash::make('password123'),
      'role' => 'verifikator',
      'created_at' => now(),
      'updated_at' => now(),
    ]);


    DB::table('users')->insert([
      'name' => 'Admin BRI',
      'email' => 'admin@bri.com',
      'password' => Hash::make('password123'),
      'role' => 'admin',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    $this->command->info('User admin berhasil dibuat!');
  }
}
