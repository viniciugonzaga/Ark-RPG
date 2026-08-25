<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ritual extends Model
{
    protected $table = 'rituals';

    protected $fillable = [
        'character_id',
        'type',
        'name',
        'description'
    ];

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'character_id');
    }
}