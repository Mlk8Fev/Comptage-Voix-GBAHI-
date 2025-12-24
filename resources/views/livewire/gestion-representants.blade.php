<div>
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">👥 Gestion des Représentants</h1>
                <p class="text-gray-600">Créez et gérez les comptes des représentants de bureau</p>
                <p class="text-blue-600 font-semibold mt-1">Équipe de GBAHI DJOUA LUC</p>
            </div>
            <a href="{{ route('creer-representant') }}" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-lg hover:from-green-600 hover:to-green-700 transition font-semibold shadow-lg">
                ➕ Créer un représentant
            </a>
        </div>

        <!-- Barre de recherche -->
        <div class="mt-4">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search"
                placeholder="Rechercher par nom, email ou téléphone..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
        </div>
    </div>

    @if(session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4 shadow">
            <p class="font-semibold">✓ {{ session('message') }}</p>
        </div>
    @endif

    <!-- Liste des représentants -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        @if($representants->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-100 to-gray-50 border-b-2 border-gray-200">
                            <th class="text-left p-4 font-bold text-gray-700">Nom</th>
                            <th class="text-left p-4 font-bold text-gray-700">Email</th>
                            <th class="text-left p-4 font-bold text-gray-700">Téléphone</th>
                            <th class="text-left p-4 font-bold text-gray-700">Bureaux assignés</th>
                            <th class="text-center p-4 font-bold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($representants as $representant)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-4 font-semibold text-gray-800">{{ $representant->name }}</td>
                                <td class="p-4 text-gray-600">{{ $representant->email }}</td>
                                <td class="p-4 text-gray-600">{{ $representant->telephone ?? '-' }}</td>
                                <td class="p-4">
                                    @if($representant->bureauxVote->count() > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($representant->bureauxVote->take(3) as $bureau)
                                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                    {{ $bureau->lieuVote->nom }} - BV{{ $bureau->numero }}
                                                </span>
                                            @endforeach
                                            @if($representant->bureauxVote->count() > 3)
                                                <span class="text-gray-500 text-xs">+{{ $representant->bureauxVote->count() - 3 }} autres</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Aucun bureau assigné</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('creer-representant', ['userId' => $representant->id]) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition">
                                            ✏️ Modifier
                                        </a>
                                        <button 
                                            wire:click="supprimer({{ $representant->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir supprimer ce représentant ?"
                                            class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition"
                                        >
                                            🗑️ Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">👥</div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucun représentant</h3>
                <p class="text-gray-500 mb-4">Commencez par créer un représentant</p>
                <a href="{{ route('creer-representant') }}" class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                    Créer un représentant
                </a>
            </div>
        @endif
    </div>
</div>
