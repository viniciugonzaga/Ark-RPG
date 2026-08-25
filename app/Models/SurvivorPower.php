<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurvivorPower extends Model
{
    protected $table = 'survivor_powers';

    protected $fillable = [
        'character_id',
        'name',
        'description'
    ];

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'character_id');
    }
}