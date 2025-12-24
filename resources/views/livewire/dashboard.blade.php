<div>
    <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Bienvenue</h1>
                <p class="text-gray-600 text-lg">Système de comptage des voix - Élections Législatives</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-blue-600 mb-1">GBAHI DJOUA LUC</p>
                <p class="text-sm text-gray-500">Équipe de campagne</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('stats') }}" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
            <div class="text-4xl mb-3">📊</div>
            <h3 class="text-xl font-bold mb-2">Statistiques</h3>
            <p class="text-blue-100">Voir les chiffres et résultats par candidat</p>
        </a>

        <a href="{{ route('liste-bureaux', ['commune' => 'LILIYO']) }}" class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
            <div class="text-4xl mb-3">🏛️</div>
            <h3 class="text-xl font-bold mb-2">Bureaux LILIYO</h3>
            <p class="text-green-100">Gérer les bureaux de vote de LILIYO</p>
        </a>

        <a href="{{ route('liste-bureaux', ['commune' => 'OKROUYO']) }}" class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
            <div class="text-4xl mb-3">🏛️</div>
            <h3 class="text-xl font-bold mb-2">Bureaux OKROUYO</h3>
            <p class="text-purple-100">Gérer les bureaux de vote d'OKROUYO</p>
        </a>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl shadow-lg p-6">
            <div class="text-4xl mb-3">ℹ️</div>
            <h3 class="text-xl font-bold mb-2">Information</h3>
            <p class="text-orange-100 text-sm">Utilisez le menu de navigation pour accéder aux différentes sections</p>
        </div>
    </div>
</div>
