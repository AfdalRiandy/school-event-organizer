<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'acara_id',
        'status',
        'alasan_penolakan'
    ];

    // Relationship with Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relationship with Acara
    public function acara()
    {
        return $this->belongsTo(Acara::class);
    }

    // Status Badge Formatter
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge badge-warning">Menunggu Persetujuan</span>',
            'disetujui' => '<span class="badge badge-success">Disetujui</span>',
            'ditolak' => '<span class="badge badge-danger">Ditolak</span>',
            default => '<span class="badge badge-secondary">Unknown</span>'
        };
    }
}