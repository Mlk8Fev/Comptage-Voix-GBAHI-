<div>
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    {{ $userId ? '✏️ Modifier un représentant' : '➕ Créer un représentant' }}
                </h1>
                <p class="text-gray-600">Remplissez les informations du représentant et assignez-lui des bureaux</p>
            </div>
            <div class="text-right">
                <p class="text-lg font-bold text-blue-600">GBAHI DJOUA LUC</p>
                <p class="text-xs text-gray-500">Équipe de campagne</p>
            </div>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4 shadow">
            <p class="font-semibold">✓ {{ session('message') }}</p>
        </div>
    @endif

    <form wire:submit="sauvegarder">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informations personnelles</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nom complet *</label>
                    <input 
                        type="text" 
                        wire:model="name"
                        class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                    <input 
                        type="email" 
                        wire:model="email"
                        class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                    <input 
                        type="text" 
                        wire:model="telephone"
                        class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="+225 00 00 00 00 00"
                    >
                    @error('telephone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Mot de passe {{ $userId ? '(laisser vide pour ne pas changer)' : '*' }}
                    </label>
                    <input 
                        type="password" 
                        wire:model="password"
                        class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        {{ !$userId ? 'required' : '' }}
                    >
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                @if(!$userId || $password)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Confirmer le mot de passe *</label>
                        <input 
                            type="password" 
                            wire:model="password_confirmation"
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Assignation des bureaux *</h2>
            
            <!-- Filtre par commune -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filtrer par commune</label>
                <select wire:model.live="commune" class="w-full md:w-64 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Toutes les communes</option>
                    <option value="LILIYO">LILIYO</option>
                    <option value="OKROUYO">OKROUYO</option>
                </select>
            </div>

            @error('bureauxSelectionnes') 
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-4">
                    <p class="font-semibold">{{ $message }}</p>
                </div>
            @enderror

            <div class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg p-4">
                @foreach($bureaux as $lieuNom => $bureauxLieu)
                    <div class="mb-6">
                        <h3 class="font-bold text-gray-800 mb-3 text-lg">{{ $lieuNom }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($bureauxLieu as $bureau)
                                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-blue-50 transition {{ in_array($bureau->id, $bureauxSelectionnes) ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                    <input 
                                        type="checkbox" 
                                        wire:model="bureauxSelectionnes"
                                        value="{{ $bureau->id }}"
                                        class="mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    >
                                    <div>
                                        <span class="font-semibold text-gray-800">Bureau {{ $bureau->numero }}</span>
                                        <p class="text-xs text-gray-600">{{ $bureau->lieuVote->commune }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>{{ count($bureauxSelectionnes) }}</strong> bureau(x) sélectionné(s)
                </p>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('gestion-representants') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition font-semibold">
                Annuler
            </a>
            <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 transition font-semibold shadow-lg">
                💾 {{ $userId ? 'Modifier' : 'Créer' }} le représentant
            </button>
        </div>
    </form>
</div>
