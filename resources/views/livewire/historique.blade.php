<div>
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold text-gray-800">📜 Historique des modifications</h1>
            <div class="text-right">
                <p class="text-lg font-bold text-blue-600">GBAHI DJOUA LUC</p>
                <p class="text-xs text-gray-500">Équipe de campagne</p>
            </div>
        </div>
        
        <!-- Filtres -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filtrer par commune</label>
                <select wire:model.live="commune" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Toutes les communes</option>
                    <option value="LILIYO">LILIYO</option>
                    <option value="OKROUYO">OKROUYO</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste de l'historique -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        @if($historique->count() > 0)
            <div class="space-y-4">
                @foreach($historique as $modif)
                    <div class="border-l-4 border-blue-500 bg-gray-50 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-bold text-gray-800">
                                    {{ $modif->bureauVote->lieuVote->nom }} - Bureau {{ $modif->bureauVote->numero }}
                                </h3>
                                <p class="text-sm text-gray-600">{{ $modif->bureauVote->lieuVote->commune }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-700">{{ $modif->date_modification->format('d/m/Y H:i') }}</p>
                                <p class="text-xs text-gray-500">IP: {{ $modif->modifie_par }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                            <div class="bg-white rounded p-3">
                                <p class="text-xs text-gray-600 mb-1">Votants</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">{{ $modif->nombre_votants_avant ?? 0 }}</span>
                                    <span class="text-gray-400">→</span>
                                    <span class="font-bold text-blue-600">{{ $modif->nombre_votants_apres }}</span>
                                </div>
                            </div>
                            <div class="bg-white rounded p-3">
                                <p class="text-xs text-gray-600 mb-1">Bulletins nuls</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">{{ $modif->bulletins_nuls_avant ?? 0 }}</span>
                                    <span class="text-gray-400">→</span>
                                    <span class="font-bold text-red-600">{{ $modif->bulletins_nuls_apres }}</span>
                                </div>
                            </div>
                            <div class="bg-white rounded p-3">
                                <p class="text-xs text-gray-600 mb-1">Bulletins blancs</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">{{ $modif->bulletins_blancs_avant ?? 0 }}</span>
                                    <span class="text-gray-400">→</span>
                                    <span class="font-bold text-yellow-600">{{ $modif->bulletins_blancs_apres }}</span>
                                </div>
                            </div>
                            <div class="bg-white rounded p-3">
                                <p class="text-xs text-gray-600 mb-1">Suffrage exprimé</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">{{ $modif->suffrage_exprime_avant ?? 0 }}</span>
                                    <span class="text-gray-400">→</span>
                                    <span class="font-bold text-green-600">{{ $modif->suffrage_exprime_apres }}</span>
                                </div>
                            </div>
                        </div>

                        @if($modif->votes_apres)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-xs font-semibold text-gray-700 mb-2">Votes par candidat:</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs">
                                    @foreach($modif->votes_apres as $candidatId => $voix)
                                        <div class="bg-white rounded p-2 border border-gray-200">
                                            <span class="text-gray-600 font-medium">{{ $candidats[$candidatId] ?? 'Candidat ' . $candidatId }}:</span>
                                            <span class="font-semibold text-gray-800 ml-2">{{ number_format($voix, 0, ',', ' ') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $historique->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📋</div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucun historique</h3>
                <p class="text-gray-500">Aucune modification n'a encore été enregistrée.</p>
            </div>
        @endif
    </div>
</div>
