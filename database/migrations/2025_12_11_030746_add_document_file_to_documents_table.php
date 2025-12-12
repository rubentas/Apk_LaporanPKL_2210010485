<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::table('documents', function (Blueprint $table) {
      // Tambah document_file jika belum ada
      if (!Schema::hasColumn('documents', 'document_file')) {
        $table->string('document_file')->after('nama_file')->nullable();
      }

      // Pastikan path_file ada dan nullable
      if (!Schema::hasColumn('documents', 'path_file')) {
        $table->string('path_file')->after('document_file')->nullable();
      }
    });
  }

  public function down()
  {
    Schema::table('documents', function (Blueprint $table) {
      $table->dropColumn(['document_file', 'path_file']);
    });
  }
};
