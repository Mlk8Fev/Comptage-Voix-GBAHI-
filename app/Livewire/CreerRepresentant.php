<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\BureauVote;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CreerRepresentant extends Component
{
    public $userId = null;
    public $name = '';
    public $email = '';
    public $telephone = '';
    public $password = '';
    public $password_confirmation = '';
    public $bureauxSelectionnes = [];
    public $commune = null;

    public function mount($userId = null)
    {
        if ($userId) {
            $user = User::with('bureauxVote')->findOrFail($userId);
            if ($user->role !== 'representant') {
                abort(403);
            }
            $this->userId = $userId;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->telephone = $user->telephone;
            $this->bureauxSelectionnes = $user->bureauxVote->pluck('id')->toArray();
        }
    }

    public function sauvegarder()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($this->userId ? ',' . $this->userId : ''),
            'telephone' => 'nullable|string|max:20',
            'bureauxSelectionnes' => 'required|array|min:1',
        ];

        if (!$this->userId || $this->password) {
            $rules['password'] = 'required|min:6|confirmed';
        }

        $this->validate($rules);

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
        } else {
            $user = new User();
            $user->role = 'representant';
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->telephone = $this->telephone;
        
        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        // Assigner les bureaux
        $user->bureauxVote()->sync($this->bureauxSelectionnes);

        session()->flash('message', $this->userId ? 'Représentant modifié avec succès !' : 'Représentant créé avec succès !');
        return redirect()->route('gestion-representants');
    }

    public function render()
    {
        $query = BureauVote::with('lieuVote')->orderBy('lieu_vote_id')->orderBy('numero');

        if ($this->commune) {
            $query->whereHas('lieuVote', fn($q) => $q->where('commune', $this->commune));
        }

        $bureaux = $query->get()->groupBy(function($bureau) {
            return $bureau->lieuVote->nom;
        });

        return view('livewire.creer-representant', [
            'bureaux' => $bureaux,
        ]);
    }
}
