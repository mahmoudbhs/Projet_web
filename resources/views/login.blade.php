<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <p><a href="/register">Creer un compte</a></p>

    <form id="loginForm">
        <input type="email" id="email" placeholder="Email" required><br><br>
        <input type="password" id="password" placeholder="Mot de passe" required><br><br>
        <p id="error" style="color:red;"></p>
        <button type="submit">Se connecter</button>
    </form>

    <script src="/js/login.js"></script>
</body>
</html>
