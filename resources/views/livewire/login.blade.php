<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">🗳️</div>
                <h2 class="text-3xl font-bold text-gray-800">Connexion</h2>
                <p class="text-gray-600 mt-2">Système de Comptage des Voix</p>
                <p class="text-blue-600 font-bold text-lg mt-2">Équipe de GBAHI DJOUA LUC</p>
            </div>

            @if($errors->has('email'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                    <p class="font-semibold">{{ $errors->first('email') }}</p>
                </div>
            @endif

            <form wire:submit="login" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse email
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        wire:model="email"
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="votre@email.com"
                    >
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        wire:model="password"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="••••••••"
                    >
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input 
                        id="remember" 
                        type="checkbox" 
                        wire:model="remember"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Se souvenir de moi
                    </label>
                </div>

                <div>
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition shadow-lg"
                    >
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
