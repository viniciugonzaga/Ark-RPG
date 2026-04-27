<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'cargo', 'foto', 'crystal_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relacionamento com fichas
    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    // Gera automaticamente o crystal_id ao criar o usuário
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->crystal_id)) {
                $user->crystal_id = self::generateUniqueCrystalId();
            }
        });
    }

    public static function generateUniqueCrystalId()
    {
        do {
            $crystal = 'CRY-' . strtoupper(Str::random(8));
        } while (self::where('crystal_id', $crystal)->exists());
        return $crystal;
    }
}