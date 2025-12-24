<?php

namespace App\Livewire;

use App\Models\BureauVote;
use App\Models\Candidat;
use App\Models\LieuVote;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public $lieuVoteId = null;
    
    #[On('vote-updated')]
    public function refreshData()
    {
        // Les données seront automatiquement rafraîchies
    }

    public function render()
    {
        $query = BureauVote::with(['lieuVote', 'votes.candidat', 'resultat']);
        
        if ($this->lieuVoteId) {
            $query->where('lieu_vote_id', $this->lieuVoteId);
        }
        
        $bureaux = $query->get();
        
        $candidats = Candidat::with('votes')
            ->get()
            ->map(function ($candidat) use ($bureaux) {
                $candidat->total_voix = $candidat->votes()
                    ->when($this->lieuVoteId, function($q) {
                        $q->whereHas('bureauVote', fn($bq) => $bq->where('lieu_vote_id', $this->lieuVoteId));
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
        
        $lieuxVote = LieuVote::with('bureauxVote')->get();
        
        return view('livewire.dashboard', [
            'bureaux' => $bureaux,
            'candidats' => $candidats,
            'totalVoix' => $totalVoix,
            'totalVotants' => $totalVotants,
            'totalInscrits' => $totalInscrits,
            'totalBulletinsNuls' => $totalBulletinsNuls,
            'totalBulletinsBlancs' => $totalBulletinsBlancs,
            'totalSuffrageExprime' => $totalSuffrageExprime,
            'tauxParticipation' => $tauxParticipation,
            'lieuxVote' => $lieuxVote,
        ]);
    }
}
