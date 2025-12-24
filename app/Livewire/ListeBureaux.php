<?php

namespace App\Livewire;

use App\Models\BureauVote;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ListeBureaux extends Component
{
    public $commune = 'LILIYO';
    public $search = '';

    public function mount()
    {
        $communeFromRequest = request()->query('commune');
        if ($communeFromRequest && in_array($communeFromRequest, ['LILIYO', 'OKROUYO'])) {
            $this->commune = $communeFromRequest;
        }
    }

    #[On('vote-updated')]
    public function refreshData()
    {
        // Les données seront automatiquement rafraîchies
    }

    public function render()
    {
        $query = BureauVote::with(['lieuVote', 'resultat', 'votes'])
            ->whereHas('lieuVote', fn($q) => $q->where('commune', $this->commune));
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('numero', 'like', '%' . $this->search . '%')
                  ->orWhereHas('lieuVote', function($q) {
                      $q->where('nom', 'like', '%' . $this->search . '%');
                  });
            });
        }
        
        $bureaux = $query->orderBy('lieu_vote_id')->orderBy('numero')->get();
        
        return view('livewire.liste-bureaux', [
            'bureaux' => $bureaux,
        ]);
    }
}
