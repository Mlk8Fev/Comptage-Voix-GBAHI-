<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriqueModification extends Model
{
    protected $table = 'historique_modifications';
    
    protected $fillable = [
        'bureau_vote_id',
        'nombre_votants_avant',
        'nombre_votants_apres',
        'bulletins_nuls_avant',
        'bulletins_nuls_apres',
        'bulletins_blancs_avant',
        'bulletins_blancs_apres',
        'suffrage_exprime_avant',
        'suffrage_exprime_apres',
        'votes_avant',
        'votes_apres',
        'modifie_par',
        'date_modification',
    ];

    protected $casts = [
        'votes_avant' => 'array',
        'votes_apres' => 'array',
        'date_modification' => 'datetime',
    ];

    public function bureauVote(): BelongsTo
    {
        return $this->belongsTo(BureauVote::class);
    }
}
