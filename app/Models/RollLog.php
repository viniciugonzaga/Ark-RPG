<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RollLog extends Model
{
    protected $fillable = ['user_id', 'character_id', 'dice_result', 'event_result'];

    public function ficha() {
        return $this->belongsTo(Character::class, 'character_id');
    }
}