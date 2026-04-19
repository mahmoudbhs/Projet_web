# Projet Final - Analyse des Avis Clients

Plateforme Laravel 12 pour gerer des avis clients avec analyse IA.

## Fonctionnalites
- Auth API (`register`, `login`, `logout`) avec Sanctum
- Roles utilisateur (`admin`, `user`)
- CRUD complet des avis (`/api/reviews`)
- Analyse IA automatique a la creation/mise a jour des avis
- Endpoint IA manuel obligatoire (`POST /api/analyze`)
- Dashboard API (`GET /api/dashboard`)
- Frontend simple (pages login/register/reviews/stats) qui consomme l'API

## Installation
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

## Variables d'environnement IA
```env
GROQ_API_KEY=your_key
GROQ_MODEL=llama-3.1-8b-instant
```

## Tests
```bash
php artisan test
```

## Documentation API
Voir [docs/API.md](docs/API.md).

## Frontend separe
- `http://127.0.0.1:8000/frontend/login.html`
- `http://127.0.0.1:8000/frontend/register.html`
- `http://127.0.0.1:8000/frontend/reviews.html`
- `http://127.0.0.1:8000/frontend/stats.html`
