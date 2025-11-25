<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'proposal_id',
        'dosen_id',
        'match_score',
        'keyword_score',
        'quota_penalty',
        'rank'
    ];

    // Relasi
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    // Helper methods
    public function getStarRating()
    {
        $score = $this->match_score;
        $fullStars = floor($score / 20);
        $halfStar = ($score % 20) >= 10 ? 1 : 0;
        $emptyStars = 5 - $fullStars - $halfStar;

        $stars = str_repeat('★', $fullStars);
        $stars .= str_repeat('⯨', $halfStar);
        $stars .= str_repeat('☆', $emptyStars);

        return $stars;
    }

    public function getMatchPercentage()
    {
        return round($this->match_score, 0) . '%';
    }

    public function getScoreClass()
    {
        if ($this->match_score >= 80) return 'success';
        if ($this->match_score >= 60) return 'info';
        if ($this->match_score >= 40) return 'warning';
        return 'danger';
    }
}