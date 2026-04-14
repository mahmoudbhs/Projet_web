<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<form id="registerForm">
  <input type="text" id="name" placeholder="Nom">
  <input type="email" id="email" placeholder="Email">
  <input type="password" id="password" placeholder="Password">
  <input type="password" id="password_confirmation" placeholder="Confirm Password">

  <button type="submit">S'inscrire</button>
</form>

<p id="error" style="color:red;"></p>

<script src="/js/register.js"></script>

</body>
</html>