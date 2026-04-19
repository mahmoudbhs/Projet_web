<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AvisIA – Analyse intelligente des avis clients</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .hero-text { animation: fadeInUp 0.6s ease both; }
        .hero-sub  { animation: fadeInUp 0.6s 0.15s ease both; }
        .hero-cta  { animation: fadeInUp 0.6s 0.25s ease both; }
        .feature-card { animation: fadeInUp 0.5s ease both; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-8px); }
        }
        .float { animation: float 4s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 overflow-x-hidden">

    <!-- Déco bg -->
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -top-80 -right-80 w-[700px] h-[700px] bg-violet-700/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-80 -left-80 w-[700px] h-[700px] bg-violet-900/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[400px] h-[400px] bg-violet-800/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Navbar -->
    <header class="relative z-10 border-b border-slate-800/50">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-gradient-to-br from-violet-500 to-violet-700 rounded-lg flex items-center justify-center shadow-md shadow-violet-600/30">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <span class="font-bold text-white text-lg">AvisIA</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="/frontend/login.html"
                   class="text-slate-400 hover:text-white text-sm font-medium transition-colors px-3 py-1.5 rounded-lg hover:bg-slate-800">
                    Connexion
                </a>
                <a href="/frontend/register.html"
                   class="bg-gradient-to-r from-violet-600 to-violet-700 hover:from-violet-500 hover:to-violet-600
                          text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all shadow-md shadow-violet-600/20">
                    Créer un compte
                </a>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative z-10 max-w-6xl mx-auto px-6 pt-24 pb-20 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-violet-500/10 border border-violet-500/30 rounded-full text-violet-400 text-xs font-medium mb-8">
            <span class="w-1.5 h-1.5 rounded-full bg-violet-400 animate-pulse inline-block"></span>
            Propulsé par Llama 3 via GROQ AI
        </div>

        <h1 class="hero-text text-5xl sm:text-6xl font-extrabold text-white leading-tight tracking-tight mb-6">
            Analysez vos avis clients<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-violet-400 to-violet-600">avec l'intelligence artificielle</span>
        </h1>

        <p class="hero-sub max-w-2xl mx-auto text-slate-400 text-lg leading-relaxed mb-10">
            Déposez vos retours clients et laissez l'IA détecter automatiquement le sentiment,
            le score de satisfaction et les thèmes clés abordés.
        </p>

        <div class="hero-cta flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/frontend/register.html"
               class="flex items-center gap-2 bg-gradient-to-r from-violet-600 to-violet-700 hover:from-violet-500 hover:to-violet-600
                      text-white font-semibold px-8 py-4 rounded-2xl transition-all duration-200 shadow-xl shadow-violet-600/25
                      hover:-translate-y-1 hover:shadow-violet-500/30 text-base">
                Commencer gratuitement
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            <a href="/frontend/login.html"
               class="flex items-center gap-2 text-slate-400 hover:text-white font-medium px-6 py-4 rounded-2xl
                      border border-slate-700 hover:border-slate-600 transition-all text-base hover:-translate-y-0.5">
                Se connecter
            </a>
        </div>

        <!-- Preview card flottante -->
        <div class="float mt-16 inline-block">
            <div class="bg-slate-900/80 backdrop-blur border border-slate-700/60 rounded-2xl p-5 text-left max-w-sm mx-auto shadow-2xl">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-full bg-violet-600/30 border border-violet-500/40 flex items-center justify-center text-violet-400 font-bold text-xs">JD</div>
                    <div>
                        <p class="text-white text-sm font-medium">Jean Dupont</p>
                        <p class="text-slate-500 text-xs">il y a 2 minutes</p>
                    </div>
                    <span class="ml-auto px-2.5 py-1 bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 rounded-full text-xs font-semibold">Positif</span>
                </div>
                <p class="text-slate-300 text-sm leading-relaxed">"Livraison rapide et produit excellent, je recommande vivement !"</p>
                <div class="mt-3">
                    <div class="flex justify-between text-xs text-slate-500 mb-1"><span>Score IA</span><span>87/100</span></div>
                    <div class="h-1.5 bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width:87%"></div>
                    </div>
                </div>
                <div class="flex gap-1.5 mt-3">
                    <span class="px-2 py-0.5 bg-slate-800 text-slate-400 border border-slate-700 rounded text-xs">livraison</span>
                    <span class="px-2 py-0.5 bg-slate-800 text-slate-400 border border-slate-700 rounded text-xs">qualité</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="relative z-10 max-w-6xl mx-auto px-6 py-20 border-t border-slate-800/50">
        <h2 class="text-center text-2xl font-bold text-white mb-12">Tout ce dont vous avez besoin</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Feature 1 -->
            <div class="feature-card bg-slate-900/50 border border-slate-800 rounded-2xl p-6 hover:border-violet-500/30 transition-colors" style="animation-delay:0.05s">
                <div class="w-11 h-11 rounded-xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-white font-semibold mb-2">Analyse IA automatique</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Chaque avis est analysé en temps réel par Llama 3 pour détecter le sentiment et extraire les thèmes clés.</p>
            </div>
            <!-- Feature 2 -->
            <div class="feature-card bg-slate-900/50 border border-slate-800 rounded-2xl p-6 hover:border-emerald-500/30 transition-colors" style="animation-delay:0.1s">
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-white font-semibold mb-2">Dashboard analytique</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Visualisez vos indicateurs clés : taux de satisfaction, score moyen et top des thèmes abordés.</p>
            </div>
            <!-- Feature 3 -->
            <div class="feature-card bg-slate-900/50 border border-slate-800 rounded-2xl p-6 hover:border-blue-500/30 transition-colors" style="animation-delay:0.15s">
                <div class="w-11 h-11 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-white font-semibold mb-2">Gestion multi-utilisateurs</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Système de rôles complet avec administrateurs pouvant gérer l'ensemble des avis de la plateforme.</p>
            </div>
        </div>
    </section>

    <!-- CTA final -->
    <section class="relative z-10 max-w-6xl mx-auto px-6 pb-20">
        <div class="bg-gradient-to-r from-violet-900/40 to-violet-800/20 border border-violet-700/30 rounded-3xl p-12 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Prêt à analyser vos avis ?</h2>
            <p class="text-slate-400 mb-8 max-w-lg mx-auto">Créez votre compte gratuitement et commencez à analyser vos retours clients en quelques secondes.</p>
            <a href="/frontend/register.html"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-violet-700 hover:from-violet-500 hover:to-violet-600
                      text-white font-semibold px-8 py-4 rounded-2xl transition-all duration-200 shadow-xl shadow-violet-600/25
                      hover:-translate-y-1 text-base">
                Créer mon compte gratuitement
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-slate-800/50 py-6 text-center">
        <p class="text-slate-600 text-sm">AvisIA · Analyse propulsée par Llama 3 via GROQ</p>
    </footer>

    <script>
        // Redirect si déjà connecté
        if (localStorage.getItem("token")) {
            window.location.href = "/frontend/reviews.html";
        }
    </script>
</body>
</html>
