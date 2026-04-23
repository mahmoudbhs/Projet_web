# Projet Final - Analyse des Avis Clients

Membres du groupe: Said Myra
                   Benhassine Mahmoud
                   Haddab Wilem
                   Tarek Abdel Djalil

Application Laravel 12 pour gerer des avis clients, authentifier les utilisateurs via Sanctum et analyser automatiquement le sentiment d'un avis avec une IA externe ou un fallback local.

## Apercu

Le projet expose:

- une API REST sous `/api`
- des pages web sous `/`, `/login`, `/register`, `/reviews`, `/stats`
- une route `/admin` qui redirige vers la page statique admin
- un frontend statique dans `public/frontend`

L'analyse d'avis passe par `App\Services\SentimentService`:

- si `GROQ_API_KEY` est configuree, le projet appelle l'API Groq
- sinon, une analyse locale simple est utilisee comme fallback

## Fonctionnalites

- Authentification API avec Sanctum: `register`, `login`, `logout`
- Gestion des roles `user` et `admin`
- Attribution automatique du role `admin` pour certains emails autorises
- CRUD des avis clients via `/api/reviews`
- Analyse automatique du sentiment, du score et des sujets a la creation et a la mise a jour
- Endpoint d'analyse manuelle: `POST /api/analyze`
- Tableau de bord statistique via `GET /api/dashboard`
- Interfaces web pour se connecter, s'inscrire, consulter les avis, gerer l'administration et voir les statistiques

## Stack technique

- PHP 8.2+
- Laravel 12
- Laravel Sanctum
- Vite
- Tailwind CSS 4
- API Groq pour l'analyse IA
- SQLite par defaut

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run build
php artisan serve
```

## Demarrage rapide

Pour lancer l'environnement de dev complet:

```bash
composer run dev
```

Cette commande demarre notamment:

- le serveur Laravel
- l'ecoute de la queue
- les logs
- Vite en mode developpement

## Base de donnees

Le fichier `.env.example` est configure par defaut pour SQLite:

```env
DB_CONNECTION=sqlite
```

Le fichier utilise par defaut est:

- `database/database.sqlite`

Pensez a creer ce fichier si necessaire avant `php artisan migrate`.

## Configuration IA

Variables d'environnement utilisees:

```env
GROQ_API_KEY=your_key
GROQ_MODEL=llama-3.1-8b-instant
```

Sans cle API, l'application continue a fonctionner grace au fallback local dans `SentimentService`.

## Comptes et roles

Lors de l'inscription, le role est attribue automatiquement:

- `admin` si l'email fait partie de la liste admin
- `user` sinon

Emails admin reconnus actuellement:

- `myrasaid@admin.com`
- `mahmoudbhs@admin.com`
- `abdeldjalil@admin.com`
- `wilem@admin.com`

Le seeder `AdminUserSeeder` existe toujours, mais le projet attribue maintenant aussi automatiquement le role admin a l'inscription pour ces emails.

## Navigation frontend

Apres connexion ou inscription:

- un `admin` est redirige vers `/frontend/admin.html`
- un `user` est redirige vers `/frontend/reviews.html`

La page admin statique utilise `public/js/admin.js` et permet:

- de charger tous les avis
- d'afficher quelques compteurs utiles
- de supprimer un avis

## Pages disponibles

Pages Laravel / web:

- `http://127.0.0.1:8000/`
- `http://127.0.0.1:8000/login`
- `http://127.0.0.1:8000/register`
- `http://127.0.0.1:8000/reviews`
- `http://127.0.0.1:8000/stats`

Redirection:

- `http://127.0.0.1:8000/admin` redirige vers `http://127.0.0.1:8000/frontend/admin.html`

Frontend statique:

- `http://127.0.0.1:8000/frontend/login.html`
- `http://127.0.0.1:8000/frontend/register.html`
- `http://127.0.0.1:8000/frontend/reviews.html`
- `http://127.0.0.1:8000/frontend/stats.html`
- `http://127.0.0.1:8000/frontend/admin.html`

## API principale

Authentification:

- `POST /api/register`
- `POST /api/login`
- `POST /api/logout`

Analyse:

- `POST /api/analyze`

Avis:

- `GET /api/reviews`
- `GET /api/reviews/{id}`
- `POST /api/reviews`
- `PUT /api/reviews/{id}`
- `PATCH /api/reviews/{id}`
- `DELETE /api/reviews/{id}`

Statistiques:

- `GET /api/dashboard`

## Tests

```bash
php artisan test
```

Le projet contient notamment un test d'integration pour:

- l'endpoint `/api/analyze`
- la creation d'un avis avec analyse automatique
- le dashboard `/api/dashboard`

## Documentation supplementaire

Voir [docs/API.md](docs/API.md) pour les exemples de requetes et reponses.
