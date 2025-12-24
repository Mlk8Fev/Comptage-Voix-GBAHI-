<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class MesBureaux extends Component
{
    public $search = '';

    #[On('vote-updated')]
    public function refreshData()
    {
        // Les données seront automatiquement rafraîchies
    }

    public function render()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            // Les admins voient tous les bureaux
            $query = \App\Models\BureauVote::with(['lieuVote', 'resultat', 'votes']);
        } else {
            // Les représentants voient seulement leurs bureaux
            $query = $user->bureauxVote()->with(['lieuVote', 'resultat', 'votes']);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('numero', 'like', '%' . $this->search . '%')
                  ->orWhereHas('lieuVote', function($q) {
                      $q->where('nom', 'like', '%' . $this->search . '%');
                  });
            });
        }
        
        $bureaux = $query->orderBy('lieu_vote_id')->orderBy('numero')->get();
        
        return view('livewire.mes-bureaux', [
            'bureaux' => $bureaux,
        ]);
    }
}
