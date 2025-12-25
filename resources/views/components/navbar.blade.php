<nav class="bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-xl mb-6">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between py-4 gap-4">
            <div class="flex flex-col md:flex-row md:items-center space-y-1 md:space-y-0 md:space-x-2">
                <div class="flex items-center space-x-2">
                    <span class="text-3xl">🗳️</span>
                    <h1 class="text-xl md:text-2xl font-bold">Système de Comptage des Voix</h1>
                </div>
                <p class="text-sm md:text-base text-blue-100 font-semibold">Équipe de GBAHI DJOUA LUC</p>
            </div>
            
            @auth
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex flex-wrap gap-2">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-blue-800 font-semibold shadow-lg' : 'hover:bg-blue-500' }}">
                                🏠 Accueil
                            </a>
                            <a href="{{ route('stats') }}" class="px-4 py-2 rounded-lg transition {{ request()->routeIs('stats') ? 'bg-blue-800 font-semibold shadow-lg' : 'hover:bg-blue-500' }}">
                                📊 Statistiques
                            </a>
                            <a href="{{ route('liste-bureaux', ['commune' => 'LILIYO']) }}" class="px-4 py-2 rounded-lg transition {{ request()->routeIs('liste-bureaux') && request('commune') == 'LILIYO' ? 'bg-blue-800 font-semibold shadow-lg' : 'hover:bg-blue-500' }}">
                                🏛️ LILIYO
                            </a>
                            <a href="{{ route('liste-bureaux', ['commune' => 'OKROUYO']) }}" class="px-4 py-2 rounded-lg transition {{ request()->routeIs('liste-bureaux') && request('commune') == 'OKROUYO' ? 'bg-blue-800 font-semibold shadow-lg' : 'hover:bg-blue-500' }}">
                                🏛️ OKROUYO
                            </a>
                            <a href="{{ route('liste-bureaux', ['commune' => 'MAYO']) }}" class="px-4 py-2 rounded-lg transition {{ request()->routeIs('liste-bureaux') && request('commune') == 'MAYO' ? 'bg-blue-800 font-semibold shadow-lg' : 'hover:bg-blue-500' }}">
                                🏛️ MAYO
                            </a>
                            <a href="{{ route('historique') }}" class="px-4 py-2 rounded-lg transition {{ request()->routeIs('historique') ? 'bg-blue-800 font-semibold shadow-lg' : 'hover:bg-blue-500' }}">
                                📜 Historique
                            </a>
                            <a href="{{ route('gestion-representants') }}" class="px-4 py-2 rounded-lg transition {{ request()->routeIs('gestion-representants') || request()->routeIs('creer-representant') ? 'bg-blue-800 font-semibold shadow-lg' : 'hover:bg-blue-500' }}">
                                👥 Représentants
                            </a>
                        @else
                            <a href="{{ route('mes-bureaux') }}" class="px-4 py-2 rounded-lg transition {{ request()->routeIs('mes-bureaux') ? 'bg-blue-800 font-semibold shadow-lg' : 'hover:bg-blue-500' }}">
                                📋 Mes Bureaux
                            </a>
                        @endif
                    </div>
                    <div class="flex items-center gap-3 border-l border-blue-400 pl-4">
                        <span class="text-sm">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 rounded-lg text-sm transition">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-800 rounded-lg hover:bg-blue-900 transition">
                    Connexion
                </a>
            @endauth
        </div>
    </div>
</nav>

