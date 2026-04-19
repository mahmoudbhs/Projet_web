<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - AvisPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white min-h-screen">

    <!-- Header -->
    <header class="bg-gray-900 border-b border-gray-800">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Admin Panel</h1>
                <p class="text-sm text-gray-400">Gestion globale des avis clients</p>
            </div>

            <div class="px-4 py-2 bg-blue-600 rounded-xl text-sm font-semibold">
                Administrateur
            </div>
        </div>
    </header>

    <!-- Main -->
    <main class="max-w-6xl mx-auto px-6 py-10">

        <!-- Stats -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-xl mb-8">
          <div class="grid md:grid-cols-3 gap-6 mb-10">

            <h3 class="text-xl font-semibold">Nombre total d'avis : {{ $totalReviews }}</h3>
            <h3 class="text-xl font-semibold">Avis d'aujourd'hui : {{ $todayReviews }}</h3>

          </div>
        </div>

        <!-- Reviews -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-xl mb-8">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold">Toutes les reviews</h2>

                <input 
                    type="text"
                    placeholder="Rechercher..."
                    class="bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div 
                id="reviewsList"
                class="space-y-4"
            >
                <!-- Reviews injectées par JS -->
            </div>

        </div>

    </main>

<script src="/js/admin.js"></script>

</body>
</html>