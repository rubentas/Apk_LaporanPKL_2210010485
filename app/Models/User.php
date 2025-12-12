<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'avatar',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  // ===== RELATIONSHIPS =====

  public function documentsUploaded()
  {
    return $this->hasMany(Document::class, 'uploaded_by');
  }

  public function documentsVerified()
  {
    return $this->hasMany(Document::class, 'verified_by');
  }

  public function activityLogs()
  {
    return $this->hasMany(ActivityLog::class);
  }

  // ===== HELPER METHODS =====

  public function isAdmin()
  {
    return $this->role === 'admin';
  }

  public function isVerifikator()
  {
    return $this->role === 'verifikator';
  }

  public function getRoleBadgeAttribute()
  {
    $badges = [
      'admin' => '<span class="badge badge-danger">Administrator</span>',
      'verifikator' => '<span class="badge badge-primary">Verifikator</span>',
    ];

    return $badges[$this->role] ?? '<span class="badge badge-secondary">User</span>';
  }

  public function getInitialsAttribute()
  {
    $words = explode(' ', $this->name);
    $initials = '';

    foreach ($words as $word) {
      $initials .= strtoupper(substr($word, 0, 1));
    }

    return substr($initials, 0, 2);
  }

  public function getAvatarUrlAttribute()
  {
    if ($this->avatar) {
      return asset('storage/avatars/' . $this->avatar);
    }

    // Default avatar based on name
    return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=0033a0&background=ffffff';
  }

  // ===== SCOPES =====

  public function scopeAdmins($query)
  {
    return $query->where('role', 'admin');
  }

  public function scopeVerifikators($query)
  {
    return $query->where('role', 'verifikator');
  }

  // ===== EVENTS =====

  protected static function boot()
  {
    parent::boot();

    // Log activity ketika user dibuat
    static::created(function ($user) {
      ActivityLog::log('create_user', 'User baru dibuat: ' . $user->name);
    });

    // Log activity ketika user diupdate
    static::updated(function ($user) {
      ActivityLog::log('update_user', 'User diperbarui: ' . $user->name);
    });
  }
}