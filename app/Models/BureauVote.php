<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BureauVote extends Model
{
    protected $table = 'bureaux_vote';
    
    protected $fillable = [
        'lieu_vote_id',
        'numero',
        'hommes_inscrits',
        'femmes_inscrits',
        'est_ouvert',
    ];

    protected $casts = [
        'est_ouvert' => 'boolean',
    ];

    public function lieuVote(): BelongsTo
    {
        return $this->belongsTo(LieuVote::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function resultat(): HasOne
    {
        return $this->hasOne(ResultatBureau::class);
    }

    public function representants()
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_bureaux_vote');
    }

    public function getTotalInscritsAttribute(): int
    {
        return $this->hommes_inscrits + $this->femmes_inscrits;
    }

    public function getTotalVoixAttribute(): int
    {
        return $this->votes()->sum('nombre_voix');
    }

    public function getTauxParticipationAttribute(): float
    {
        if ($this->total_inscrits == 0) {
            return 0;
        }
        $votants = $this->resultat ? $this->resultat->nombre_votants : 0;
        return ($votants / $this->total_inscrits) * 100;
    }
}

