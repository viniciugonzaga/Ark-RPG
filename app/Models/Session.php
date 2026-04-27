<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Session extends Model
{
    protected $table = 'game_sessions';

    protected $fillable = ['master_user_id', 'session_code', 'status'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($session) {
            if (empty($session->session_code)) {
                $session->session_code = self::generateUniqueCode();
            }
        });
    }

    public static function generateUniqueCode()
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (self::where('session_code', $code)->exists());
        return $code;
    }

    public function master()
    {
        return $this->belongsTo(User::class, 'master_user_id');
    }

    public function participants()
    {
        return $this->hasMany(SessionParticipant::class, 'game_session_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'game_session_participants', 'game_session_id', 'user_id');
    }
}