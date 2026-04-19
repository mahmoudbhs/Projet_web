<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Avis</title>
</head>
<body>
    <h1>Dashboard - Statistiques</h1>
    <p><a href="/reviews">Retour aux avis</a></p>

    <section>
        <p>% Positifs: <b id="positivePercent">-</b></p>
        <p>% Negatifs: <b id="negativePercent">-</b></p>
        <p>Note moyenne: <b id="averageScore">-</b></p>
    </section>

    <section>
        <h2>Top 3 themes</h2>
        <ul id="topTopics"></ul>
    </section>

    <section>
        <h2>Avis recents</h2>
        <div id="recentReviews"></div>
    </section>

    <script src="/js/stats.js"></script>
</body>
</html>
