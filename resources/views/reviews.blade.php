<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Avis - AvisPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white min-h-screen">

    <!-- Header -->
    <header class="border-b border-gray-800 bg-gray-900">
        <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold">Mes Reviews</h1>

            <button 
                type="button"
                onclick="logout()"
                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-xl text-sm font-semibold transition"
            >
                Déconnexion
            </button>
        </div>
    </header>

    <!-- Main -->
    <main class="max-w-5xl mx-auto px-6 py-10">

        <!-- Formulaire -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 mb-8 shadow-xl">
            <h2 class="text-xl font-semibold mb-4">Ajouter un avis</h2>

            <form id="reviewForm" class="flex flex-col md:flex-row gap-4">

                <input 
                    type="text"
                    id="content"
                    placeholder="Écrivez votre avis..."
                    class="flex-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                <button 
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-xl font-semibold transition"
                >
                    Envoyer
                </button>

            </form>
        </div>

        <!-- Liste -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Liste des avis</h2>

            <div 
                id="reviewsList"
                class="space-y-4"
            >
                <!-- Les reviews JS s'ajoutent ici -->
            </div>
        </div>

    </main>

<script src="/js/reviews.js"></script>

</body>
</html>