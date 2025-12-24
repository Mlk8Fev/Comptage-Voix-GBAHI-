<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    protected $fillable = [
        'bureau_vote_id',
        'candidat_id',
        'nombre_voix',
    ];

    public function bureauVote(): BelongsTo
    {
        return $this->belongsTo(BureauVote::class);
    }

    public function candidat(): BelongsTo
    {
        return $this->belongsTo(Candidat::class);
    }
}

