<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avis Clients</title>
</head>
<body>
    <h1>Plateforme Avis Clients</h1>

    <p>
        <a href="/stats">Voir les statistiques</a>
        <button type="button" onclick="logout()">Deconnexion</button>
    </p>

    <h2>Ajouter un avis</h2>
    <form id="reviewForm">
        <textarea id="content" rows="4" cols="60" placeholder="Votre avis..." required></textarea>
        <br>
        <button type="submit">Envoyer</button>
    </form>

    <h2>Liste des avis</h2>
    <div id="reviewsList"></div>

    <script src="/js/reviews.js"></script>
</body>
</html>
