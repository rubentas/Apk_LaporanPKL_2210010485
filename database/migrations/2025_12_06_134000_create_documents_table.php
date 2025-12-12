<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('documents', function (Blueprint $table) {  // ✅ GANTI: documents
      $table->id();

      // Data Nasabah (STAY - penting untuk BRI!)
      $table->string('nama_nasabah');
      $table->string('no_rekening');
      $table->string('no_ktp')->nullable();
      $table->string('alamat')->nullable();
      $table->string('telepon')->nullable();

      // Data Dokumen
      $table->enum('jenis_dokumen', [
        'KTP',
        'Kartu Keluarga',
        'Slip Gaji',
        'NPWP',
        'Sertifikat Tanah',
        'BPKB Kendaraan',
        'Rekening Koran',
        'Surat Nikah',
        'Akte Usaha',
        'Lainnya'
      ]);

      $table->enum('kategori_kredit', [
        'KUR (Kredit Usaha Rakyat)',
        'KPR (Kredit Pemilikan Rumah)',
        'KKB (Kredit Kendaraan Bermotor)',
        'Kredit Modal Kerja',
        'Kredit Investasi',
        'Kredit Konsumsi',
        'Lainnya'
      ]);

      // File Info - ✅ REVISI DISINI
      $table->string('nama_file');
      $table->string('path_file');
      $table->string('mime_type');  // ✅ GANTI: ekstensi → mime_type
      $table->unsignedBigInteger('file_size'); // ✅ GANTI: size_mb → file_size (bytes)

      // Status & Tracking
      $table->enum('status', ['pending', 'verified', 'rejected', 'expired'])->default('pending');
      $table->text('catatan')->nullable();
      $table->date('tanggal_dokumen')->nullable();
      $table->date('expired_date')->nullable();

      // Foreign Keys
      $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
      $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
      $table->timestamp('verified_at')->nullable();

      $table->timestamps();
      $table->softDeletes();

      // Indexes
      $table->index('nama_nasabah');
      $table->index('no_rekening');
      $table->index('status');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('documents');  // ✅ GANTI: documents
  }
};