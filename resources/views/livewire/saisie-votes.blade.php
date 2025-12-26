<div>
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold text-gray-800">📝 Saisie des votes</h1>
            <div class="text-right">
                <p class="text-lg font-bold text-blue-600">GBAHI DJOUA LUC</p>
                <p class="text-xs text-gray-500">Équipe de campagne</p>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border-l-4 border-blue-500">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $bureauVote->lieuVote->nom }}</h2>
            <p class="text-gray-600 mb-2">Bureau {{ $bureauVote->numero }} - {{ $bureauVote->lieuVote->commune }}</p>
            <div class="flex gap-4 text-sm">
                <span class="text-gray-700">
                    <span class="font-semibold">Inscrits:</span> {{ $bureauVote->total_inscrits }}
                </span>
                <span class="text-gray-700">
                    <span class="font-semibold">Hommes:</span> {{ $bureauVote->hommes_inscrits }}
                </span>
                <span class="text-gray-700">
                    <span class="font-semibold">Femmes:</span> {{ $bureauVote->femmes_inscrits }}
                </span>
            </div>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4 shadow">
            <p class="font-semibold">✓ {{ session('message') }}</p>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-4 shadow">
            <p class="font-semibold">⚠️ {{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Résultats du bureau</h2>
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre de votants</label>
                    <input 
                        type="number" 
                        wire:model.live="nombre_votants"
                        min="0"
                        max="{{ $bureauVote->total_inscrits }}"
                        class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bulletins nuls</label>
                    <input 
                        type="number" 
                        wire:model.live="bulletins_nuls"
                        min="0"
                        class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        required
                    >
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bulletins blancs</label>
                    <input 
                        type="number" 
                        wire:model.live="bulletins_blancs"
                        min="0"
                        class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                        required
                    >
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Suffrage exprimé</label>
                    <input 
                        type="number" 
                        wire:model="suffrage_exprime"
                        min="0"
                        class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 bg-gray-50 font-semibold text-gray-700"
                        readonly
                    >
                    <p class="text-xs text-gray-500 mt-1">Calculé automatiquement (Votants - Nuls - Blancs)</p>
                </div>
            </div>

            <div class="border-t-2 border-gray-200 pt-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Votes par candidat</h2>
                <div class="space-y-3">
                    @foreach($candidats as $candidat)
                        <div class="flex items-center justify-between border-b border-gray-200 pb-3 hover:bg-gray-50 p-2 rounded transition">
                            <div class="flex-1">
                                <label class="font-semibold text-gray-800 text-lg">{{ $candidat->nom_complet }}</label>
                                @if($candidat->parti)
                                    <p class="text-sm text-gray-600">{{ $candidat->parti }}</p>
                                @endif
                            </div>
                            <div class="w-32">
                                <input 
                                    type="number" 
                                    wire:model="votes.{{ $candidat->id }}"
                                    min="0"
                                    class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 text-right font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-2 {{ array_sum($votes) == $suffrage_exprime && array_sum($votes) > 0 ? 'border-green-500' : 'border-gray-300' }}">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-700">Total des votes candidats:</span>
                        <span class="text-xl font-bold {{ array_sum($votes) == $suffrage_exprime ? 'text-green-600' : 'text-gray-800' }}">{{ number_format(array_sum($votes), 0, ',', ' ') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Suffrage exprimé:</span>
                        <span class="text-xl font-bold text-blue-600">{{ number_format($suffrage_exprime, 0, ',', ' ') }}</span>
                    </div>
                    @if(array_sum($votes) != $suffrage_exprime && array_sum($votes) > 0)
                        <p class="text-red-600 text-sm mt-3 font-semibold bg-red-50 p-2 rounded">
                            ⚠️ La somme des votes ({{ number_format(array_sum($votes), 0, ',', ' ') }}) doit être égale au suffrage exprimé ({{ number_format($suffrage_exprime, 0, ',', ' ') }})
                        </p>
                    @elseif(array_sum($votes) == $suffrage_exprime && array_sum($votes) > 0)
                        <p class="text-green-600 text-sm mt-3 font-semibold">
                            ✓ Les totaux correspondent
                        </p>
                    @endif
                </div>
            </div>

            <!-- Upload de la photo du PV -->
            <div class="mt-8 pt-6 border-t-2 border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">📸 Photo du Procès-Verbal (PV)</h2>
                <p class="text-gray-600 text-sm mb-4">Prenez une photo du PV et uploadez-la comme preuve de confirmation</p>
                
                <div class="space-y-4">
                    @if($pv_photo_existant)
                        <div class="bg-green-50 border-2 border-green-200 rounded-lg p-4 mb-4">
                            <p class="text-green-800 font-semibold mb-2">✓ Photo du PV déjà uploadée</p>
                            <div class="flex items-center gap-4">
                                <img src="{{ Storage::url($pv_photo_existant) }}" alt="PV" class="max-w-xs max-h-48 rounded-lg shadow-md border-2 border-gray-300">
                                <div>
                                    <p class="text-sm text-gray-600">Vous pouvez la remplacer en uploadant une nouvelle photo ci-dessous.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ $pv_photo_existant ? 'Remplacer la photo du PV' : 'Uploader la photo du PV' }}
                            <span class="text-gray-500 text-xs">(Format: JPG, PNG - Max 5MB)</span>
                        </label>
                        <input 
                            type="file" 
                            wire:model="pv_photo"
                            accept="image/*"
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                        @error('pv_photo') 
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                        @enderror
                        
                        @if($pv_photo)
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 mb-2">Aperçu de la nouvelle photo :</p>
                                <img src="{{ $pv_photo->temporaryUrl() }}" alt="Aperçu PV" class="max-w-xs max-h-48 rounded-lg shadow-md border-2 border-blue-300">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-4 pt-6 border-t-2 border-gray-200">
                <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-8 py-3 rounded-lg hover:bg-gray-600 transition font-semibold shadow">
                    Annuler
                </a>
                <button type="button" wire:click="confirmerSauvegarde" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 transition font-semibold shadow-lg">
                    💾 Enregistrer
                </button>
            </div>
        </div>
    </div>

    <!-- Modale de confirmation -->
    @if($showConfirmModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="annulerConfirmation">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4" wire:click.stop>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Confirmer l'enregistrement</h3>
            <p class="text-gray-600 mb-6">
                Êtes-vous sûr de vouloir enregistrer ces résultats pour le bureau <strong>{{ $bureauVote->lieuVote->nom }} - Bureau {{ $bureauVote->numero }}</strong> ?
            </p>
            <div class="bg-blue-50 border border-blue-200 rounded p-3 mb-4">
                <p class="text-sm text-blue-800">
                    <strong>Votants:</strong> {{ number_format($nombre_votants, 0, ',', ' ') }}<br>
                    <strong>Suffrage exprimé:</strong> {{ number_format($suffrage_exprime, 0, ',', ' ') }}<br>
                    <strong>Total votes candidats:</strong> {{ number_format(array_sum($votes), 0, ',', ' ') }}
                </p>
            </div>
            <div class="flex justify-end gap-3">
                <button wire:click="annulerConfirmation" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Annuler
                </button>
                <button wire:click="sauvegarder" class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition font-semibold">
                    ✓ Confirmer
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Indicateur de chargement local -->
    <div wire:loading wire:target="sauvegarder" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex flex-col items-center shadow-xl">
            <div class="spinner mb-4"></div>
            <p class="text-gray-700 font-semibold">Enregistrement en cours...</p>
        </div>
    </div>
</div>