<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'activity',
        'description',
        'proposal_id'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    // Static method untuk logging
    public static function log($userId, $activity, $description, $proposalId = null)
    {
        return self::create([
            'user_id' => $userId,
            'activity' => $activity,
            'description' => $description,
            'proposal_id' => $proposalId
        ]);
    }
}