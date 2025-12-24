<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptage des Voix - Équipe GBAHI DJOUA LUC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @livewireStyles
    <style>
        /* Indicateur de chargement */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    @auth
        <x-navbar />
    @endauth
    
    <!-- Indicateur de chargement global -->
    <div wire:loading.class="block" wire:loading.class.remove="hidden" class="hidden loading-overlay">
        <div class="bg-white rounded-lg p-6 flex flex-col items-center">
            <div class="spinner mb-4"></div>
            <p class="text-gray-700 font-semibold">Chargement...</p>
        </div>
    </div>
    
    <main class="container mx-auto px-4 pb-8">
        {{ $slot }}
    </main>
    
    @livewireScripts
</body>
</html>

