<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'telephone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relations
    public function bureauxVote()
    {
        return $this->belongsToMany(BureauVote::class, 'user_bureaux_vote');
    }

    // Méthodes helper
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isRepresentant(): bool
    {
        return $this->role === 'representant';
    }

    public function canAccessBureau($bureauVoteId): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        return $this->bureauxVote()->where('bureaux_vote.id', $bureauVoteId)->exists();
    }
}
