<div>
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Bureaux de vote - {{ $commune }}</h1>
                <p class="text-gray-600">Gérez et saisissez les résultats des bureaux de vote</p>
                <p class="text-blue-600 font-semibold mt-1">Équipe de GBAHI DJOUA LUC</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('liste-bureaux', ['commune' => 'LILIYO']) }}" class="px-4 py-2 rounded-lg transition {{ $commune === 'LILIYO' ? 'bg-green-600 text-white font-semibold' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    LILIYO
                </a>
                <a href="{{ route('liste-bureaux', ['commune' => 'OKROUYO']) }}" class="px-4 py-2 rounded-lg transition {{ $commune === 'OKROUYO' ? 'bg-purple-600 text-white font-semibold' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    OKROUYO
                </a>
                <a href="{{ route('liste-bureaux', ['commune' => 'MAYO']) }}" class="px-4 py-2 rounded-lg transition {{ $commune === 'MAYO' ? 'bg-orange-600 text-white font-semibold' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    MAYO
                </a>
            </div>
        </div>
    </div>

    <!-- Barre de recherche -->
    <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
        <div class="flex gap-4">
            <div class="flex-1">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Rechercher par nom de lieu ou numéro de bureau..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div class="text-sm text-gray-500 flex items-center">
                {{ $bureaux->count() }} bureau(x) trouvé(s)
            </div>
        </div>
    </div>

    <!-- Liste des bureaux -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($bureaux as $bureau)
            <div class="bg-white rounded-lg shadow-lg p-5 hover:shadow-xl transition border-l-4 {{ $bureau->resultat ? 'border-green-500' : 'border-gray-300' }}">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-800 mb-1">{{ $bureau->lieuVote->nom }}</h3>
                        <p class="text-sm text-gray-600">Bureau {{ $bureau->numero }}</p>
                    </div>
                    @if($bureau->resultat)
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">Complété</span>
                    @else
                        <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-1 rounded-full">En attente</span>
                    @endif
                </div>

                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Inscrits:</span>
                        <span class="font-semibold text-gray-800">{{ $bureau->total_inscrits }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Hommes:</span>
                        <span class="text-gray-700">{{ $bureau->hommes_inscrits }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Femmes:</span>
                        <span class="text-gray-700">{{ $bureau->femmes_inscrits }}</span>
                    </div>
                    
                    @if($bureau->resultat)
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Votants:</span>
                                <span class="font-semibold text-green-600">{{ $bureau->resultat->nombre_votants }}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Participation:</span>
                                <span class="font-semibold text-blue-600">{{ number_format($bureau->taux_participation, 2) }}%</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Suffrage exprimé:</span>
                                <span class="font-semibold text-purple-600">{{ $bureau->resultat->suffrage_exprime }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-2">
                    <a href="{{ route('saisie-votes', $bureau->id) }}" class="block w-full text-center bg-gradient-to-r {{ $bureau->resultat ? 'from-blue-500 to-blue-600' : 'from-green-500 to-green-600' }} text-white px-4 py-2 rounded-lg hover:shadow-md transition font-semibold">
                        {{ $bureau->resultat ? 'Modifier les votes' : 'Saisir les votes' }}
                    </a>
                    @if($bureau->resultat && $bureau->resultat->pv_photo)
                        <button 
                            wire:click="voirPv('{{ $bureau->resultat->pv_photo }}', '{{ $bureau->lieuVote->nom }} - Bureau {{ $bureau->numero }}')"
                            class="block w-full text-center bg-gradient-to-r from-purple-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:shadow-md transition font-semibold"
                        >
                            📸 Voir le PV
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($bureaux->isEmpty())
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucun bureau trouvé</h3>
            <p class="text-gray-500">Essayez de modifier votre recherche</p>
        </div>
    @endif

    <!-- Modal pour afficher le PV -->
    @if($showPvModal)
    <div class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50" wire:click="fermerPvModal">
        <div class="bg-white rounded-lg shadow-2xl p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-auto" wire:click.stop>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-bold text-gray-800">📸 Photo du PV</h3>
                <button wire:click="fermerPvModal" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
            </div>
            <p class="text-gray-600 mb-4">{{ $pvBureauNom }}</p>
            <div class="flex justify-center">
                <img src="{{ Storage::url($pvPhotoUrl) }}" alt="PV" class="max-w-full h-auto rounded-lg shadow-lg border-2 border-gray-300">
            </div>
            <div class="mt-4 flex justify-end">
                <button wire:click="fermerPvModal" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-semibold">
                    Fermer
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
