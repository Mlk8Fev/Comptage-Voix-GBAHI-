<?php

namespace App\Livewire;

use App\Models\BureauVote;
use App\Models\Candidat;
use App\Models\HistoriqueModification;
use App\Models\ResultatBureau;
use App\Models\Vote;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class SaisieVotes extends Component
{
    use WithFileUploads;
    
    public $bureauVoteId;
    public $bureauVote;
    public $candidats = [];
    public $votes = [];
    
    // Données du résultat
    public $nombre_votants = 0;
    public $bulletins_nuls = 0;
    public $bulletins_blancs = 0;
    public $suffrage_exprime = 0;
    public $pv_photo = null;
    public $pv_photo_existant = null;
    
    // Pour la confirmation
    public $showConfirmModal = false;

    public function mount($bureauVoteId)
    {
        // Vérifier l'authentification
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->bureauVoteId = $bureauVoteId;
        $this->bureauVote = BureauVote::with('lieuVote')->findOrFail($bureauVoteId);
        
        // Vérifier les permissions
        if (!auth()->user()->canAccessBureau($bureauVoteId)) {
            abort(403, 'Vous n\'avez pas accès à ce bureau de vote.');
        }
        
        $this->candidats = Candidat::all();
        
        // Charger les résultats existants
        $resultat = ResultatBureau::where('bureau_vote_id', $this->bureauVoteId)->first();
        if ($resultat) {
            $this->nombre_votants = $resultat->nombre_votants;
            $this->bulletins_nuls = $resultat->bulletins_nuls;
            $this->bulletins_blancs = $resultat->bulletins_blancs;
            $this->suffrage_exprime = $resultat->suffrage_exprime;
            $this->pv_photo_existant = $resultat->pv_photo;
        }
        
        // Charger les votes existants (optimisé)
        $votesExistants = Vote::where('bureau_vote_id', $this->bureauVoteId)
            ->pluck('nombre_voix', 'candidat_id')
            ->toArray();
        
        foreach ($this->candidats as $candidat) {
            $this->votes[$candidat->id] = $votesExistants[$candidat->id] ?? 0;
        }
    }
    
    public function confirmerSauvegarde()
    {
        $this->showConfirmModal = true;
    }
    
    public function annulerConfirmation()
    {
        $this->showConfirmModal = false;
    }

    public function updated($propertyName)
    {
        // Calculer automatiquement le suffrage exprimé
        if (in_array($propertyName, ['nombre_votants', 'bulletins_nuls', 'bulletins_blancs'])) {
            $votants = (int) ($this->nombre_votants ?? 0);
            $nuls = (int) ($this->bulletins_nuls ?? 0);
            $blancs = (int) ($this->bulletins_blancs ?? 0);
            $this->suffrage_exprime = max(0, $votants - $nuls - $blancs);
        }
    }

    public function sauvegarder()
    {
        $this->showConfirmModal = false;
        
        // Validation
        $this->validate([
            'nombre_votants' => ['required', 'integer', 'min:0', 'max:' . $this->bureauVote->total_inscrits],
            'bulletins_nuls' => 'required|integer|min:0',
            'bulletins_blancs' => 'required|integer|min:0',
            'suffrage_exprime' => 'required|integer|min:0',
            'votes.*' => 'required|integer|min:0',
            'pv_photo' => 'nullable|image|max:5120', // Max 5MB
        ]);

        // Vérifier que la somme des votes = suffrage exprimé
        $sommeVotes = array_sum($this->votes);
        if ($sommeVotes != $this->suffrage_exprime) {
            session()->flash('error', "La somme des votes des candidats ({$sommeVotes}) doit être égale au suffrage exprimé ({$this->suffrage_exprime})");
            return;
        }

        // Récupérer les anciennes valeurs pour l'historique
        $ancienResultat = ResultatBureau::where('bureau_vote_id', $this->bureauVoteId)->first();
        $anciensVotes = Vote::where('bureau_vote_id', $this->bureauVoteId)
            ->pluck('nombre_voix', 'candidat_id')
            ->toArray();

        // Gérer l'upload de la photo du PV
        $pvPhotoPath = $this->pv_photo_existant;
        if ($this->pv_photo) {
            // Supprimer l'ancienne photo si elle existe
            if ($pvPhotoPath && Storage::disk('public')->exists($pvPhotoPath)) {
                Storage::disk('public')->delete($pvPhotoPath);
            }
            
            // Stocker la nouvelle photo
            $pvPhotoPath = $this->pv_photo->store('pv-photos', 'public');
        }

        // Enregistrer les résultats du bureau
        ResultatBureau::updateOrCreate(
            ['bureau_vote_id' => $this->bureauVoteId],
            [
                'nombre_votants' => $this->nombre_votants,
                'bulletins_nuls' => $this->bulletins_nuls,
                'bulletins_blancs' => $this->bulletins_blancs,
                'suffrage_exprime' => $this->suffrage_exprime,
                'pv_photo' => $pvPhotoPath,
                'derniere_mise_a_jour' => now(),
            ]
        );

        // Enregistrer les votes par candidat
        foreach ($this->votes as $candidatId => $nombreVoix) {
            Vote::updateOrCreate(
                [
                    'bureau_vote_id' => $this->bureauVoteId,
                    'candidat_id' => $candidatId,
                ],
                [
                    'nombre_voix' => $nombreVoix,
                ]
            );
        }

        // Enregistrer dans l'historique
        HistoriqueModification::create([
            'bureau_vote_id' => $this->bureauVoteId,
            'nombre_votants_avant' => $ancienResultat?->nombre_votants,
            'nombre_votants_apres' => $this->nombre_votants,
            'bulletins_nuls_avant' => $ancienResultat?->bulletins_nuls,
            'bulletins_nuls_apres' => $this->bulletins_nuls,
            'bulletins_blancs_avant' => $ancienResultat?->bulletins_blancs,
            'bulletins_blancs_apres' => $this->bulletins_blancs,
            'suffrage_exprime_avant' => $ancienResultat?->suffrage_exprime,
            'suffrage_exprime_apres' => $this->suffrage_exprime,
            'votes_avant' => $anciensVotes,
            'votes_apres' => $this->votes,
            'modifie_par' => auth()->user()->name . ' (' . auth()->user()->email . ')',
            'date_modification' => now(),
        ]);

        session()->flash('message', 'Votes enregistrés avec succès !');
        $this->dispatch('vote-updated');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.saisie-votes');
    }
}
