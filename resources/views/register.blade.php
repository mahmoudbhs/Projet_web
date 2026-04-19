<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <p><a href="/login">J'ai deja un compte</a></p>

    <form id="registerForm">
        <input type="text" id="name" placeholder="Nom" required><br><br>
        <input type="email" id="email" placeholder="Email" required><br><br>
        <input type="password" id="password" placeholder="Mot de passe (8 caracteres min)" required><br><br>
        <input type="password" id="password_confirmation" placeholder="Confirmer mot de passe" required><br><br>
        <button type="submit">S'inscrire</button>
    </form>

    <p id="error" style="color:red;"></p>

    <script src="/js/register.js"></script>
</body>
</html>
