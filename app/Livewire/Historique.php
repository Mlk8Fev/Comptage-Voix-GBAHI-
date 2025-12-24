<?php

namespace App\Livewire;

use App\Models\HistoriqueModification;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Historique extends Component
{
    public $bureauVoteId = null;
    public $commune = null;

    public function render()
    {
        $query = HistoriqueModification::with('bureauVote.lieuVote')
            ->orderBy('date_modification', 'desc');

        if ($this->bureauVoteId) {
            $query->where('bureau_vote_id', $this->bureauVoteId);
        }

        if ($this->commune) {
            $query->whereHas('bureauVote.lieuVote', fn($q) => $q->where('commune', $this->commune));
        }

        $historique = $query->latest('date_modification')->paginate(20);
        
        // Charger tous les candidats pour afficher leurs noms
        $candidats = \App\Models\Candidat::pluck('nom_complet', 'id')->toArray();

        return view('livewire.historique', [
            'historique' => $historique,
            'candidats' => $candidats,
        ]);
    }
}
