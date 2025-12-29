<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::table('documents', function (Blueprint $table) {
      // Field untuk analisis kredit (permintaan dosen)
      $table->year('tahun_pengajuan')->nullable()->after('tanggal_dokumen');
      $table->integer('tenor')->nullable()->comment('Dalam bulan')->after('tahun_pengajuan');
      $table->decimal('nominal_kredit', 15, 2)->nullable()->after('tenor');
      $table->decimal('suku_bunga', 5, 2)->nullable()->after('nominal_kredit');
      $table->enum('jenis_bunga', ['flat', 'bertingkat'])->nullable()->after('suku_bunga');
      $table->year('estimasi_selesai')->nullable()->after('jenis_bunga');
      $table->enum('status_riwayat', ['bersih', 'pernah_telat', 'bermasalah'])->nullable()->after('estimasi_selesai');
      $table->text('keterangan_reject')->nullable()->after('status_riwayat');

      // Index untuk query cepat
      $table->index(['status_riwayat', 'estimasi_selesai']);
      $table->index('kategori_kredit');
    });
  }

  public function down()
  {
    Schema::table('documents', function (Blueprint $table) {
      $table->dropColumn([
        'tahun_pengajuan',
        'tenor',
        'nominal_kredit',
        'suku_bunga',
        'jenis_bunga',
        'estimasi_selesai',
        'status_riwayat',
        'keterangan_reject'
      ]);

      $table->dropIndex(['status_riwayat', 'estimasi_selesai']);
      $table->dropIndex(['kategori_kredit']);
    });
  }
};
