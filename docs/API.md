# API Documentation

Base URL: `http://127.0.0.1:8000/api`

## Auth

### Register
- `POST /register`
- Body:
```json
{
  "name": "Alice",
  "email": "alice@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

### Login
- `POST /login`
- Body:
```json
{
  "email": "alice@example.com",
  "password": "password123"
}
```

### Logout
- `POST /logout` (Bearer token required)

## AI

### Analyze text (mandatory)
- `POST /analyze`
- Body:
```json
{
  "text": "Livraison rapide mais prix eleve"
}
```
- Response:
```json
{
  "sentiment": "neutral",
  "score": 62,
  "topics": ["delivery", "price"]
}
```

## Reviews (Bearer token required)

### Create review
- `POST /reviews`
- Body:
```json
{
  "content": "Service parfait et livraison rapide"
}
```

### List reviews
- `GET /reviews`

### Get one review
- `GET /reviews/{id}`

### Update review
- `PUT /reviews/{id}`
- Body:
```json
{
  "content": "Nouveau texte avis"
}
```

### Delete review
- `DELETE /reviews/{id}`

## Dashboard (Bearer token required)

### Global statistics
- `GET /dashboard`
- Response:
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
  "recent_reviews": []
}
```
