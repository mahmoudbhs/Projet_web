<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - AvisPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 min-h-screen flex items-center justify-center text-white">

    <div class="w-full max-w-md bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold mb-2">Créer un compte</h1>
            <p class="text-gray-400">Rejoignez AvisPro et gérez vos avis clients.</p>
        </div>

        <form id="registerForm" class="space-y-5">

            <div>
                <label class="block text-sm text-gray-300 mb-2">Nom</label>
                <input 
                    type="text" 
                    id="name" 
                    placeholder="Votre nom"
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-2">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    placeholder="email@exemple.com"
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-2">Mot de passe</label>
                <input 
                    type="password" 
                    id="password" 
                    placeholder="••••••••"
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-2">Confirmer le mot de passe</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    placeholder="••••••••"
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 transition rounded-xl py-3 font-semibold"
            >
                S'inscrire
            </button>

        </form>

        <p id="error" class="text-red-500 text-sm mt-4 text-center"></p>

        <p class="text-center text-gray-400 text-sm mt-6">
            Déjà un compte ?
            <a href="/login" class="text-blue-500 hover:text-blue-400">Connexion</a>
        </p>

    </div>

<script src="/js/register.js"></script>

</body>
</html>