<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionParticipant extends Model
{
    protected $table = 'game_session_participants';

    protected $fillable = ['game_session_id', 'user_id'];

    public function session()
    {
        return $this->belongsTo(Session::class, 'game_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}