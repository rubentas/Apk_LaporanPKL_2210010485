<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'documents';

  protected $fillable = [
    'nama_nasabah',
    'no_rekening',
    'no_ktp',
    'alamat',
    'telepon',
    'jenis_dokumen',
    'kategori_kredit',
    'nama_file',
    'document_file',
    'path_file',
    'mime_type',
    'file_size',
    'status',
    'catatan',
    'tanggal_dokumen',
    'expired_date',
    'uploaded_by',
    'verified_by',
    'verified_at',
    'tahun_pengajuan',
    'tenor',
    'nominal_kredit',
    'suku_bunga',
    'jenis_bunga',
    'estimasi_selesai',
    'status_riwayat',
    'keterangan_reject'
  ];

  protected $dates = ['tanggal_dokumen', 'expired_date', 'verified_at'];

  protected $casts = [
    'verified_at' => 'datetime',
    'tanggal_dokumen' => 'date',
    'expired_date' => 'date',
    'file_size' => 'integer',
  ];

  protected $appends = [
    'status_badge',
    'file_size_formatted',
    'is_expired',
    'document_type_icon',
    'kategori_color',
    'tanggal_dokumen_formatted',
    'expired_date_formatted'
  ];

  // ===== RELATIONSHIPS =====
  public function uploader()
  {
    return $this->belongsTo(User::class, 'uploaded_by');
  }

  public function verifier()
  {
    return $this->belongsTo(User::class, 'verified_by');
  }

  // ===== ACCESSORS =====
  public function getStatusBadgeAttribute()
  {
    $badges = [
      'pending' => '<span class="badge badge-warning">Pending</span>',
      'verified' => '<span class="badge badge-success">Verified</span>',
      'rejected' => '<span class="badge badge-danger">Rejected</span>',
      'expired' => '<span class="badge badge-secondary">Expired</span>',
    ];

    return $badges[$this->status] ?? $badges['pending'];
  }

  public function getFileSizeFormattedAttribute()
  {
    $bytes = $this->file_size;

    if ($bytes >= 1073741824) {
      return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
      return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
      return number_format($bytes / 1024, 2) . ' KB';
    } else {
      return $bytes . ' bytes';
    }
  }

  public function getIsExpiredAttribute()
  {
    if (!$this->expired_date) return false;
    return Carbon::parse($this->expired_date)->isPast();
  }

  public function getDocumentTypeIconAttribute()
  {
    $icons = [
      'KTP' => 'fa-id-card',
      'Kartu Keluarga' => 'fa-users',
      'Slip Gaji' => 'fa-file-invoice-dollar',
      'NPWP' => 'fa-file-contract',
      'Sertifikat Tanah' => 'fa-landmark',
      'BPKB Kendaraan' => 'fa-car',
      'Rekening Koran' => 'fa-file-invoice',
      'Surat Nikah' => 'fa-heart',
      'Akte Usaha' => 'fa-briefcase',
      'Lainnya' => 'fa-file',
    ];

    return $icons[$this->jenis_dokumen] ?? 'fa-file';
  }

  public function getKategoriColorAttribute()
  {
    $colors = [
      'KUR (Kredit Usaha Rakyat)' => 'primary',
      'KPR (Kredit Pemilikan Rumah)' => 'info',
      'KKB (Kredit Kendaraan Bermotor)' => 'success',
      'Kredit Modal Kerja' => 'warning',
      'Kredit Investasi' => 'danger',
      'Kredit Konsumsi' => 'secondary',
      'Lainnya' => 'dark',
    ];

    return $colors[$this->kategori_kredit] ?? 'secondary';
  }

  public function getTanggalDokumenFormattedAttribute()
  {
    if (!$this->tanggal_dokumen) return '-';
    return Carbon::parse($this->tanggal_dokumen)->format('d/m/Y');
  }

  public function getExpiredDateFormattedAttribute()
  {
    if (!$this->expired_date) return '-';

    $date = Carbon::parse($this->expired_date)->format('d/m/Y');

    if ($this->is_expired) {
      return '<span class="text-danger">' . $date . ' (EXPIRED)</span>';
    } elseif (Carbon::parse($this->expired_date)->diffInDays(now()) <= 30) {
      return '<span class="text-warning">' . $date . ' (Soon)</span>';
    }

    return $date;
  }

  // ===== SCOPES =====
  public function scopePending($query)
  {
    return $query->where('status', 'pending');
  }

  public function scopeVerified($query)
  {
    return $query->where('status', 'verified');
  }

  public function scopeExpiringSoon($query, $days = 30)
  {
    return $query->where('status', '!=', 'expired')
      ->whereNotNull('expired_date')
      ->where('expired_date', '>=', now())
      ->where('expired_date', '<=', now()->addDays($days));
  }

  public function scopeExpired($query)
  {
    return $query->where(function ($q) {
      $q->where('status', 'expired')
        ->orWhere(function ($q2) {
          $q2->whereNotNull('expired_date')
            ->where('expired_date', '<', now())
            ->where('status', '!=', 'expired');
        });
    });
  }

  public function scopeStatusCounts($query)
  {
    return $query->selectRaw("
        COUNT(*) as total,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified,
        SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
        SUM(CASE WHEN status = 'expired' THEN 1 ELSE 0 END) as expired,
        SUM(CASE WHEN status NOT IN ('expired')
                  AND expired_date IS NOT NULL
                  AND expired_date >= CURDATE()
                  AND expired_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
               THEN 1 ELSE 0 END) as expiring_soon
    ");
  }

  public function scopeMonthlyStats($query, $months = 6)
  {
    return $query->selectRaw("
        DATE_FORMAT(created_at, '%Y-%m') as month,
        COUNT(*) as total,
        SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified
    ")
      ->where('created_at', '>=', now()->subMonths($months))
      ->groupBy('month')
      ->orderBy('month');
  }

  public function scopeTopCategories($query, $limit = 5)
  {
    return $query->select('kategori_kredit', DB::raw('COUNT(*) as total'))
      ->whereNotNull('kategori_kredit')
      ->where('kategori_kredit', '!=', '')
      ->groupBy('kategori_kredit')
      ->orderByDesc('total')
      ->limit($limit);
  }

  public function scopeSearch($query, $search)
  {
    return $query->where(function ($q) use ($search) {
      $q->where('nama_nasabah', 'like', "%{$search}%")
        ->orWhere('no_rekening', 'like', "%{$search}%")
        ->orWhere('no_ktp', 'like', "%{$search}%");
    });
  }

  // ===== HELPER METHOD =====
  public function getFilePathAttribute()
  {
    return $this->document_file ?? $this->path_file ?? null;
  }
}
