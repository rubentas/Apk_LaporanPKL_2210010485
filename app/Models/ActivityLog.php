<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


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


  public static function log($action, $description, $userId = null, $documentId = null)
  {
    if ($userId === null && Auth::check()) {
      $userId = Auth::id();
    }

    return self::create([
      'user_id' => $userId, // ✅ NULL kalau login gagal
      'document_id' => $documentId,
      'action' => $action,
      'description' => $description,
      'ip_address' => request()->ip(),
      'user_agent' => request()->userAgent(),
    ]);
  }
}
