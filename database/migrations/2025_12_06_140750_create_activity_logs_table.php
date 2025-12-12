<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('activity_logs', function (Blueprint $table) {
      $table->id();
      $table->string('action');
      $table->text('description');
      $table->string('ip_address', 45)->nullable();
      $table->text('user_agent')->nullable();

      // ✅ REVISI: constrained('documents') bukan ('dokumen')
      $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
      $table->foreignId('document_id')->nullable()->constrained('documents')->onDelete('set null');

      $table->timestamps();
      $table->index('action');
      $table->index('created_at');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('activity_logs');
  }
};