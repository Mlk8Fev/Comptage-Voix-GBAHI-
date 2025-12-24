<?php

namespace App\Livewire;

use App\Models\BureauVote;
use App\Models\Candidat;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Stats extends Component
{
    public $commune = null;

    public function render()
    {
        $query = BureauVote::with(['lieuVote', 'votes.candidat', 'resultat']);
        
        if ($this->commune) {
            $query->whereHas('lieuVote', fn($q) => $q->where('commune', $this->commune));
        }
        
        $bureaux = $query->get();
        
        $candidats = Candidat::with('votes')
            ->get()
            ->map(function ($candidat) use ($bureaux) {
                $candidat->total_voix = $candidat->votes()
                    ->when($this->commune, function($q) {
                        $q->whereHas('bureauVote.lieuVote', fn($bq) => $bq->where('commune', $this->commune));
                    })
                    ->sum('nombre_voix');
                return $candidat;
            })
            ->sortByDesc('total_voix');
        
        $totalVoix = $candidats->sum('total_voix');
        $totalVotants = $bureaux->sum(function($bureau) {
            return $bureau->resultat ? $bureau->resultat->nombre_votants : 0;
        });
        $totalInscrits = $bureaux->sum('total_inscrits');
        $totalBulletinsNuls = $bureaux->sum(function($bureau) {
            return $bureau->resultat ? $bureau->resultat->bulletins_nuls : 0;
        });
        $totalBulletinsBlancs = $bureaux->sum(function($bureau) {
            return $bureau->resultat ? $bureau->resultat->bulletins_blancs : 0;
        });
        $totalSuffrageExprime = $bureaux->sum(function($bureau) {
            return $bureau->resultat ? $bureau->resultat->suffrage_exprime : 0;
        });
        $tauxParticipation = $totalInscrits > 0 ? ($totalVotants / $totalInscrits) * 100 : 0;
        
        return view('livewire.stats', [
            'candidats' => $candidats,
            'totalVoix' => $totalVoix,
            'totalVotants' => $totalVotants,
            'totalInscrits' => $totalInscrits,
            'totalBulletinsNuls' => $totalBulletinsNuls,
            'totalBulletinsBlancs' => $totalBulletinsBlancs,
            'totalSuffrageExprime' => $totalSuffrageExprime,
            'tauxParticipation' => $tauxParticipation,
        ]);
    }
}
