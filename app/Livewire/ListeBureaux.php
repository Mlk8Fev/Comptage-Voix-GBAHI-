<?php

namespace App\Livewire;

use App\Models\BureauVote;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ListeBureaux extends Component
{
    public $commune = 'LILIYO';
    public $search = '';
    public $showPvModal = false;
    public $pvPhotoUrl = null;
    public $pvBureauNom = null;

    public function mount()
    {
        $communeFromRequest = request()->query('commune');
        if ($communeFromRequest && in_array($communeFromRequest, ['LILIYO', 'OKROUYO', 'MAYO'])) {
            $this->commune = $communeFromRequest;
        }
    }

    #[On('vote-updated')]
    public function refreshData()
    {
        // Les données seront automatiquement rafraîchies
    }

    public function voirPv($photo, $bureau)
    {
        $this->pvPhotoUrl = $photo;
        $this->pvBureauNom = $bureau;
        $this->showPvModal = true;
    }

    public function fermerPvModal()
    {
        $this->showPvModal = false;
        $this->pvPhotoUrl = null;
        $this->pvBureauNom = null;
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
