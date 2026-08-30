<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Character extends Model
{
    use HasFactory;

    protected $table = 'fichas';

    protected $fillable = [
        'user_id',
        'share_code',
        'is_resgatada',
        'is_pinned',
        'original_user_id',
        'original_character_id',
        'name',
        'image',
        'background_image',
        'level',
        'age',
        'class_main',
        'class_sub',
        'lore',
        'arsenal',
        'agi',
        'for',
        'int',
        'set',
        'vig',
        'vida',
        'armadura',
        'determinacao',
        'folego',
        'resistencia',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function originalUser()
    {
        return $this->belongsTo(User::class, 'original_user_id');
    }

    public function originalCharacter()
    {
        return $this->belongsTo(self::class, 'original_character_id');
    }

    public function mutations()
    {
        return $this->hasMany(Mutation::class, 'character_id');
    }

    public function bonuses()
    {
        return $this->hasMany(Bonus::class, 'character_id');
    }

    public function survivorPowers()
    {
        return $this->hasMany(SurvivorPower::class, 'character_id');
    }

    public function rituals()
    {
        return $this->hasMany(Ritual::class, 'character_id');
    }

    public static function generateShareCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('share_code', $code)->exists());
        return $code;
    }

    public function share()
    {
        if (!$this->share_code) {
            $this->share_code = self::generateShareCode();
            $this->save();
        }
        return $this->share_code;
    }

    public function isResgatada()
    {
        return $this->is_resgatada;
    }
}