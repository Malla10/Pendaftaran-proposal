<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'judul',
        'abstrak',
        'keywords',
        'file_proposal',
        'status',
        'dosen_pembimbing_id',
        'dosen_pembimbing_id_2', // ✅ TAMBAHKAN INI
        'assigned_by',
        'assigned_at',
        'catatan_admin'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    // Relasi
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    // Pembimbing 1
    public function dosenPembimbing()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_id');
    }

    // Pembimbing 2 ✅
    public function dosenPembimbing2()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_id_2');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class)->orderBy('rank');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Helper methods
    public function getKeywordsArray()
    {
        return array_map('trim', explode(',', strtolower($this->keywords)));
    }

    public function getStatusBadge()
    {
        $badges = [
            'pending' => '<span class="badge bg-secondary">Pending</span>',
            'menunggu_penetapan' => '<span class="badge bg-info">Menunggu Penetapan</span>',
            'pembimbing_ditentukan' => '<span class="badge bg-success">Pembimbing Ditentukan</span>',
            'ditolak' => '<span class="badge bg-danger">Ditolak</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getStatusText()
    {
        $statuses = [
            'pending' => 'Pending',
            'menunggu_penetapan' => 'Menunggu Penetapan',
            'pembimbing_ditentukan' => 'Pembimbing Ditentukan',
            'ditolak' => 'Ditolak',
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }
}
