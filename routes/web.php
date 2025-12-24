<?php

use App\Livewire\Dashboard;
use App\Livewire\SaisieVotes;
use App\Livewire\Stats;
use App\Livewire\ListeBureaux;
use App\Livewire\Historique;
use App\Livewire\Login;
use App\Livewire\MesBureaux;
use App\Livewire\GestionRepresentants;
use App\Livewire\CreerRepresentant;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::get('/login', Login::class)->name('login')->middleware('guest');

// Routes protégées
Route::middleware('auth')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/stats', Stats::class)->name('stats');
    Route::get('/liste-bureaux', ListeBureaux::class)->name('liste-bureaux');
    Route::get('/historique', Historique::class)->name('historique');
    Route::get('/mes-bureaux', MesBureaux::class)->name('mes-bureaux');
    Route::get('/saisie-votes/{bureauVoteId}', SaisieVotes::class)->name('saisie-votes')->middleware(\App\Http\Middleware\CheckBureauAccess::class);
    
    // Routes admin uniquement
    Route::middleware(\App\Http\Middleware\EnsureUserIsAdmin::class)->group(function () {
        Route::get('/gestion-representants', GestionRepresentants::class)->name('gestion-representants');
        Route::get('/creer-representant/{userId?}', CreerRepresentant::class)->name('creer-representant');
    });
    
    // Déconnexion
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
