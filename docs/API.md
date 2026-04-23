# API Documentation

Base URL: `http://127.0.0.1:8000/api`

Authentification: Bearer token via Laravel Sanctum.

## Auth

### Register

- `POST /register`

Body:

```json
{
  "name": "Alice",
  "email": "alice@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

Remarques:

- le role est attribue automatiquement par le backend
- si l'email appartient a la liste admin autorisee, l'utilisateur est cree avec le role `admin`
- sinon il est cree avec le role `user`

Exemple de reponse:

```json
{
  "token": "1|exampletoken",
  "user": {
    "id": 1,
    "name": "Alice",
    "email": "alice@example.com",
    "role": "user"
  }
}
```

### Login

- `POST /login`

Body:

```json
{
  "email": "alice@example.com",
  "password": "password123"
}
```

Exemple de reponse:

```json
{
  "token": "2|exampletoken",
  "user": {
    "id": 1,
    "name": "Alice",
    "email": "alice@example.com",
    "role": "user"
  }
}
```

### Logout

- `POST /logout`
- Bearer token requis

Exemple de reponse:

```json
{
  "message": "Logged out"
}
```

## AI

### Analyze text

- `POST /analyze`

Body:

```json
{
  "text": "Livraison rapide mais prix eleve"
}
```

Exemple de reponse:

```json
{
  "sentiment": "neutral",
  "score": 62,
  "topics": ["delivery", "price"]
}
```

## Reviews

Toutes les routes suivantes demandent un Bearer token.

### Create review

- `POST /reviews`

Body:

```json
{
  "content": "Service parfait et livraison rapide"
}
```

Exemple de reponse:

```json
{
  "id": 1,
  "content": "Service parfait et livraison rapide",
  "user_id": 1,
  "sentiment": "positive",
  "score": 90,
  "topics": ["delivery", "support"],
  "user": {
    "id": 1,
    "name": "Alice",
    "email": "alice@example.com",
    "role": "user"
  }
}
```

### List reviews

- `GET /reviews`

Remarque:

- la liste contient aussi la relation `user`

### Get one review

- `GET /reviews/{id}`

### Update review

- `PUT /reviews/{id}`
- `PATCH /reviews/{id}`

Body:

```json
{
  "content": "Nouveau texte avis"
}
```

Remarque:

- l'analyse IA est relancee automatiquement lors de la mise a jour

### Delete review

- `DELETE /reviews/{id}`

Remarque:

- suppression autorisee pour l'admin ou le proprietaire de l'avis

## Dashboard

- `GET /dashboard`
- Bearer token requis

Exemple de reponse:

```json
{
  "positive_percent": 55.5,
  "negative_percent": 20.0,
  "top_topics": [
    { "topic": "delivery", "count": 12 },
    { "topic": "price", "count": 9 },
    { "topic": "quality", "count": 7 }
  ],
  "average_score": 67.3,
  "recent_reviews": [
    {
      "id": 1,
      "content": "Service parfait",
      "sentiment": "positive",
      "score": 95,
      "topics": ["support", "quality"],
      "user": {
        "id": 1,
        "name": "Alice",
        "email": "alice@example.com",
        "role": "user"
      }
    }
  ]
}
```

## Roles admin

Emails admin reconnus a l'inscription:

- `myrasaid@admin.com`
- `mahmoudbhs@admin.com`
- `abdeldjalil@admin.com`
- `wilem@admin.com`

## Frontend statique

Pages disponibles:

- `/frontend/login.html`
- `/frontend/register.html`
- `/frontend/reviews.html`
- `/frontend/stats.html`
- `/frontend/admin.html`

Redirection frontend actuelle:

- un `admin` est redirige vers `/frontend/admin.html`
- un `user` est redirige vers `/frontend/reviews.html`

Note:

- la route web `/admin` redirige aussi vers `/frontend/admin.html`
