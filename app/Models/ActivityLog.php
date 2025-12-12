<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
  use HasFactory;

  protected $fillable = [
    'action',
    'description',
    'ip_address',
    'user_agent',
    'user_id',
    'document_id',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function document()
  {
    return $this->belongsTo(Document::class);
  }

  // ✅ TAMBAHKAN METHOD INI:
  public static function log($action, $description, $userId = null, $documentId = null)
  {
    // Gunakan helper auth() dengan pengecekan yang aman
    $auth = app('auth');

    return self::create([
      'user_id' => $userId ?? ($auth->check() ? $auth->id() : null),
      'document_id' => $documentId,
      'action' => $action,
      'description' => $description,
      'ip_address' => request()->ip() ?? '127.0.0.1',
      'user_agent' => request()->userAgent() ?? 'CLI',
    ]);
  }
}