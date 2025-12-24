<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidat extends Model
{
    protected $fillable = [
        'nom_complet',
        'parti',
        'numero_liste',
    ];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function getTotalVoixAttribute(): int
    {
        return $this->votes()->sum('nombre_voix');
    }
}

