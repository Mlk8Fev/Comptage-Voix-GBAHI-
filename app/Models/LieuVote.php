<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LieuVote extends Model
{
    protected $table = 'lieux_vote';
    
    protected $fillable = [
        'nom',
        'adresse',
        'commune',
        'circonscription',
    ];

    public function bureauxVote(): HasMany
    {
        return $this->hasMany(BureauVote::class);
    }

    public function getTotalInscritsAttribute(): int
    {
        return $this->bureauxVote()->sum('hommes_inscrits') + $this->bureauxVote()->sum('femmes_inscrits');
    }
}

