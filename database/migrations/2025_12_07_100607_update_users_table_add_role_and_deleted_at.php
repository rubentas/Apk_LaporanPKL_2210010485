<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      // Tambah kolom jika belum ada
      if (!Schema::hasColumn('users', 'role')) {
        $table->enum('role', ['admin', 'verifikator', 'user'])->default('user');
      }

      if (!Schema::hasColumn('users', 'deleted_at')) {
        $table->timestamp('deleted_at')->nullable();
      }

      if (!Schema::hasColumn('users', 'avatar')) {
        $table->string('avatar')->nullable();
      }
    });
  }

  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn(['role', 'deleted_at', 'avatar']);
    });
  }
};