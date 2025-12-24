<div>
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold text-gray-800">📊 Statistiques et Résultats</h1>
            <div class="text-right">
                <p class="text-lg font-bold text-blue-600">GBAHI DJOUA LUC</p>
                <p class="text-xs text-gray-500">Équipe de campagne</p>
            </div>
        </div>
        
        <!-- Filtre par commune -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Filtrer par commune</label>
            <select wire:model.live="commune" class="w-full md:w-64 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Toutes les communes</option>
                <option value="LILIYO">LILIYO</option>
                <option value="OKROUYO">OKROUYO</option>
            </select>
        </div>
    </div>

    <!-- Statistiques globales -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-5">
            <h3 class="text-sm font-semibold mb-2 opacity-90">Total inscrits</h3>
            <p class="text-3xl font-bold">{{ number_format($totalInscrits, 0, ',', ' ') }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-lg p-5">
            <h3 class="text-sm font-semibold mb-2 opacity-90">Total votants</h3>
            <p class="text-3xl font-bold">{{ number_format($totalVotants, 0, ',', ' ') }}</p>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl shadow-lg p-5">
            <h3 class="text-sm font-semibold mb-2 opacity-90">Taux participation</h3>
            <p class="text-3xl font-bold">{{ number_format($tauxParticipation, 2) }}%</p>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-red-600 text-white rounded-xl shadow-lg p-5">
            <h3 class="text-sm font-semibold mb-2 opacity-90">Bulletins nuls</h3>
            <p class="text-3xl font-bold">{{ number_format($totalBulletinsNuls, 0, ',', ' ') }}</p>
        </div>
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-xl shadow-lg p-5">
            <h3 class="text-sm font-semibold mb-2 opacity-90">Bulletins blancs</h3>
            <p class="text-3xl font-bold">{{ number_format($totalBulletinsBlancs, 0, ',', ' ') }}</p>
        </div>
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-xl shadow-lg p-5">
            <h3 class="text-sm font-semibold mb-2 opacity-90">Suffrage exprimé</h3>
            <p class="text-3xl font-bold">{{ number_format($totalSuffrageExprime, 0, ',', ' ') }}</p>
        </div>
    </div>

    <!-- Résultats par candidat -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Résultats par candidat</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-100 to-gray-50 border-b-2 border-gray-200">
                        <th class="text-left p-4 font-bold text-gray-700">Rang</th>
                        <th class="text-left p-4 font-bold text-gray-700">Candidat</th>
                        <th class="text-left p-4 font-bold text-gray-700">Parti</th>
                        <th class="text-right p-4 font-bold text-gray-700">Voix</th>
                        <th class="text-right p-4 font-bold text-gray-700">Pourcentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidats as $index => $candidat)
                        <tr class="border-b hover:bg-blue-50 transition {{ $index === 0 ? 'bg-yellow-50' : '' }}">
                            <td class="p-4">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $index === 0 ? 'bg-yellow-400 text-white font-bold' : 'bg-gray-200 text-gray-700' }}">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="p-4 font-semibold text-gray-800">{{ $candidat->nom_complet }}</td>
                            <td class="p-4 text-gray-600">{{ $candidat->parti ?? '-' }}</td>
                            <td class="p-4 text-right font-bold text-gray-800">{{ number_format($candidat->total_voix, 0, ',', ' ') }}</td>
                            <td class="p-4 text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $totalSuffrageExprime > 0 ? number_format(($candidat->total_voix / $totalSuffrageExprime) * 100, 2) : 0 }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
