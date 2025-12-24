<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class GestionRepresentants extends Component
{
    public $search = '';

    public function render()
    {
        $query = User::where('role', 'representant')
            ->with('bureauxVote.lieuVote')
            ->orderBy('name');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('telephone', 'like', '%' . $this->search . '%');
            });
        }

        $representants = $query->get();

        return view('livewire.gestion-representants', [
            'representants' => $representants,
        ]);
    }

    public function supprimer($userId)
    {
        $user = User::findOrFail($userId);
        if ($user->role === 'representant') {
            $user->delete();
            session()->flash('message', 'Représentant supprimé avec succès !');
        }
    }
}
