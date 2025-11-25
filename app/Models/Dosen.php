<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';

    protected $fillable = [
        'user_id',
        'nidn',
        'nama',
        'bidang_penelitian',
        'keywords',
        'kuota_bimbingan',
        'kuota_terpakai',
        'email',
        'phone'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'dosen_pembimbing_id');
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

    // Helper methods
    public function getKeywordsArray()
    {
        return array_map('trim', explode(',', strtolower($this->keywords)));
    }

    public function getSisaKuota()
    {
        return max(0, $this->kuota_bimbingan - $this->kuota_terpakai);
    }

    public function isKuotaPenuh()
    {
        return $this->kuota_terpakai >= $this->kuota_bimbingan;
    }

    public function getPersentaseBeban()
    {
        if ($this->kuota_bimbingan == 0) return 0;
        return round(($this->kuota_terpakai / $this->kuota_bimbingan) * 100, 2);
    }
}