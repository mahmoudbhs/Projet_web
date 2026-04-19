<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - AvisPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 min-h-screen flex items-center justify-center text-white">

    <div class="w-full max-w-md bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold mb-2">Connexion</h1>
            <p class="text-gray-400">Accédez à votre espace AvisPro.</p>
        </div>

        <form id="loginForm" class="space-y-5">

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

            <p id="error" class="text-red-500 text-sm text-center"></p>

            <button 
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 transition rounded-xl py-3 font-semibold"
            >
                Se connecter
            </button>

        </form>

        <p class="text-center text-gray-400 text-sm mt-6">
            Pas encore inscrit ?
            <a href="/register" class="text-blue-500 hover:text-blue-400">
                Créer un compte
            </a>
        </p>

    </div>

<script src="/js/login.js"></script>

</body>
</html>