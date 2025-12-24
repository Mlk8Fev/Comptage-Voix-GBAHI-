<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultatBureau extends Model
{
    protected $table = 'resultats_bureaux';
    
    protected $fillable = [
        'bureau_vote_id',
        'nombre_votants',
        'bulletins_nuls',
        'bulletins_blancs',
        'suffrage_exprime',
        'derniere_mise_a_jour',
    ];

    protected $casts = [
        'derniere_mise_a_jour' => 'datetime',
    ];

    public function bureauVote(): BelongsTo
    {
        return $this->belongsTo(BureauVote::class);
    }
}

